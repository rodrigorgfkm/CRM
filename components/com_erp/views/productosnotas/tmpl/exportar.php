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
$pre = $config->dbprefix;
//Incluir la libreria PHPExcel
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Notas de entrega")
->setSubject("Notas de entrega")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Notas de entrega");
 
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
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Notas de entrega');
$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:H1');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Nombre')
->setCellValue('B3', 'Teléfono')
->setCellValue('C3', 'Celular')
->setCellValue('D3', 'Correo-e')
->setCellValue('E3', 'Fecha')
->setCellValue('F3', 'Descuento')
->setCellValue('G3', 'Total');

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
//echo "hola";
function fecha($fecha){
    $f = explode('-',$fecha);
    $newfecha = $f[2].'/'.$f[1].'/'.$f[0];
    return $newfecha;
}
$i=3;
    $cadena = $_POST['f_cadena'];
    $desde = $_POST['f_desde'];
    $hasta = $_POST['f_hasta'];
	$where = '';
	if($cadena != '')
		$where.= ' AND nombre LIKE "%'.$cadena.'%"';
    
    if($desde != '')
		$where.= ' AND fecha >= "'.$desde.'"';
    
    if($hasta != '')
		$where.= ' AND fecha <= "'.$hasta.'"';
	
	$query = 'SELECT * 
	FROM '.$pre.'erp_nota_cabecera 
	WHERE 1 '.$where.' 
	ORDER BY fecha, hora DESC';
	$rs = $conn->query($query);

while($rw = $rs->fetch_assoc()){
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, utf8_encode($rw['nombre']))
	->setCellValueExplicit('B'.$i, $rw['fono'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('C'.$i, $rw['celular'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('D'.$i, utf8_encode($rw['email']))
	->setCellValue('E'.$i, fecha($rw['fecha']))
	->setCellValue('F'.$i, $rw['descuento'])
	->setCellValueExplicit('G'.$i, $rw['total'], PHPExcel_Cell_DataType::TYPE_STRING);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Notas de entrega');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Notas de entrega.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>