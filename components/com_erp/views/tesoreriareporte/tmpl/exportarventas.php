<?php
include_once('../../../../../configuration.php');
$config = new JConfig();
$bd_host = $config->host;
$bd_user = $config->user;
$bd_pass = $config->password;
$bd_base = $config->db;
$conn = new mysqli($bd_host, $bd_user, $bd_pass, $bd_base);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel(); 
// Establecer propiedades

$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Libro de Ventas")
->setSubject("Libro de Ventas")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Libro de Compras y Ventas");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(7);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(7);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(60);
$objPHPExcel->getActiveSheet()
->getColumnDimension('I')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('J')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('K')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('L')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('M')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('N')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('O')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('P')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('Q')
->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'LIBRO DE VENTAS');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:Q1');


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Especificación')
->setCellValue('B3', 'Nro')
->setCellValue('C3', 'Fecha')
->setCellValue('D3', 'Nro. de Factura')
->setCellValue('E3', 'Nro. de Autorización')
->setCellValue('F3', 'Estado')
->setCellValue('G3', 'NIT Cliente')
->setCellValue('H3', 'Razón Social')
->setCellValue('I3', 'Importe Total de la venta')
->setCellValue('J3', 'Importe ICE/IEHD/Tasas')
->setCellValue('K3', 'Exportaciones y Op. Exentas')
->setCellValue('L3', 'Ventas gravadas a tasa cero')
->setCellValue('M3', 'Subtotal')
->setCellValue('N3', 'Descuentos')
->setCellValue('O3', 'Importe base débido fiscal')
->setCellValue('P3', 'Débito fiscal')
->setCellValue('Q3', 'Código de control');


$objPHPExcel->getActiveSheet()
->getStyle("A3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("B3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("C3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("D3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("E3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("F3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("G3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("H3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("I3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("J3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("K3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("L3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("M3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("N3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("O3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("P3")
->getFont()
->setBold(true);$objPHPExcel->getActiveSheet()
->getStyle("Q3")
->getFont()
->setBold(true);

function fecha($fecha){
    $f = explode('-',$fecha);
    $newfecha = $f[2].'/'.$f[1].'/'.$f[0];
    return $newfecha;
}

    $fecha_ini = $_POST['f_fecha_ini'];
	$fecha_fin = $_POST['f_fecha_fin'];
	$estado = $_POST['f_estado'];
	$tipo = $_POST['f_tipo'];
	$sucursal = $_POST['f_sucursal'];
	$usuario = $_POST['f_usuario'];
    $filtro = $_POST['f_filtro'];
    $mes = $_POST['f_mes'];
    $anio = $_POST['f_anio'];
    $rango = $_POST['f_rango'];
	//$campo = JRequest::getVar('f_campo', '', 'post');
    //JRequest::getVar('campo', '', 'post')
	//$cadena = JRequest::getVar('f_cadena', '', 'post');
    
	$where = 'WHERE 1';
	/*if($filtro != '')
		$where.= ' AND '.$campo.' LIKE "%'.$cadena.'%"';*/
    if($filtro != '')
		$where.= ' AND f.nombre LIKE "%'.$filtro.'%"';
	if($rango == 1){
		$where.= ' AND f.fecha >= "'.$fecha_ini.'" AND f.fecha <= "'.$fecha_fin.'"';
    }elseif($mes=!'' and $anio!=''){
        $where.= ' AND f.fecha LIKE "'.$anio.'-'.$mes.'-%"';       
    }
	if($estado != '')
		$where.= ' AND f.estado = "'.$estado.'"';
	if($tipo != '')
		$where.= ' AND ff.id = "'.$tipo.'"';
	if($sucursal != '')
		$where.= ' AND s.id = "'.$sucursal.'"';
	if($usuario != '')
		$where.= ' AND f.id_usuario = "'.$usuario.'"';
	
	$query = 'SELECT f.*, i.empresa, l.autorizacion, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla 
	FROM cgn_erp_facturacion_cabecera AS f 
	LEFT JOIN cgn_erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN cgn_erp_clientes_info AS i ON i.id_cliente = c.id 
	LEFT JOIN cgn_erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN cgn_erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN cgn_erp_facturacion_factura AS ff ON l.id_factura = ff.id 
	'.$where.' 
	ORDER BY f.fecha';
    //echo $query;
    $reg = $conn->query($query);

$i = 3;
$n = 0;
while($f = $reg->fetch_assoc()){ 
//foreach($facturas as $f){
//while ($rw = $rs->fetch_assoc()){
	$i++;
	$n++;
	
	if($f['estado'] == 'V'){
		$val_total = $f['total'];
		$val_ice = $f['ice'];
		$val_exce = $f['exce'];
		$val_grav = $f['grav'];
		$val_desc = $f['desc'];
		$nombre = utf8_encode($f['nombre']);
		$nit = $f['nit'];
		}else{
		if($tipo == 1){
			$nombre = utf8_encode($f['nombre']);
			$nit = $f['nit'];
			}else{
			$nombre = '';
			$nit = 0;
			}
		$val_total = 0;
		if($f['ice'] != '')
			$val_ice = 0;
			else
			$val_ice = '';
		if($f['exce'] != '')
			$val_exce = 0;
			else
			$val_exce = '';
		if($f['grav'] != '')
			$val_grav = 0;
			else
			$val_grav = '';
		if($f['desc'] != '')
			$val_desc = 0;
			else
			$val_desc = '';
		}
	
	$subtotal = $val_total - $val_ice - $val_exce - $val_grav;
	$total = $subtotal - $val_desc;
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, '3')
	->setCellValue('B'.$i, $n)
	->setCellValue('C'.$i, fecha($f['fecha']))
	->setCellValue('D'.$i, $f['numero'])
	->setCellValueExplicit('E'.$i, $f['autorizacion'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('F'.$i, $f['estado'])
	->setCellValueExplicit('G'.$i, $nit, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('H'.$i, $nombre)
	->setCellValue('I'.$i, round($val_total, 2))
	->setCellValue('J'.$i, round($val_ice, 2))
	->setCellValue('K'.$i, round($val_exce, 2))
	->setCellValue('L'.$i, round($val_grav, 2))
	->setCellValue('M'.$i, round($subtotal, 2))
	->setCellValue('N'.$i, round($val_desc, 2))
	->setCellValue('O'.$i, round($total, 2))
	->setCellValue('P'.$i, round(($total * 0.13), 2))
	->setCellValue('Q'.$i, $f['codigo']);
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Ventas');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Libro Ventas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>