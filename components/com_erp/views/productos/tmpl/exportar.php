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

	$categoria = $_POST['filtro_categoria'];
	$cadena = $_POST['filtro_cadena'];

	$where = '';
	if($cadena != '')
		$where.= ' AND name LIKE "%'.$cadena.'%"';
	if($categoria != '')
		$where.= ' AND category_id = "'.$categoria.'"';
	
	$query = 'SELECT i.*, p.price, c.name AS category, u.unidad, SUM(cant.cantidad) AS cantidad 
	FROM '.$pre.'erp_producto_items AS i 
	LEFt JOIN '.$pre.'erp_producto_precio AS p ON i.id = p.id_producto 
	LEFT JOIN '.$pre.'erp_producto_categories AS c ON i.category_id = c.id 
	LEFT JOIN '.$pre.'erp_producto_unidades AS u ON i.id_unidad = u.id 
	LEFT JOIN '.$pre.'erp_producto_cantidad AS cant ON i.id = cant.id_producto 
	WHERE 1 '.$where.' 
	GROUP BY i.id
	ORDER BY i.category_id, i.orden';
	$rs = mysql_query($query);

$query = 'SELECT e.*, p.moneda_decimal 
FROM '.$pre.'erp_configuracion AS e 
LEFT JOIN '.$pre.'erp_ubicacion_pais AS p ON e.id_pais = p.id 
LIMIT 1';
$rs_e = mysql_query($query);
$rw_e = mysql_fetch_object($rs_e);

/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Productos")
->setSubject("Productos")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Productos");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(10);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('I')
->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Lista de Productos');

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
->setCellValue('A3', 'Ítems')
->setCellValue('B3', 'Código')
->setCellValue('C3', 'Categoría')
->setCellValue('D3', 'Unidad')
->setCellValue('E3', 'Precio');

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
	
	if($rw->empresa != ''){
		$cliente = $rw->empresa;
		$tipo = 'Empresa';
		$titular = $rw->nombre.' '.$rw->apellido;
		}else{
		$cliente = $rw->nombre.' '.$rw->apellido;
		$tipo = 'Particular';
		$titular = '';
		}
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, utf8_encode($rw->name))
	->setCellValue('B'.$i, $rw->codigo)
	->setCellValue('C'.$i, utf8_encode($rw->category))
	->setCellValue('D'.$i, utf8_encode($rw->unidad))
	->setCellValueExplicit('E'.$i, number_format($rw->price, $rw_e->moneda_decimal), PHPExcel_Cell_DataType::TYPE_STRING);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Productos');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista de Productos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>