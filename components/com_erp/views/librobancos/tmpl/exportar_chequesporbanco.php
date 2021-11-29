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
->setTitle("Cheques por Banco")
->setSubject("Cheques por Banco")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Cheques por Banco");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(35);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(25);

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
->setCellValue('A3', 'Cuenta')
->setCellValue('B3', 'Fecha')
->setCellValue('C3', 'Nro. Cheque')
->setCellValue('D3', 'Nombre')
->setCellValue('E3', 'Moneda')
->setCellValue('F3', 'Monto')
->setCellValue('G3', 'Usuario');

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

/*Desde aqui comienzan las conslutas*/

    $postbanco = $_POST['f_banco'];
    $del = explode('/', $_POST['f_del']);
    $al = explode('/', $_POST['f_al']);
	
	$where = '1';
	if($_POST['f_banco'] != 0)
		$where.= ' AND id_cuenta = "'.$_POST['f_banco'].'"';
	
	if($imp != 0)
		$where.= ' AND impreso = "0"';
	
    if($_POST['f_del'] != '' and $_POST['f_al'] != ''){
        $where.= ' AND fecha_reg >= "'.$del[1].'-'.$del[0].'-01" AND fecha_reg <= "'.$al[1].'-'.$al[0].'-31"';
    }
	$query = 'SELECT * FROM cgn_erp_lb_cheque WHERE '.$where.' ORDER BY numero';
    //echo $query;
	$reg = $conn->query($query);
    
    /*$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A4', utf8_encode($cta["Nombre"]);*/
$i=4;
while($cuenta = $reg->fetch_assoc()){
        
        $query2 = 'SELECT * FROM cgn_erp_lb_bancos WHERE id = "'.$cuenta['id_cuenta'].'"';
        $reg2 = $conn->query($query2);
        while($banco = $reg2->fetch_assoc()){
            $nombre_banco = $banco['banco'];
        }
        $query3 = 'SELECT u.*, ue.id_cliente, ue.su, ue.cargo, ue.foto, r.group_id 
                    FROM cgn_users AS u 
                    LEFT JOIN cgn_erp_usuarios AS ue ON u.id = ue.id_usuario 
                    LEFT JOIN cgn_user_usergroup_map AS r ON u.id = r.user_id
                    WHERE u.id = "'.$cuenta['id_usuario'].'"';
        
        $reg3 = $conn->query($query3);
        while($usuario = $reg3->fetch_assoc()){
            $nombre_us = $usuario['name'];
        }
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, utf8_encode($nombre_banco))
        ->setCellValue('B'.$i, utf8_encode(fecha($cuenta['fecha_reg'])))
        ->setCellValue('C'.$i, utf8_encode($cuenta['numero']))
        ->setCellValue('D'.$i, utf8_encode($cuenta['nombre']))
        ->setCellValue('E'.$i, utf8_encode(num2monto($cuenta['moneda'])))
        ->setCellValue('F'.$i, utf8_encode(num2monto($cuenta['monto'])))
        ->setCellValue('G'.$i, utf8_encode($nombre_us));
        $i++;
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Cheques por Banco');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Cheques por Banco.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>