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

	if($_POST['filtro_rango'] == 1){
		$fecha_ini = $_POST['filtro_fecha_ini'];
		$fecha_fin = $_POST['filtro_fecha_fin'];
		$w = ' AND c.fecha_emision <= "'.$fecha_fin.'" AND c.fecha_emision >= "'.$fecha_ini.'"';
		}else{
		$mes = $_POST['filtro_mes'];
		$anio = $_POST['filtro_anio'];
		$w = ' AND c.fecha_emision LIKE "'.$anio.'-'.$mes.'-%"';
		}
	
	$sucursal = $_POST['filtro_sucursal'];
	$campo = $_POST['filtro_campo'];
	$cadena = $_POST['filtro_cadena'];

	$where = 'WHERE 1';
	if($cadena != '')
		$where.= ' AND '.$campo.' LIKE "%'.$cadena.'%"';
	if($fecha_ini != '' || $mes != '')
		$where.= $w;
	
	$query = 'SELECT c.*, u.name, cd.id_comprobante 
	FROM '.$pre.'erp_facturacion_compras AS c 
	LEFT JOIN '.$pre.'users AS u ON c.id_usuario = u.id
	LEFT JOIN '.$pre.'erp_conta_comprobante_detalle AS cd ON c.id = cd.id_comprobante 
	'.$where.' 
    GROUP BY c.id
	ORDER BY c.fecha_emision ASC';
	$rs = $conn->query($query);

    //echo $query;
$archivo = 'libro_compras.txt';
$file=fopen($archivo, 'a') or die('Problemas');
  //vamos añadiendo el contenido
  
  
$n = 0;
//echo "hola";
while ($rw = $rs->fetch_assoc()){
	$n++;
	$subtotal = $rw['total'] - $rw['nocredito'];
	$total = $subtotal - $rw['descuento'];
	/*echo 'entra';
    echo '</br>';*/
	fputs($file, '1|'.$n.'|'.fecha($rw['fecha_emision']).'|'.$rw['nit'].'|'.utf8_encode($rw['empresa']).'|'.$rw['numero'].'|'.$rw['dui'].'|'.$rw['autorizacion'].'|'.round($rw['total'], 2).'|'.round($rw['nocredito'], 2).'|'.round($subtotal, 2).'|'.round($rw['descuento'], 2).'|'.round($total, 2).'|'.round(($total * 0.13), 2).'|'.$rw['codigo'].'|'.$rw['tipo']);
	}
  
  header ('Content-Disposition: attachment; filename='.$archivo); 
  header ('Content-Type: application/octet-stream'); 
  header ('Content-Length: '.filesize($archivo)); 
  readfile($archivo); 
  
  $fa=fopen($archivo, 'w+');
  fwrite($fa, '');
  fclose($fa);
  ?>