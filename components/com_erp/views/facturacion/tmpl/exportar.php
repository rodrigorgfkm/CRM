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
	//$query = 'SELECT * FROM '.$pre.'erp_facturacion_compras '.$where.' ORDER BY fecha_emision';
	$rs = $conn->query($query);

/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Libro de Compras")
->setSubject("Libro de Compras")
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
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(20);
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

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'LIBRO DE COMPRAS');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:P1');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Especificación')
->setCellValue('B3', 'Nro')
->setCellValue('C3', 'Fecha')
->setCellValue('D3', 'NIT')
->setCellValue('E3', 'Razón Social')
->setCellValue('F3', 'Nro Factura')
->setCellValue('G3', 'Nro DUI')
->setCellValue('H3', 'Nro Autorización')
->setCellValue('I3', 'Importe total')
->setCellValue('J3', 'Importe no sujeto a crédito fiscal')
->setCellValue('K3', 'Subtotal')
->setCellValue('L3', 'Descuentos')
->setCellValue('M3', 'Importe base para crédito fiscal')
->setCellValue('N3', 'Crédito fiscal')
->setCellValue('O3', 'Código de Control')
->setCellValue('P3', 'Tipo de Compra');

$objPHPExcel->getActiveSheet()
->getStyle("A3")
->getFont()
->setBold(true);
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
->setBold(true);

$i = 3;
$n = 0;
while ($rw = $rs->fetch_assoc()){
	$i++;
	$n++;
	$subtotal = $rw['total'] - $rw['nocredito'];
	$total = $subtotal - $rw['descuento'];
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, '1')
	->setCellValue('B'.$i, $n)
	->setCellValue('C'.$i, fecha($rw['fecha_emision']))
	->setCellValueExplicit('D'.$i, $rw['nit'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('E'.$i, utf8_encode($rw['empresa']))
	->setCellValue('F'.$i, $rw['numero'])
	->setCellValue('G'.$i, $rw['dui'])
	->setCellValueExplicit('H'.$i, $rw['autorizacion'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('I'.$i, round($rw['total'], 2))
	->setCellValue('J'.$i, round($rw['nocredito'], 2))
	->setCellValue('K'.$i, round($subtotal, 2))
	->setCellValue('L'.$i, round($rw['descuento'], 2))
	->setCellValue('M'.$i, round($total, 2))
	->setCellValue('N'.$i, round(($total * 0.13), 2))
	->setCellValue('O'.$i, $rw['codigo'])
	->setCellValue('P'.$i, $rw['tipo']);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Compras');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Libro Compras.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>