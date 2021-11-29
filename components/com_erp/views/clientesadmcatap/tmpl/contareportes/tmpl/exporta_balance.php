<?php
/** Incluir la libreria PHPExcel */
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
$estilo = array( 
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );
$objPHPExcel->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Balance de Resultados")
->setSubject("Balance de Resultados")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Balance de Resultados");
 
// Agregar Informacion
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'FFd9b7f4')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '3a2a47'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()
->getColumnDimension('A')
->setWidth(15);
$objPHPExcel->getActiveSheet()
->getColumnDimension('B')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('C')
->setWidth(120);
$objPHPExcel->getActiveSheet()
->getColumnDimension('D')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('E')
->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('F')

->setWidth(20);
$objPHPExcel->getActiveSheet()
->getColumnDimension('G')
->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'BALANCE GENERAL');

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


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A3', 'Nro')
->setCellValue('B3', 'Código')
->setCellValue('C3', 'Nombre')
->setCellValue('D3', '1')
->setCellValue('E3', '2')
->setCellValue('F3', '3')
->setCellValue('G3', '4');

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
->applyFromArray($estilo)
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("E3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D')->applyFromArray($estilo);
$objPHPExcel->getActiveSheet()->getStyle('E')->applyFromArray($estilo);
$objPHPExcel->getActiveSheet()
->getStyle("F3")
->getFont()
->setBold(true);
$objPHPExcel->getActiveSheet()
->getStyle("G3")
->getFont()
->setBold(true);


$id_gestion = $_POST['e_id_gestion'];

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
function nombre($nom){
    $nom = str_replace('&nbsp;', ' ', $nom);
    $nom = str_replace('&nbsp', ' ', $nom);
    return $nom;
}
$i = 4;

  // INGRESOS
  ##Crea tabla temporal
    $query_temp = 'CREATE TEMPORARY TABLE cgn_erp_conta_tempbalance
        (
        id int(11) NOT NULL auto_increment,
        id_cuenta int(11) NOT NULL,
        codigo bigint(20), 
        cuenta varchar(100),
        debe decimal(11,2),
        haber decimal(11,2),
        PRIMARY KEY  (`id`)
        );';
    $conn->query($query_temp);
 
    //creaTemporal();
    //cuentasBalanceExcel(0, 0, 4);
  

    $querycuentas = 'SELECT * FROM cgn_erp_conta_cuentas WHERE id_padre = "0" AND sec = "B" AND id_gestion = "'.$id_gestion.'"';
    //echo $querycuentas;
    $cuentas_pr = $conn->query($querycuentas);
    while($cta_pr = $cuentas_pr->fetch_assoc()){
        
        $n = 0;
        $aux = $_POST['aux'];
	
        $id_gestion = $_POST['e_id_gestion'];
        $where = '';
        $id_padre = $cta_pr['id'];
        if($id_padre != 0)
            $where = 'parent.id = "'.$id_padre.'" AND ';

        if($aux == 0)
            $whereaux = ' AND node.codigo != "0"';

        $query_c = 'SELECT node.*, parent.nombre AS nombre_padre, CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", node.nivel - 1), node.nombre) AS nombre_completo, (COUNT(parent.nombre) - 1) AS depth, parent.codigo AS codigo_padre
        FROM cgn_erp_conta_cuentas AS node, cgn_erp_conta_cuentas AS parent 
        WHERE '.$where.'node.id_gestion = "'.$id_gestion.'" AND parent.id_gestion = "'.$id_gestion.'" AND node.lft BETWEEN parent.lft AND parent.rgt '.$whereaux.'
        GROUP BY node.id
        ORDER BY node.lft';
        //echo $query_c;
        $cuentas = $conn->query($query_c);
        $debet = 0;
        $habert = 0;
        while($cta = $cuentas->fetch_assoc()){
            $n++;
            $debe ='';
            $haber = '';
            
            $query2 = 'SELECT rgt, lft FROM cgn_erp_conta_cuentas WHERE id = "'.$cta['id'].'"';
            //echo $query2;
            $ccta = $conn->query($query2);
            //echo "hola";
            while($c = $ccta->fetch_assoc()){
                if(($c['rgt'] - $c['lft']) == 1){
                    $child = 1;
                }else{
                    $child = 0;                
                }
            }
            //echo $child;
            if($child == 1){
                $total_debe = 0;
                $total_haber = 0;
                if($_POST['fecha']){
                    $fecha = $_POST['fecha'];
                    $f = explode('/', $fecha);
                }
                if($fecha != '')
                    $where3 = ' AND fec_creacion <= "'.$f[2].'-'.$f[1].'-'.$f[0].'"';

                $query3 = 'SELECT cd.* 
                FROM cgn_erp_conta_comprobante_detalle AS cd 
                LEFT JOIN cgn_erp_conta_comprobante AS c ON cd.id_comprobante = c.id 
                WHERE cd.codigo LIKE "'.$cta['codigo'].'%" AND c.id_gestion = "'.$id_gestion.'"'.$where3;
                $cuentaschild = $conn->query($query3);
                while($cuenta = $cuentaschild->fetch_assoc()){
                    $total_debe+= $cuenta['debe'];
                    $total_haber+= $cuenta['haber'];
                }
                $total = $total_haber - $total_debe;
                if($total < 0){
                    $debe = $total * (-1);
                    $haber = '';
                }else{
                    $debe = '';
                    $haber = $total;
                }
            }
            if($total < 0 or $total > 0){
            $query = 'INSERT INTO #__erp_conta_tempbalance(id_cuenta,  codigo, cuenta, debe, haber) VALUES(';
            $query.= '"'.$cta['id'].'"';
            $query.= ', "'.$cta['codigo'].'"';
            $query.= ', "'.$cta['nombre'].'"';
            $query.= ', "'.$debe.'"';
            $query.= ', "'.$haber.'"';
            $query.= ')';
            
            $cod = codigoRename($cta['codigo']);
            $nombre = nombre($cta['nombre_completo']);
            $nombrec = nombre($nombre);
            $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.$i, $n)
              ->setCellValue('B'.$i, $cod)
              ->setCellValue('C'.$i, utf8_encode($nombrec))
              ->setCellValue('D'.$i, num2monto($debe))
              ->setCellValue('E'.$i, num2monto($haber));
            $i++;
            
            $debet+= $debe;
            $habert+= $haber;
        }}
        /*$query4 = 'SELECT * FROM cgn_erp_conta_tempbalance WHERE 1';
        //echo $query4;
        $cuentatem = $conn->query($query4);
        while($tmp = $cuentatem->fetch_assoc()){
        }*/
        $code = codigoRename($ct_pra['codigo']);
        $nombrecta = nombre($cta_pr['nombre']);
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, '')
          ->setCellValue('B'.$i, $code)
          ->setCellValue('C'.$i, $nombrecta)
          ->setCellValue('D'.$i, num2monto($debet))
          ->setCellValue('E'.$i, num2monto($habert));
        $i++;
        $totals = $debet - $habert  ;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, '')
          ->setCellValue('B'.$i, '')
          ->setCellValue('C'.$i, '')
          ->setCellValue('D'.$i, 'Total')
          ->setCellValue('E'.$i, num2monto($totals));
        
        
    }
$i = 10;
$querycuentas = 'SELECT * FROM cgn_erp_conta_cuentas WHERE id_padre = "0" AND sec = "R" AND id_gestion = "'.$id_gestion.'"';
    //echo $querycuentas;
    $cuentas_pr = $conn->query($querycuentas);
while($cta_pr = $cuentas_pr->fetch_assoc()){
        
        $n = 0;
        $aux = $_POST['aux'];
        $id_gestion = $_POST['e_id_gestion'];
	
        $where = '';
        $id_padre = $cta_pr['id'];
        if($id_padre != 0)
            $where = 'parent.id = "'.$id_padre.'" AND ';
        if($aux == 0)
            $whereaux = ' AND node.codigo != "0"';

        $query_c = 'SELECT node.*, parent.nombre AS nombre_padre, CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", node.nivel - 1), node.nombre) AS nombre_completo, (COUNT(parent.nombre) - 1) AS depth, parent.codigo AS codigo_padre
        FROM cgn_erp_conta_cuentas AS node, cgn_erp_conta_cuentas AS parent 
        WHERE '.$where.'node.id_gestion = "'.$id_gestion.'" AND parent.id_gestion = "'.$id_gestion.'" AND node.lft BETWEEN parent.lft AND parent.rgt '.$whereaux.'
        GROUP BY node.id
        ORDER BY node.lft';
        //echo $query_c;
        $cuentas = $conn->query($query_c);
        $debet = 0;
        $habert = 0;
        $total=0;
        while($cta = $cuentas->fetch_assoc()){
            if($total!=0){
                $n++;
            }
            $debe ='';
            $haber = '';
            
            $query2 = 'SELECT rgt, lft FROM cgn_erp_conta_cuentas WHERE id = "'.$cta['id'].'"';
            //echo $query2;
            $ccta = $conn->query($query2);
            //echo "hola";
            while($c = $ccta->fetch_assoc()){
                if(($c['rgt'] - $c['lft']) == 1){
                    $child = 1;
                }else{
                    $child = 0;                
                }
            }
            //echo $child;
            if($child == 1){
                $total_debe = 0;
                $total_haber = 0;
                if($_POST['e_fecha']){
                    $fecha = $_POST['e_fecha'];
                    $f = explode('/', $fecha);
                }
                if($fecha != '')
                    $where3 = ' AND fec_creacion <= "'.$f[2].'-'.$f[1].'-'.$f[0].'"';

                $query3 = 'SELECT cd.* 
                FROM cgn_erp_conta_comprobante_detalle AS cd 
                LEFT JOIN cgn_erp_conta_comprobante AS c ON cd.id_comprobante = c.id 
                WHERE cd.codigo LIKE "'.$cta['codigo'].'%" AND c.id_gestion = "'.$id_gestion.'"'.$where3;
                $cuentaschild = $conn->query($query3);
                while($cuenta = $cuentaschild->fetch_assoc()){
                    $total_debe+= $cuenta['debe'];
                    $total_haber+= $cuenta['haber'];
                }
                $total = $total_haber - $total_debe;
                if($total < 0){
                    $debe = $total * (-1);
                    $haber = '';
                }else{
                    $debe = '';
                    $haber = $total;
                }
            }
            $query = 'INSERT INTO #__erp_conta_tempbalance(id_cuenta,  codigo, cuenta, debe, haber) VALUES(';
            $query.= '"'.$cta['id'].'"';
            $query.= ', "'.$cta['codigo'].'"';
            $query.= ', "'.$cta['nombre'].'"';
            $query.= ', "'.$debe.'"';
            $query.= ', "'.$haber.'"';
            $query.= ')';
            
            $cod = codigoRename($cta['codigo']);
            $nombre = nombre($cta['nombre_completo']);
            $nombrec = nombre($nombre);
            if($total!=0){
            
            $i++;
            }            
            $debet+= $debe;
            $habert+= $haber;
        }
        /*$query4 = 'SELECT * FROM cgn_erp_conta_tempbalance WHERE 1';
        //echo $query4;
        $cuentatem = $conn->query($query4);
        while($tmp = $cuentatem->fetch_assoc()){
        }*/
        $code = codigoRename($ct_pra['codigo']);
        $nombrecta = nombre($cta_pr['nombre']);
        
        $i++;
        $tot = $habert - $debet;
        
        $i++;
        $i++;
        array_push($diferenciatotal,$tot);
    }    
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, '')
      ->setCellValue('B'.$i, '')
      ->setCellValue('C'.$i, 'RESULTADOS DE LA GESTIÓN')
      ->setCellValue('D'.$i, '')
      ->setCellValue('E'.$i, num2monto($diferenciatotal[1]-$tot));
$i++;
$t=$diferenciatotal[1]-$tot;
$objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, '')
      ->setCellValue('B'.$i, '')
      ->setCellValue('C'.$i, '')
      ->setCellValue('D'.$i, 'TOTAL')
      ->setCellValue('E'.$i, num2monto(($totals+$t)*(-1)));
    
    $i++;
        
    $query_vacia = 'TRUNCATE cgn_erp_conta_tempbalance';
    $conn->query($query_vacia);
   
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Balance General');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Balance General.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>