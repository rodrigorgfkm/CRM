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
->setTitle("Negocios")
->setSubject("Libro Mayor")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Libro Mayor");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Libro Mayor');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:G1');
    
function fecha($fecha){
    $f = explode('-',$fecha);
    $newfecha = $f[2].'/'.$f[1].'/'.$f[0];
    return $newfecha;
}
function num2monto($num){
	$num = number_format($num, 2, ',', ' ');
	return $num;
}
function codigoRename($cod){
	$len = strlen($cod);
	$max = 10;
	for($i=0; $i<($max-$len); $i++)
		$cod.= '0';
	return $cod;
}
    
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Fecha')
->setCellValue('B3', 'Tipo')
->setCellValue('C3', 'Comp.')
->setCellValue('D3', 'Nombre')
->setCellValue('E3', 'Concepto')
->setCellValue('F3', 'Debe')
->setCellValue('G3', 'Haber')
->setCellValue('H3', 'Saldo');

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

/*Desde aqui comienzan las conslutas*/

    $id = $_POST['f_id_cuenta'];
    $fecha_ini = $_POST['f_fecha_ini'];
    $fecha_fin = $_POST['f_fecha_fin'];
	$cuenta = $_POST['f_cuenta'];
    $mes = $_POST['f_mes'];
    $rango = $_POST['f_rango'];
	
    /*$query = 'SELECT * FROM cgn_erp_conta_cuentas WHERE id = "'.$id.'"'; 
	    
    $rs = $conn->query($query);*/
    	
	$where = '';
	
	if($rango != 1){
		if($mes != '')
			$where = ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';
		}else{
		if($fecha_ini != '')
			$where.= ' AND c.fec_creacion >= "'.$fecha_ini.'"';
		if($fecha_fin != '')
			$where.= ' AND c.fec_creacion <= "'.$fecha_fin.'"';
		}
	
	$query_c = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
    LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$id.'" '.$where.'
	ORDER BY c.numero ASC';
	$reg = $conn->query($query_c);
    
    /*$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A4', utf8_encode($cta["Nombre"]);*/
$i=4;

while($cuenta = $reg->fetch_assoc()){
        $total_debe+=$cuenta['debe'];
        $total_haber+=$cuenta['haber'];
        $saldo = $total_debe - $total_haber;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, utf8_encode(fecha($cuenta['fec_creacion'])))
        ->setCellValue('B'.$i, utf8_encode($cuenta['tipo']))
        ->setCellValue('C'.$i, utf8_encode($cuenta['numero']))
        ->setCellValue('D'.$i, utf8_encode($cuenta['cliente']))
        ->setCellValue('E'.$i, utf8_encode(num2monto($cuenta['detalle'])))
        ->setCellValue('F'.$i, utf8_encode(num2monto($cuenta['debe'])))
        ->setCellValue('G'.$i, utf8_encode(num2monto($cuenta['haber'])))
        ->setCellValue('H'.$i, utf8_encode(num2monto($saldo)));
        $i++;
}
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode(''))
    ->setCellValue('B'.$i, utf8_encode(''))
    ->setCellValue('C'.$i, utf8_encode(''))
    ->setCellValue('D'.$i, utf8_encode(''))
    ->setCellValue('E'.$i, utf8_encode('Total:'))
    ->setCellValue('F'.$i, utf8_encode(num2monto($total_debe.' Bs.')))
    ->setCellValue('G'.$i, utf8_encode(num2monto($total_haber.' Bs.')))
    ->setCellValue('H'.$i, utf8_encode(num2monto($saldo.' Bs.')));
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Libro Mayor');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Libro Mayor.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>