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
->setSubject("Listado de Negocios")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Registro de Negocios");
 
// Agregar Informacion

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(5);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(10);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(30);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('I')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('J')
->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Lista de Negocios');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:J1');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Nº')
->setCellValue('B3', 'Empresa')
->setCellValue('C3', 'Telf. Empresa')
->setCellValue('D3', 'Valor')
->setCellValue('E3', 'Direccion')
->setCellValue('F3', 'Responsable')
->setCellValue('G3', 'Segmento')
->setCellValue('H3', 'Etapa')
->setCellValue('I3', 'Fecha Registro')
->setCellValue('J3', 'Fecha de Cierre');

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
$objPHPExcel->getActiveSheet()
->getStyle("I3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("J3")
->getFont()
->setBold(true);

$i=3;

	$etapa = $_POST['filtro_id_etapa'];//$session->get('antiguedad');
	$usuario = $_POST['filtro_id_usuario'];//$session->get('asociado');
	$segmento = $_POST['filtro_id_segmento'];//$session->get('registro');
	//$id_categoria = $_POST['filtro_id_categoria'];//$session->get('id_categoria');
	
	$where = '';
	/*if(!empty($etapa) || !empty($usuario) || !empty($segmento)){*/
		if($etapa != '')
			$where.= ' AND e.etapa = "'.$etapa.'"';
		if($usuario != '')
			$where.= ' AND p.id_asignado = "'.$usuario.'"';
		if($segmento != '')
			$where.= ' AND p.id_segmento = "'.$segmento.'"';
    /*}*/
	 
	$query = 'SELECT p.*, e.etapa, et.etapa AS nombre_etapa, u.name , n.monto AS nmonto, n.id_asignado, n.estado AS nestado, n.fecha_registro AS nfecha_registro, n.fecha_cierre AS nfecha_cierre 
    FROM cgn_erp_crm_prospecto 
    AS p LEFT JOIN cgn_erp_crm_etapa AS e ON p.id = e.id_prospecto 
    LEFT JOIN cgn_erp_crm_etapas AS et ON e.etapa = et.id 
    LEFT JOIN cgn_users AS u ON p.id_asignado = u.id 
    LEFT JOIN cgn_erp_crm_negocio AS n ON p.id = n.id_prospecto 
    WHERE e.activo = "1" AND n.estado = "0" AND n.activo = "1"'.$where.' 
    GROUP BY p.id ORDER BY p.id DESC';

	$rs = $conn->query($query);
$c=1;
function fecha($fecha){
    $f = explode('-',$fecha);
    $newfecha = $f[2].'/'.$f[1].'/'.$f[0];
    return $newfecha;
}
while($crm = $rs->fetch_assoc()){
    
    $segment = '';
	$query = 'SELECT segmento 
	FROM cgn_erp_crm_segmento 
	WHERE id = "'.$crm['id_segmento'].'"';
	$rs_seg = $conn->query($query);
	while($seg = $rs_seg->fetch_assoc()){
		$segment.= $seg['segmento'];        
    }
		
	$i++;
        
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$i, $c)
	->setCellValue('B'.$i, utf8_encode($crm['empresa']))
	->setCellValue('C'.$i, utf8_encode($crm['fono_empresa']))
	->setCellValue('D'.$i, utf8_encode($crm['nmonto']))
	->setCellValue('E'.$i, utf8_encode($crm['direccion']))
	->setCellValue('F'.$i, utf8_encode($crm['name']))
	->setCellValue('G'.$i, utf8_encode($segment))
	->setCellValue('H'.$i, utf8_encode($crm['nombre_etapa']))
	->setCellValue('I'.$i, fecha($crm['nfecha_registro']))
	->setCellValue('J'.$i, fecha($crm['nfecha_cierre']));
    
    $c++;
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('CRM');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista CRM.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>