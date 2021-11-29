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
->setSubject("Balance de Sumas y Saldos")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Balance de SUMAS y Saldos");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(70);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);

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
->setCellValue('A1', 'Balance de Sumas y Saldos');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$desde = $_POST['e_desde'];
$hasta = $_POST['e_hasta'];
if($desde!=''){        
    $msj = 'Fecha Del '.$desde.' Al '.$hasta;
}elseif($hasta!=''){
    $msj = 'Balance de Sumas y Saldos Al '.$hasta;
}
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A2', $msj);

$objPHPExcel->getActiveSheet()
->getStyle("A2")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A2")
->getFont()
->setSize(12);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A2:F2');    

    
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A4', '')
->setCellValue('B4', '')
->setCellValue('C4', 'SUMAS')
->setCellValue('D4', '')
->setCellValue('E4', 'SALDOS')
->setCellValue('F4', '');

$objPHPExcel->getActiveSheet()
->getStyle("C4")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("E4")
->getFont()
->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A5', 'Código')
->setCellValue('B5', 'Cuentas')
->setCellValue('C5', 'Debe')
->setCellValue('D5', 'Haber')
->setCellValue('E5', 'Deudor')
->setCellValue('F5', 'Acreedor');

$objPHPExcel->getActiveSheet()
->getStyle("A5")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("B5")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("C5")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("D5")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("E5")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("F5")
->getFont()
->setBold(true);
/*Desde aqui comienzan las conslutas*/

    $aux = $_POST['aux'];
	
	$id_gestion = $_POST['e_id_gestion'];
	$where = '';
	if($id_padre != 0)
		$where = 'parent.id = "'.$id_padre.'" AND ';
	
	if($aux == 0)
		$whereaux = ' AND node.codigo != "0"';
	
	$query = 'SELECT node.*, parent.nombre AS nombre_padre, CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", node.nivel - 1), node.nombre) AS nombre_completo, (COUNT(parent.nombre) - 1) AS depth, parent.codigo AS codigo_padre
	FROM cgn_erp_conta_cuentas AS node, cgn_erp_conta_cuentas AS parent 
	WHERE '.$where.'node.id_gestion = "'.$id_gestion.'" AND parent.id_gestion = "'.$id_gestion.'" AND node.lft BETWEEN parent.lft AND parent.rgt '.$whereaux.'
	GROUP BY node.id
	ORDER BY node.lft';    
    //echo $query;
    $cuentas = $conn->query($query);
    $grantotal_debe = 0;
    $grantotal_haber = 0;
    $grantotal_deudor = 0;
    $grantotal_acreedor = 0;
    $i=6;
while($cta = $cuentas->fetch_assoc()){
    $total_debe = 0;
    $total_haber = 0;
    
    $rango = $_POST['e_rango'];
    $mes = $_POST['mes'];        
    if($_POST['e_desde']){
        $fecha_ini = $_POST['e_desde'];
    }else{
        $fecha_ini = $_GET['fi'];
    }
    if($_POST['e_hasta']){
        $fecha_fin = $_POST['e_hasta'];
    }else{
        $fecha_fin = $_GET['ff'];
    }
    $where2 = '';

    if($rango != 1){
        if($mes != '')
            $where2 .= ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';
        }else{
        if($fecha_ini != '')
            $where2.= ' AND c.fec_creacion >= "'.$fecha_ini.'"';
        if($fecha_fin != '')
            $where2.= ' AND c.fec_creacion <= "'.$fecha_fin.'"';
        }

    $query2 = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio 
    FROM cgn_erp_conta_comprobante_detalle AS d 
    LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
    WHERE d.id_cuenta = "'.$cta['id'].'" '.$where2.'
    ORDER BY c.numero ASC';
    $detalles = $conn->query($query2);
    while($detalle = $detalles->fetch_assoc()){
        $total_debe+= $detalle['debe'];
        $total_haber+= $detalle['haber'];            
    }
    $grantotal_debe+= $total_debe;
    $grantotal_haber+= $total_haber;

    $saldo = $total_debe - $total_haber;
    if($saldo < 0){
        $saldo_haber = $saldo * (-1);
        $saldo_debe = 0.00;
        $grantotal_acreedor+= $saldo * (-1);
        }else{
        $saldo_haber =  0.00;
        $saldo_debe = $saldo;
        $grantotal_deudor+= $saldo;
    }
    $cod = codigoRename($cta['codigo']);
    if($saldo_debe != '0' || $saldo_haber != '0' || $total_haber != '0'){
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $cod)
        ->setCellValue('B'.$i, utf8_encode($cta['nombre']))
        ->setCellValue('C'.$i, number_format($total_debe, 2, ',', ' '))
        ->setCellValue('D'.$i, number_format($total_haber, 2, ',', ' '))
        ->setCellValue('E'.$i, number_format($saldo_debe, 2, ',', ' '))
        ->setCellValue('F'.$i, number_format($saldo_haber, 2, ',', ' '));
        $i++;
    }
}
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, '')
->setCellValue('B'.$i, '')
->setCellValue('C'.$i, number_format($grantotal_debe, 2, ',', ' '))
->setCellValue('D'.$i, number_format($grantotal_haber, 2, ',', ' '))
->setCellValue('E'.$i, number_format($grantotal_deudor, 2, ',', ' '))
->setCellValue('F'.$i, number_format($grantotal_acreedor, 2, ',', ' '));
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
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Balance de Sumas y Saldos');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Balance de Sumas y Saldos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>