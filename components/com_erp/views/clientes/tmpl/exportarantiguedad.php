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
->setWidth(10);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(40);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(10);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(50);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(30);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')
->setWidth(30);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('H')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('I')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('J')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('K')
->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Lista de Asociados Antiguos');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:K1');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Registro')
->setCellValue('B3', 'Asociado')
->setCellValue('C3', 'Tipo')
->setCellValue('D3', 'Contacto')
->setCellValue('E3', 'Dirección')
->setCellValue('F3', 'Zona')
->setCellValue('G3', 'Ciudad')
->setCellValue('H3', 'Departamento')
->setCellValue('I3', 'Teléfono')
->setCellValue('J3', 'Celular')
->setCellValue('K3', 'Correo electrónico');

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
$objPHPExcel->getActiveSheet()
->getStyle("K3")
->getFont()
->setBold(true);

$i=3;

	$mes = $_POST['filtro_mes'];//$session->get('antiguedad');
	$anio = $_POST['filtro_anio'];//$session->get('antiguedad');
	$asociado = $_POST['filtro_asociado'];//$session->get('asociado');
	$registro = $_POST['filtro_registro'];//$session->get('registro');
	$id_categoria = $_POST['filtro_id_categoria'];//$session->get('id_categoria');
	
	$where = '';
	if(!empty($asociado) || !empty($registro) || !empty($id_categoria) || !empty($anio)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($anio != ''){
			if($mes != '')
				$anio.= '-'.$mes;
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
			}
		}
	 
	$query = 'SELECT c.*, cat.categoria, cat.sigla AS categoria_sigla, s.tipo AS sociedad, s.sigla AS sociedad_sigla, i.id AS id_info, i.id_categoria, e.estado, i.id_usuario_cobrador, i.id_usuario_mensajero, i.capital, i.matr_recsa, i.resol_recsa, i.testimonio, i.poder, i.detalle, e.estado, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.zona, i.ciudad, i.activo, e.color
	FROM cgn_erp_clientes AS c 
	LEFT JOIN cgn_erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN cgn_erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN cgn_erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN cgn_erp_clientes_rel_estado AS es ON i.id_cliente = es.id_cliente
	LEFT JOIN cgn_erp_clientes_estado AS e ON es.id_estado = e.id
	WHERE i.activo = "1" AND c.valido = "1" '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC';
	$rs = $conn->query($query);
	
while($cliente = $rs->fetch_assoc()){
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_comunicacion AS c
	LEFT JOIN cgn_erp_clientes_comunicaciontipo AS t ON c.id_tipo = t.id
	WHERE c.id_cliente = "'.$cliente['id'].'" AND t.empresa = "1" AND t.t = "e"';
	$rs_e = $conn->query($query);
	while($rw_e = $rs_e->fetch_assoc()){
		$email.= $rw_e['numero'].'; ';
    }
	$fono = '';
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_comunicacion AS c
	LEFT JOIN cgn_erp_clientes_comunicaciontipo AS t ON c.id_tipo = t.id
	WHERE c.id_cliente = "'.$cliente['id'].'" AND t.empresa = "1" AND t.t = "t"';
	$rs_t = $conn->query($query);
	while($rw_t = $rs_t->fetch_assoc()){
		$fono.= $rw_t['numero'].'; ';
    }
	$celular = '';
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_comunicacion AS c
	LEFT JOIN cgn_erp_clientes_comunicaciontipo AS t ON c.id_tipo = t.id
	WHERE c.id_cliente = "'.$cliente['id'].'" AND t.empresa = "1" AND t.t = "c"';
	$rs_c = $conn->query($query);
	while($rw_c = $rs_c->fetch_assoc()){
		$celular.= $rw_c['numero'].'; ';        
    }
	$i++;
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit('A'.$i, $cliente['registro'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('B'.$i, utf8_encode($cliente['empresa']))
	->setCellValue('C'.$i, utf8_encode($cliente['sociedad']))
	->setCellValue('D'.$i, utf8_encode($cliente['nombre'].' '.$cliente['apellido']))
	->setCellValue('E'.$i, utf8_encode($cliente['direccion']))
	->setCellValue('F'.$i, utf8_encode($cliente['zona']))
	->setCellValue('G'.$i, utf8_encode($cliente['ciudad']))
	->setCellValue('H'.$i, departamento($cliente['id_estado']))
	->setCellValue('I'.$i, $fono)
	->setCellValue('J'.$i, $celular)
	->setCellValue('K'.$i, $email);
}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Asociados');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista de Asociados por Antiguedad.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>