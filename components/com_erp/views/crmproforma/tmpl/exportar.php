<?php
function departamento($id){
	switch($id){
		case '1':
		$departamento = 'La Paz';
		break;
		case '2':
		$departamento = 'Santa Cruz';
		break;
		case '3':
		$departamento = 'Cochabamba';
		break;
		case '4':
		$departamento = 'Chuquisaca';
		break;
		case '5':
		$departamento = 'Oruro';
		break;
		case '6':
		$departamento = 'Potosí';
		break;
		case '7':
		$departamento = 'Tarija';
		break;
		case '8':
		$departamento = 'Beni';
		break;
		case '9':
		$departamento = 'Pando';
		break;
		}
	return $departamento;
	}

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
	
	$query = 'SELECT * 
	FROM '.$pre.'erp_proforma_cabecera 
	WHERE 1 '.$where.' 
	ORDER BY fecha, hora DESC';
	$rs = mysql_query($query);

/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Proformas")
->setSubject("Proformas")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Proformas");
 
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
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Proformas');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:F1');

/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A2', 'Periodo FIscal: ');
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A2:G2');*/

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Nombre')
->setCellValue('B3', 'Teléfono')
->setCellValue('C3', 'Celular')
->setCellValue('D3', 'Correo-e')
->setCellValue('E3', 'Fecha')
->setCellValue('F3', 'Total');

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

$i=3;
while($rw = mysql_fetch_object($rs)){
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, utf8_encode($rw->nombre))
	->setCellValueExplicit('B'.$i, $rw->fono, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('C'.$i, $rw->celular, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('D'.$i, utf8_encode($rw->email))
	->setCellValue('E'.$i, $rw->fecha)
	->setCellValueExplicit('F'.$i, $rw->total, PHPExcel_Cell_DataType::TYPE_STRING);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Proformas');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Proformas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>