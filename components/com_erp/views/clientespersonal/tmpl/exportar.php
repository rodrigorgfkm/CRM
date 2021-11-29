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

	$estado = $_POST['filtro_estado'];
	$cadena = $_POST['filtro_cadena'];

	$where = '';
	if($cadena != '')
		$where.= ' AND (empresa LIKE "%'.$cadena.'%" OR nombre LIKE "%'.$cadena.'%" OR apellido LIKE "%'.$cadena.'%")';
	if($estado != 2)
		$where.= ' AND vigente = "'.$estado.'"';
	
	$query = 'SELECT * 
	FROM '.$pre.'erp_clientes 
	WHERE 1 '.$where.' 
	ORDER BY empresa, nombre, apellido';
	$rs = mysql_query($query);

/** Incluir la libreria PHPExcel */
require_once ('../../../excel/PHPExcel.php');
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Libro de Compras")
->setSubject("Libro de Compras")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Libro de Compras y Ventas");
 
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
->setCellValue('A1', 'Lista de Clientes');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:I1');

/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A2', 'Periodo FIscal: ');
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A2:G2');*/

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Cliente')
->setCellValue('B3', 'Tipo')
->setCellValue('C3', 'Titular')
->setCellValue('D3', 'Dirección')
->setCellValue('E3', 'Ciudad')
->setCellValue('F3', 'Departamento')
->setCellValue('G3', 'Teléfono')
->setCellValue('H3', 'Celular')
->setCellValue('I3', 'Correo electrónico');

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
$i=3;
while($rw = mysql_fetch_object($rs)){
	$query = 'SELECT fo.numero AS fono_domicilio, ce.numero AS celular, em.numero AS email 
	FROM cgn_erp_clientes AS c 
	LEFT JOIN cgn_erp_clientes_comunicacion AS fo ON c.id = fo.id_cliente 
	LEFT JOIN cgn_erp_clientes_comunicacion AS ce ON c.id = ce.id_cliente 
	LEFT JOIN cgn_erp_clientes_comunicacion AS em ON c.id = em.id_cliente 
	WHERE fo.id_tipo = "1" AND ce.id_tipo = "2" AND em.id_tipo = "3" AND c.id = "'.$rw->id.'"';
	$rs_c = mysql_query($query);
	$rw_c = mysql_fetch_object($rs_c);
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
	->setCellValue('A'.$i, utf8_encode($cliente))
	->setCellValue('B'.$i, $tipo)
	->setCellValue('C'.$i, utf8_encode($titular))
	->setCellValue('D'.$i, utf8_encode($rw->direccion))
	->setCellValue('E'.$i, utf8_encode($rw->ciudad))
	->setCellValue('F'.$i, departamento($rw->id_estado))
	->setCellValueExplicit('G'.$i, $rw_c->fono_domicilio, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('H'.$i, $rw_c->celular, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('I'.$i, $rw->email);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Clientes');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista de Clientes.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>