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
/*require_once ('../../../excel/.php');*/
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Flujo de Cuentas Bancarias")
->setSubject("Flujo de Cuentas Bancarias")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Flujo de Cuentas Bancarias");
 
$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'FLUJO DE CUENTAS BANCARIAS');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true)
->setSize(18);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'MONEDA NACIONAL');

$objPHPExcel->getActiveSheet()
->getStyle("A3")
->getFont()
->setBold(true)
->setSize(14);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A3:F3');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', 'Nro. Cuenta')
->setCellValue('B4', 'Entidad Financiera')
->setCellValue('C4', 'Saldo Inicial')
->setCellValue('D4', 'Ingresos')
->setCellValue('E4', 'Egresos')
->setCellValue('F4', 'Saldo Final');

$objPHPExcel->getActiveSheet()
->getStyle("A4")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("B4")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("C4")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("D4")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("E4")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("F4")
->getFont()
->setBold(true);

//echo "hola asdasdas";
$i = 4;
function fecha2($fecha){
    $f = explode('/',$fecha);
    return $f[2].'-'.$f[1].'-'.$f[0];
}
function getLBflujoap($id){
	$query = 'SELECT debe FROM cgn_erp_lb_bancos_cuentas WHERE id_cuenta = "'.$id.'" AND apertura = "1"';
	return $query;
}
function getLBflujo($m){
	$del = $_POST['f_del'];
	$al = $_POST['f_al'];
	
	if($del != '')
		$where = ' AND c.fecha BETWEEN "'.fecha2($del).'" AND "'.fecha2($al).'"';
	
	$query = 'SELECT b.id, b.banco, b.cuenta, SUM(c.debe) AS ingresos, SUM(c.haber) AS egresos, SUM(c.debe - c.haber) AS saldo 
	FROM cgn_erp_lb_bancos_cuentas AS c 
	JOIN cgn_erp_lb_bancos AS b ON c.id_cuenta = b.id
	WHERE c.apertura = "0" AND c.conciliado = "1" AND b.moneda = "'.$m.'" '.$where.'
	GROUP BY c.id_cuenta';	
	return $query;
}
function num2monto($num){
	$num = number_format($num, 2, ',', ' ');
	return $num;
}
//echo getLBflujo('N');
$flujom_query = $conn->query(getLBflujo('N'));

while($cuentas = $flujom_query->fetch_assoc()){
    $i++;
    $saldoini = $conn->query(getLBflujoap($cuentas['id']));
    
    while($saldoini_n = $saldoini->fetch_assoc()){
        $debe = $saldoini_n['debe'];
    }
    $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, $cuentas['cuenta'])
	->setCellValue('B'.$i, $cuentas['banco'])
	->setCellValue('C'.$i, num2monto($debe))
	->setCellValue('D'.$i, num2monto($cuentas['ingresos']))
	->setCellValue('E'.$i, num2monto($cuentas['egresos']))
	->setCellValue('F'.$i, num2monto($debe + $cuentas['saldo']));
}
$i = $i+3;

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, 'MONEDA EXTRANJERA');

$objPHPExcel->getActiveSheet()
->getStyle("A".$i)
->getFont()
->setBold(true)
->setSize(14);
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A'.$i.':F'.$i);

$i++;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, 'Nro. Cuenta')
->setCellValue('B'.$i, 'Entidad Financiera')
->setCellValue('C'.$i, 'Saldo Inicial')
->setCellValue('D'.$i, 'Ingresos')
->setCellValue('E'.$i, 'Egresos')
->setCellValue('F'.$i, 'Saldo Final');

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
->getStyle("F".$i)
->getFont()
->setBold(true);


$flujom_query = $conn->query(getLBflujo('E'));
//echo getLBflujo('E');
while($cuentas = $flujom_query->fetch_assoc()){
    $i++;
    //print_r($cuentas);
    $saldoini = $conn->query(getLBflujoap($cuentas['id']));
    //echo getLBflujoap($cuentas['id']);
    while($saldoini_n = $saldoini->fetch_assoc()){
        $debe = $saldoini_n['debe'];
    }
    $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, $cuentas['cuenta'])
	->setCellValue('B'.$i, $cuentas['banco'])
	->setCellValue('C'.$i, num2monto($debe))
	->setCellValue('D'.$i, num2monto($cuentas['ingresos']))
	->setCellValue('E'.$i, num2monto($cuentas['egresos']))
	->setCellValue('F'.$i, num2monto($debe + $cuentas['saldo']));
}
$i = $i+3;

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, 'OTRAS CUENTAS');

$objPHPExcel->getActiveSheet()
->getStyle("A".$i)
->getFont()
->setBold(true)
->setSize(14);
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A'.$i.':F'.$i);

$i++;
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, 'Nro. Cuenta')
->setCellValue('B'.$i, 'Entidad Financiera')
->setCellValue('C'.$i, 'Saldo Inicial')
->setCellValue('D'.$i, 'Ingresos')
->setCellValue('E'.$i, 'Egresos')
->setCellValue('F'.$i, 'Saldo Final');

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
->getStyle("F".$i)
->getFont()
->setBold(true);

$flujom_query = $conn->query(getLBflujo('O'));

while($cuentas = $flujom_query->fetch_assoc()){
    $i++;
    $saldoini = $conn->query(getLBflujoap($cuentas['id']));
    
    while($saldoini_n = $saldoini->fetch_assoc()){
        $debe = $saldoini_n['debe'];
    }
    $objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, $cuentas['cuenta'])
	->setCellValue('B'.$i, $cuentas['banco'])
	->setCellValue('C'.$i, num2monto($debe))
	->setCellValue('D'.$i, num2monto($cuentas['ingresos']))
	->setCellValue('E'.$i, num2monto($cuentas['egresos']))
	->setCellValue('F'.$i, num2monto($debe + $cuentas['saldo']));
}

$objPHPExcel->getActiveSheet()->setTitle('Flujo de Cuentas Bancarias');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Flujo de Cuentas Bancarias.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
/*}else{
    vistaBloqueada();
}*/
?>