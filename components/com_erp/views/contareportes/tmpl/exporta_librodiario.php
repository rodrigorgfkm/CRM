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
->setSubject("Libro Diario")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Libro Diario");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(10);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Libro Diario');

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
/*Desde aqui comienzan las conslutas*/

    $id_gestion = $_POST['f_id_gestion'];
    $id_cuenta = $_POST['f_id_cuenta'];
    $fecha_inicio = $_POST['f_fecha_ini'];
    $fecha_fin = $_POST['f_fecha_fin'];
    $mes = $_POST['f_mes'];
    $rango = $_POST['f_rango'];
    $tipo = $_POST['tipo'];
	$where_fecha = '';
	
	if($rango == 0){
		$where_fecha = ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';
		}else{
		if($fecha_inicio != '')
			$where_fecha.= ' AND c.fec_creacion >= "'.$fecha_inicio.'"';
		if($fecha_fin != '')
			$where_fecha.= ' AND c.fec_creacion <= "'.$fecha_fin.'"';
		}
	
	if($id_cuenta != ''){
		$join = ' LEFT JOIN cgn_erp_conta_comprobante_detalle AS cd ON c.id = cd.id_comprobante ';
		$where = ' AND cd.id_cuenta = "'.$id_cuenta.'"';
		$group = ' GROUP BY c.id';
		}
    if($tipo != ''){
		$where.= ' AND c.id_tipo = "'.$tipo.'"';
		}
	$query = 'SELECT c.*, t.tipo 
	FROM cgn_erp_conta_comprobante AS c 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id 
	'.$join.'
	WHERE 1'.$where_fecha.'
	'.$where.$group.'
	ORDER BY c.numero ASC';
    
    $rs = $conn->query($query);
    
    /*echo $query;
	$db->setQuery($query);  
	$comprobantes = $db->loadObjectList();
	return $comprobantes;*/

$i=3;
$j=4;
$k=5;
$l=6;
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
while($comp = $rs->fetch_assoc()){
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, 'Comprobante Nº'.$comp['numero'])
    ->setCellValue('B'.$i, utf8_encode('Fecha: '.fecha($comp['fec_creacion'])))
    ->setCellValue('C'.$i, utf8_encode($comp['tipo'].' '.$comp['detalle']))
    ->setCellValue('C'.$j, utf8_encode('Nombre: '.$comp['cliente']))
    ->setCellValue('C'.$k, utf8_encode('Tipo de Cambio: '.$comp['tipo_cambio']))
    ->setCellValue('A'.$l, utf8_encode('Codigo'))
    ->setCellValue('B'.$l, utf8_encode('Cuenta Contable'))
    ->setCellValue('C'.$l, utf8_encode('Detalle'))
    ->setCellValue('D'.$l, utf8_encode('Debe'))
    ->setCellValue('E'.$l, utf8_encode('Haber'));

    $objPHPExcel->getActiveSheet()
    ->getStyle("A".$i)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("B".$i)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("C".$i)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("D".$i)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("E".$i)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("A".$l)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("B".$l)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("C".$l)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("D".$l)
    ->getFont()
    ->setBold(true);
    $objPHPExcel->getActiveSheet()
    ->getStyle("E".$l)
    ->getFont()
    ->setBold(true);
    
    $m=$l+1;
    $total_debe = 0;
    $total_haber = 0;

    $query_c = 'SELECT * FROM cgn_erp_conta_comprobante_detalle WHERE id_comprobante = "'.$comp['id'].'" ORDER BY id';
    $res = $conn->query($query_c);
    while($cuenta = $res->fetch_assoc()){
        $total_debe+=$cuenta['debe'];
        $total_haber+=$cuenta['haber'];

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$m, utf8_encode(codigoRename($cuenta['codigo'])))
        ->setCellValue('B'.$m, utf8_encode($cuenta['cuenta']))
        ->setCellValue('C'.$m, utf8_encode($cuenta['detalle']))
        ->setCellValue('D'.$m, utf8_encode(num2monto($cuenta['debe'])))
        ->setCellValue('E'.$m, utf8_encode(num2monto($cuenta['haber'])));
        $m++;
    }
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C'.$m, 'Total')
    ->setCellValue('D'.$m, utf8_encode(number_format($total_debe,2,",",".").' Bs.'))
    ->setCellValue('E'.$m, utf8_encode(number_format($total_haber,2,",",".").' Bs.'));
    
    $objPHPExcel->getActiveSheet()
    ->getStyle("C".$m)
    ->getFont()
    ->setBold(true);
    
    $objPHPExcel->getActiveSheet()
    ->getStyle('C'.$m)
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    $m = $m+2;    
    $i=$m;
    $j=$i+1;
    $k=$j+1;
    $l=$k+1;
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Libro Diario');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Libro Diario.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>