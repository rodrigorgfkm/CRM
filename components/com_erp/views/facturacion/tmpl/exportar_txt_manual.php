<?php
function fecha($date){
	$d = explode('-',$date);
	return $d[2].'/'.$d[1].'/'.$d[0];
	}

include_once('../../../../../configuration.php');
$config = new JConfig();
$bd_host = $config->host;
$bd_user = $config->user;
$bd_pass = $config->password;
$bd_base = $config->db;

$conn = new mysqli($bd_host, $bd_user, $bd_pass, $bd_base);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pre = $config->dbprefix;

	$fecha_ini = $_POST['filtro_fecha_ini'];
	$fecha_fin = $_POST['filtro_fecha_fin'];
	$campo = $_POST['filtro_campo'];
	$estado = $_POST['filtro_estado'];
	$cadena = $_POST['filtro_cadena'];
	$tipo = $_POST['filtro_tipo'];
	$sucursal = $_POST['filtro_sucursal'];
	$usuario = $_POST['filtro_usuario'];

	$where = 'WHERE 1';
	if($cadena != '')
		$where.= ' AND '.$campo.' LIKE "%'.$cadena.'%"';
	if($fecha_ini != '')
		$where.= ' AND f.fecha >= "'.$fecha_ini.'" AND f.fecha <= "'.$fecha_fin.'"';
	if($estado != '')
		$where.= ' AND f.estado = "'.$estado.'"';
	if($tipo != '')
		$where.= ' AND ff.id = "'.$tipo.'"';
	if($sucursal != '')
		$where.= ' AND s.id = "'.$sucursal.'"';
	if($usuario != '')
		$where.= ' AND f.id_usuario = "'.$usuario.'"';
	
	$query = 'SELECT f.*, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla 
	FROM '.$pre.'erp_facturacion_manual AS f 
	LEFT JOIN '.$pre.'erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN '.$pre.'erp_facturacion_factura AS ff ON f.id_tipo = ff.id 
	'.$where.' 
	ORDER BY f.fecha, f.numero';
	$rs = $conn->query($query);


$archivo = 'libro_ventas_manual.txt';
$file=fopen($archivo, 'a') or die('Problemas');

$n = 0;

while ($rw = $rs->fetch_assoc()){
	$n++;
	if($rw['estado'] == 'V'){
		$val_total = $rw['total'];
		$val_ice = $rw['ice'];
		$val_exce = $rw['exce'];
		$val_grav = $rw['grav'];
		$val_desc = $rw['desc'];
		$nombre = utf8_encode($rw['nombre']);
		$nit = $rw['nit'];
		}else{
		$nombre = '';
		$nit = 0;
		$val_total = 0;
		if($rw['ice'] != '')
			$val_ice = 0;
			else
			$val_ice = '';
		if($rw['exce'] != '')
			$val_exce = 0;
			else
			$val_exce = '';
		if($rw['grav'] != '')
			$val_grav = 0;
			else
			$val_grav = '';
		if($rw['desc'] != '')
			$val_desc = 0;
			else
			$val_desc = '';
		}
	
	$subtotal = $val_total - $val_ice - $val_exce - $val_grav;
	$total = $subtotal - $val_desc;
	
	fputs($file, '3|'.$n.'|'.fecha($rw['fecha']).'|'.$rw['numero'].'|'.$rw['autorizacion'].'|'.$rw['estado'].'|'.$nit.'|'.$nombre.'|'.round($val_total, 2).'|'.round($val_ice, 2).'|'.round($val_exce, 2).'|'.round($val_grav, 2).'|'.round($subtotal, 2).'|'.round($val_desc, 2).'|'.round($total, 2).'|'.round(($total * 0.13), 2).'|0
');
}
  
  header ('Content-Disposition: attachment; filename='.$archivo); 
  header ('Content-Type: application/octet-stream'); 
  header ('Content-Length: '.filesize($archivo)); 
  readfile($archivo); 
  
  $fa=fopen($archivo, 'w+');
  fwrite($fa, '');
  fclose($fa);
?>