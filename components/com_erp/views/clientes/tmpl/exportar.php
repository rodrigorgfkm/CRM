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

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($_POST['nit'] == 1 ? 50 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth($_POST['testimonio_nro'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($_POST['mat_fundaempresa'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($_POST['capital'] == 1 ? 20 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth($_POST['correo'] == 1 ? 20 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($_POST['telefono'] == 1 ? 20 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($_POST['celular'] == 1 ? 20 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($_POST['casilla'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth($_POST['dirección'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth($_POST['zona'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth($_POST['ciudad'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth($_POST['departamento'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth($_POST['inscrito_por'] == 1 ? 30 : 0);

$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth($_POST['libro'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth($_POST['tomo'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth($_POST['partida'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth($_POST['categoría'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth($_POST['cobrador'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth($_POST['mensajería'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth($_POST['atache'] == 1 ? 30 : 0);

$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth($_POST['nombreyapellido'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth($_POST['cargo'] == 1 ? 30 : 0);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth($_POST['poder_nro'] == 1 ? 30 : 0);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Lista de Asociados');

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setBold(true);

$objPHPExcel->getActiveSheet()
->getStyle("A1")
->getFont()
->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:AE1');

$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', 'Registro')
	->setCellValue('B3', 'Asociado')
	->setCellValue('C3', 'Tipo')
	->setCellValue('D3', 'NIT')
	->setCellValue('E3', 'Testimonio')
	->setCellValue('F3', 'FUNDEMPRESA')
	->setCellValue('G3', 'Capital')
	->setCellValue('H3', 'Correo electrónico')
	->setCellValue('I3', 'Teléfono')
	->setCellValue('J3', 'Celular')
	->setCellValue('K3', 'Casilla')
	->setCellValue('L3', 'Dirección')
	->setCellValue('M3', 'Zona')
	->setCellValue('N3', 'Ciudad')
	->setCellValue('O3', 'Departamento')
	->setCellValue('P3', 'Inscrito por')

	->setCellValue('Q3', 'Libro')
	->setCellValue('R3', 'Tomo')
	->setCellValue('S3', 'Partida')
	->setCellValue('T3', 'Categoria')
	->setCellValue('U3', 'Cobrador')
	->setCellValue('V3', 'Mensajeria')
	->setCellValue('W3', 'Atache')

	->setCellValue('X3', 'Contacto')
	->setCellValue('Y3', 'Cargo')
	->setCellValue('Z3', 'Poder Nro.');

$objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("D3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("E3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("F3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("G3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("H3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("I3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("J3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("K3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("L3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("M3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("N3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("O3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("P3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("Q3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("R3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("S3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("T3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("U3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("V3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("W3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("X3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("Y3")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("Z3")->getFont()->setBold(true);

$i=3;

	$antiguedad = $_POST['filtro_antiguedad'];//$session->get('antiguedad');
	$asociado = $_POST['filtro_asociado'];//$session->get('asociado');
	$registro = $_POST['filtro_registro'];//$session->get('registro');
	$id_categoria = $_POST['filtro_id_categoria'];//$session->get('id_categoria');
	
	$where = '';
	if(!empty($asociado) || !empty($registro) || !empty($id_categoria) || !empty($antiguedad)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($antiguedad != ''){
			$anio = date('Y') - $antiguedad;
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
			}
		}
	 
	$query = 'SELECT c.*, cat.categoria, cat.sigla AS categoria_sigla, s.tipo AS sociedad, s.sigla AS sociedad_sigla, i.id AS id_info, i.id_categoria, i.id_usuario_cobrador, i.id_usuario_mensajero, i.capital, i.matr_recsa, i.resol_recsa, i.testimonio, i.mat_fundempresa, i.poder, i.detalle, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.zona, i.ciudad, i.activo, e.color
	FROM cgn_erp_clientes AS c 
	LEFT JOIN cgn_erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN cgn_erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN cgn_erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN cgn_erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	LEFT JOIN cgn_erp_clientes_estado AS e ON rce.id_estado = e.id
	WHERE i.activo = "1" AND c.valido = "1" '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC';
	$rs = $conn->query($query);
	
while($cliente = $rs->fetch_assoc()){
	
	$email = '';
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_contacto AS c
	LEFT JOIN cgn_erp_clientes_info AS t ON c.id_info = t.id
	WHERE t.id_cliente = "'.$cliente['id'].'" AND c.tipo = "e" AND c.seccion = "e"';
	$rs_e = $conn->query($query);
	while($rw_e = $rs_e->fetch_assoc())
		$email.= $rw_e['valor'].'; ';
		
	$fono = '';
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_contacto AS c
	LEFT JOIN cgn_erp_clientes_info AS t ON c.id_info = t.id
	WHERE t.id_cliente = "'.$cliente['id'].'" AND c.tipo = "t" AND c.seccion = "e"';
	$rs_t = $conn->query($query);
	while($rw_t = $rs_t->fetch_assoc())
		$fono.= $rw_t['valor'].'; ';
		
	$celular = '';
	$query = 'SELECT c.* 
	FROM cgn_erp_clientes_comunicacion AS c
	LEFT JOIN cgn_erp_clientes_comunicaciontipo AS t ON c.id_tipo = t.id
	WHERE c.id_cliente = "'.$cliente['id'].'" AND t.empresa = "1" AND t.t = "c"';
	$rs_c = $conn->query($query);
	while($rw_c = $rs_c->fetch_assoc())
		$celular.= $rw_c['numero'].'; ';
    
    $query = 'SELECT * 
	FROM cgn_erp_clientes_mca
	WHERE id = "'.$cliente['id_usuario_cobrador'].'"';
	$rs_cob = $conn->query($query);
	while($rw_cb = $rs_cob->fetch_assoc())
		$cobrador = $rw_cb['nombre'];
    
    $query = 'SELECT * 
	FROM cgn_erp_clientes_mca
	WHERE id = "'.$cliente['id_usuario_mensajero'].'"';
	$rs_mens = $conn->query($query);
	while($rw_mensj = $rs_mens->fetch_assoc())
		$mensajero = $rw_mensj['nombre'];
    
    $query = 'SELECT * 
	FROM cgn_erp_clientes_mca
	WHERE id = "'.$cliente['atache'].'"';
	$rs_ata = $conn->query($query);
	while($rw_atach = $rs_ata->fetch_assoc())
		$atache = $rw_atach['nombre'];
    
	$i++;
	
	$contacto = '';//$utf8_encode($cliente['nombre'].' '.$cliente['apellido']);
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit('A'.$i, $cliente['registro'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('B'.$i, utf8_encode($cliente['empresa']))
	->setCellValue('C'.$i, utf8_encode($cliente['sociedad']))
	->setCellValueExplicit('D'.$i, $cliente['nit'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('E'.$i, $cliente['testimonio'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('F'.$i, $cliente['mat_fundempresa'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('G'.$i, $cliente['capital'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('H'.$i, $email)
	->setCellValueExplicit('I'.$i, $fono, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit('J'.$i, $celular, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue('K'.$i, $cliente['casilla'])
	->setCellValue('L'.$i, utf8_encode($cliente['direccion']))
	->setCellValue('M'.$i, utf8_encode($cliente['zona']))
	->setCellValue('N'.$i, utf8_encode($cliente['ciudad']))
	->setCellValue('O'.$i, departamento($cliente['id_estado']))
	->setCellValue('P'.$i, $cliente['inscrito'])
	
	->setCellValue('Q'.$i, $cliente['libro'])
	->setCellValue('R'.$i, $cliente['tomo'])
	->setCellValue('S'.$i, $cliente['partida'])
	->setCellValue('T'.$i, $cliente['categoria'])
	->setCellValue('U'.$i, utf8_encode($cobrador))
	->setCellValue('V'.$i, utf8_encode($mensajero))
	->setCellValue('W'.$i, utf8_encode($atache))
	
	->setCellValue('X'.$i, $contacto)
	->setCellValue('Y'.$i, $cliente['cargo'])
	->setCellValue('Z'.$i, $cliente['poder']);
	}
 
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Asociados');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista de Asociados.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>