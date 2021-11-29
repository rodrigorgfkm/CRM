<?php

include_once('../../../../../configuration.php');
$config = new JConfig();
$bd_host = $config->host;
$bd_user = $config->user;
$bd_pass = $config->password;
$bd_base = $config->db;
$con = mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_base, $con);

$pre = $config->dbprefix;

	$cadena = $_POST['filtro_cadena'];

	$where = '';
	if($cadena != '')
		$where.= ' AND nombre LIKE "%'.$cadena.'%"';
	
	$query = 'SELECT c.*, r.nombre, r.acuenta, r.saldo, r.docid_cliente, r.docid_receptor 
	FROM '.$pre.'erp_clientes_cuenta AS c 
	JOIN '.$pre.'erp_clientes_recibo AS r ON c.id = r.id_cuenta '.$where.'
	ORDER BY c.fecha DESC';
	$rs = mysql_query($query);

/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Recibos")
->setSubject("Recibos")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Recibos");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(30);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Recibos');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:E1');

/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A2', 'Periodo FIscal: ');
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A2:G2');*/

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Nombre')
->setCellValue('B3', 'Monto')
->setCellValue('C3', 'Total')
->setCellValue('D3', 'A cuenta')
->setCellValue('E3', 'Fecha');

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

$i=3;
while($rw = mysql_fetch_object($rs)){
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, utf8_encode($rw->nombre))
	->setCellValueExplicit('B'.$i, $rw->acuenta, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('C'.$i, ($rw->acuenta + $rw->saldo), PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('D'.$i, $rw->saldo, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('E'.$i, $rw->fecha);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Recibos');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Recibos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>