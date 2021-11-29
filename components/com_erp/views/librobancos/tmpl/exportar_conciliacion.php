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
->setTitle("Conciliación Bancaria")
->setSubject("Conciliación Bancaria")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Conciliacion Bancaria");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(35);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(80);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(25);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Conciliación Bancaria');

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
function fecha3($date){
	$d = explode('/',$date);
	return $d[1].'-'.$d[0];
} 
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Fecha')
->setCellValue('B3', 'Nro Cheque')
->setCellValue('C3', 'Nombre')
->setCellValue('D3', 'Detalle')
->setCellValue('E3', 'Debe')
->setCellValue('F3', 'Haber')
->setCellValue('G3', 'Saldo')
->setCellValue('H3', 'Estado');

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

    $id = $_POST['f_banco'];
    $del = $_POST['f_del'];
    $al = $_POST['f_al'];
    $id_usuario_conciliado = $_POST['conciliador'];
    $id_usuario = $_POST['por'];
	$c=0;
	$where = '';
	if($del != '' && $al != ''){
		$where = ' AND c.fecha >= "'.fecha3($del).'-01" AND c.fecha <= "'.fecha3($al).'-31"';
    }elseif($del == '' && $al != ''){
		$where = ' AND c.fecha <= "'.fecha3($al).'-31"';
    }elseif($del != '' && $al == ''){
		$where = ' AND c.fecha >= "'.fecha3($del).'-01"';
    }        
		
	if($id_usuario_conciliado != '')
		$where.= ' AND c.id_usuario_conciliado = "'.$id_usuario_conciliado.'"';
	if($id_usuario_conciliado != '')
		$where.= ' AND c.id_usuario = "'.$id_usuario.'"';
	
	if($c == 1)
		$where.= ' AND c.conciliado = "1"';
	
	$query = 'SELECT c.*, b.banco, b.cuenta, ch.numero, ch.nombre 
	FROM cgn_erp_lb_bancos_cuentas AS c
	LEFT JOIN cgn_erp_lb_bancos AS b ON b.id = c.id_cuenta
	LEFT JOIN cgn_erp_lb_cheque AS ch ON c.id_cheque = ch.id
	WHERE b.id = "'.$id.'" '.$where.'
	ORDER BY c.fecha ASC';
    //echo $query;
	$reg = $conn->query($query);
    
    /*$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A4', utf8_encode($cta["Nombre"]);*/
$i=4;
$cont = 0;
while($cuenta = $reg->fetch_assoc()){
        
        if($cont!=0){
            $saldo = $saldo - $cuenta['haber'];
            $saldo = $saldo + $cuenta['debe'];                                    
        }else{
            $saldo = $cuenta['debe']+0;
        }
        if($cuenta['conciliado']==0){
            $texto = 'Sin Conciliar';
        }else{
            $texto = 'Conciliado';
        }
    
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, fecha($cuenta['fecha']))
        ->setCellValue('B'.$i, $cuenta['numero'])
        ->setCellValue('C'.$i, utf8_encode($cuenta['nombre']))
        ->setCellValue('D'.$i, utf8_encode($cuenta['detalle']))
        ->setCellValue('E'.$i, utf8_encode(num2monto($cuenta['debe'])))
        ->setCellValue('F'.$i, utf8_encode(num2monto($cuenta['haber'])))
        ->setCellValue('G'.$i, utf8_encode($saldo))
        ->setCellValue('H'.$i, utf8_encode($texto));
        $i++;
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Conciliación Bancaria');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Conciliacion_Bancaria.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>