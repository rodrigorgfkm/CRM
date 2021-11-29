<?php
/*function fecha($date){
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
}*/
$db =& JFactory::getDBO();

	$mes = JRequest::getVar('filtro_mes', '', 'post');
	$anio = JRequest::getVar('filtro_anio', '', 'post');
	$campo = JRequest::getVar('filtro_campo', '', 'post');
	$estado = JRequest::getVar('filtro_estado', '', 'post');
	$cadena = JRequest::getVar('filtro_cadena', '', 'post');
	$tipo = JRequest::getVar('filtro_tipo', '', 'post');
	$sucursal = JRequest::getVar('filtro_sucursal', '', 'post');
	$usuario = JRequest::getVar('filtro_usuario', '', 'post');

	$where = 'WHERE 1';
	if($cadena != '')
		$where.= ' AND '.$campo.' LIKE "%'.$cadena.'%"';
	if($mes != '' && $anio != '')
		$where.= ' AND f.fecha >= "'.$anio.'-'.$mes.'-01" AND f.fecha <= "'.$anio.'-'.$mes.'-31"';
	if($estado != '')
		$where.= ' AND f.estado = "'.$estado.'"';
	if($tipo != '')
		$where.= ' AND ff.id = "'.$tipo.'"';
	if($sucursal != '')
		$where.= ' AND s.id = "'.$sucursal.'"';
	if($usuario != '')
		$where.= ' AND f.id_usuario = "'.$usuario.'"';
	
	$query = 'SELECT f.*, i.empresa, l.autorizacion, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla 
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id 
	LEFT JOIN #__erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON l.id_factura = ff.id 
	'.$where.' 
	ORDER BY f.fecha';
	$db->setQuery($query);
	$facturas = $db->loadObjectList();


$archivo = 'components/com_erp/views/facturacion/tmpl/libro_ventas.txt';
$file=fopen($archivo, 'a') or die('Problemas');

$n = 0;


//while ($rw = $rs->fetch_assoc()){
foreach($facturas as $f){
	$n++;
	if($rw['estado'] == 'V'){
		$val_total = $f->total;
		$val_ice = $f->ice;
		$val_exce = $f->exce;
		$val_grav = $f->grav;
		$val_desc = $f->desc;
		$nombre = utf8_encode($f->nombre);
		$nit = $f->nit;
		}else{
		$nombre = '';
		$nit = 0;
		$val_total = 0;
		if($f->ice != '')
			$val_ice = 0;
			else
			$val_ice = '';
		if($f->exce != '')
			$val_exce = 0;
			else
			$val_exce = '';
		if($f->grav != '')
			$val_grav = 0;
			else
			$val_grav = '';
		if($f->desc != '')
			$val_desc = 0;
			else
			$val_desc = '';
		}
	
	$subtotal = $val_total - $val_ice - $val_exce - $val_grav;
	$total = $subtotal - $val_desc;
	
	fputs($file, '3|'.$n.'|'.fecha($rw['fecha']).'|'.$rw['numero'].'|'.$rw['autorizacion'].'|'.$rw['estado'].'|'.$nit.'|'.$nombre.'|'.round($val_total, 2).'|'.round($val_ice, 2).'|'.round($val_exce, 2).'|'.round($val_grav, 2).'|'.round($subtotal, 2).'|'.round($val_desc, 2).'|'.round($total, 2).'|'.round(($total * 0.13), 2).'|'.$rw['codigo'].'
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