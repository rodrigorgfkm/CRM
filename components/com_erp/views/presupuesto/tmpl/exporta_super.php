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
->setTitle("Presupuestos")
->setSubject("Resumen Presupuestos")
->setDescription("")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Resumen Presupuestos");
 
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
->setCellValue('A1', 'Resumen Presupuestos');

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
->setCellValue('A3', 'Cuentas')
->setCellValue('B3', utf8_encode('Presupuesto Al '.date('d/m/Y')))
->setCellValue('C3', 'Presupuesto')
->setCellValue('D3', 'Ejecutado')
->setCellValue('E3', 'Diferecia')
->setCellValue('F3', 'Presupuestado Acum.')
->setCellValue('G3', 'Ejecutado Acum.')
->setCellValue('H3', 'Diferencia Acum.')
->setCellValue('I3', '% Diferencia')
->setCellValue('J3', '% s/Total Gestión');

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

/*Desde aqui comienzan las conslutas*/
$total_sum_monto = 0;
$total_sum_monto_mes = 0;
$total_sum_monto_ejec = 0;
$total_sum_dif = 0;
$total_sum_p_acum = 0;
$total_sum_p_ejec = 0;
$total_sum_dif_acm = 0;
$total_sum_porc = 0;
$total_sum_total = 0;

$id_gestion = $_POST['id_gestion_e'];
$mes = $_POST['mes_e'];
$cta_code = $_POST['cuenta_e'];
$moneda = $_POST['moneda'];
if($cta_code == 'ing'){    
//300001
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "3__001%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=4;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('3.XX.001.0000  INGRESOS POR SERVICIOS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;

//300002
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "3__002%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('3.XX.002.0000 SEMINARIOS Y CONFERENCIAS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//300002
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "3__003%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('3.XX.003.0000 OTROS INGRESOS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;

$i = $i+3;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('TOTAL RUBRO 3000000000 INGRESOS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));
}elseif($cta_code == 'egr'){
//400001
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__001%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=4;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.001.0000 REMUNERACIONES'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;

//400002
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__002%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.002.0000 IMPUESTOS Y OTROS GRAVAMENES'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//400003
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__003%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.003.0000 GASTOS GENERALES'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//400004
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__004%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.004.0000 GASTOS INSTITUCIONALES'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//400005
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__005%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.005.0000 COSTO INVERSION ACTIVO FIJO'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//400007
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__007%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.007.0000 SEMINARIOS Y CONFERENCIAS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
//400008
$query = 'SELECT c.id, c.nombre, c.codigo, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" AND c.codigo LIKE "4__008%" GROUP BY c.id';
$reg = $conn->query($query);
    	
$i=$i+2;

$sum_monto = 0;
$sum_monto_mes = 0;
$sum_monto_ejec = 0;
$sum_dif = 0;
$sum_p_acum = 0;
$sum_p_ejec = 0;
$sum_dif_acm = 0;
$sum_porc = 0;
$sum_total = 0;

while($cuenta = $reg->fetch_assoc()){
    $sum_monto = $sum_monto+$cuenta['monto_e'];
    $sum_monto = $sum_monto/$moneda;
    
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $montos = $conn->query($query);
    
    while($amount = $montos->fetch_assoc()){
        $monto_mes_p = $amount['monto'];
    }
    $monto_mes_p = $monto_mes_p/$moneda;
    $sum_monto_mes = $sum_monto_mes + $monto_mes_p;
    $sum_monto_mes = $sum_monto_mes/$moneda;
    //EJECUTADO 2018
    $mes_ejec = $cuenta['monto_e']/12;
    $mes_ejec = $mes_ejec/$moneda;
    $sum_monto_ejec = $sum_monto_ejec + $mes_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //DIFERENCIA
    $diferencia = $mes_ejec - $monto_mes_p;
    $diferencia = $diferencia/$moneda;
    $sum_dif = $sum_dif + ($diferencia);
    $sum_dif = $sum_dif/$moneda;
    //suma de meses acumulado de la gestion
    $acumulado_pres = 0;
    for($j = $mes; $j > 0; $j--){
        $query = 'SELECT monto
        FROM cgn_erp_presupuesto 
        WHERE id_cta_contable = "'.$cuenta['id'].'" AND mes = "'.$j.'" AND id_gestion = "'.$id_gestion.'"';
        $montos_ac = $conn->query($query);

        while($amount = $montos_ac->fetch_assoc()){
            $monto_mes_ac = $amount['monto'];
        }
        $acumulado_pres = $acumulado_pres + $monto_mes_ac;
        $acumulado_pres = $acumulado_pres/$moneda;
    }
    $sum_p_acum = $sum_p_acum+$acumulado_pres;
    $sum_p_acum = $sum_p_acum+$moneda;
    //sacando el ejecutado acumulado
    $query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM cgn_erp_conta_comprobante_detalle AS d 
	LEFT JOIN cgn_erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN cgn_erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$cuenta['id'].'" AND c.revertido!="1" ORDER BY c.numero ASC';
    $acum = $conn->query($query);
    $acumulado_ejec = 0;  
    $total_debe = 0;
    $total_haber = 0;
    while($mayor = $acum->fetch_assoc()){
        $total_debe+= $mayor['debe'];
        $total_haber+= $mayor['haber'];
        $acumulado_ejec = $total_debe - $total_haber;
    }
    $sum_monto_ejec = $sum_monto_ejec + $acumulado_ejec;
    $sum_monto_ejec = $sum_monto_ejec/$moneda;
    //Diferencia acumulada
    $diferencia_acumulada = $acumulado_ejec - $acumulado_pres;
    $sum_dif_acm = $sum_dif_acm + $diferencia_acumulada;
    $sum_dif_acm = $sum_dif_acm / $moneda;
    //DIF porcentual
    $diff = ($diferencia_acumulada/$acumulado_pres) * 100;
    $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?num2monto($diff):'0,00';
    $sum_dif_acm = $sum_dif_acm+($t_diff);
    //SUBTOTALES
    $total_cta = ($acumulado_ejec/$cuenta['monto_e'])*100;
    $sub_total = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?num2monto($total_cta):'0,00';
    $sum_total = $sum_total + $sub_total;   
}
$i++;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('4.XX.008.0000 COSTOS POR SERVICIOS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));

$sum_monto = $sum_monto + $sum_monto;
$sum_monto_mes = $sum_monto_mes + $sum_monto_mes;
$sum_monto_ejec = $sum_monto_ejec +$sum_monto_ejec; 
$sum_dif = $sum_dif + $sum_dif;
$sum_p_acum = $sum_p_acum + $sum_p_acum;
$sum_p_ejec = $sum_p_ejec + $sum_p_ejec;
$sum_dif_acm = $sum_dif_acm + $sum_dif_acm;
$sum_porc = $sum_porc + $sum_porc;
$sum_total = $sum_total + $sum_total;
$i = $i+3;
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, utf8_encode('TOTAL RUBRO 3000000000 INGRESOS'))
    ->setCellValue('B'.$i, utf8_encode(num2monto($sum_monto)))
    ->setCellValue('C'.$i, utf8_encode(num2monto($sum_monto_mes)))
    ->setCellValue('D'.$i, utf8_encode(num2monto($sum_monto_ejec)))
    ->setCellValue('E'.$i, utf8_encode(num2monto($sum_dif)))
    ->setCellValue('F'.$i, utf8_encode(num2monto($sum_p_acum)))
    ->setCellValue('G'.$i, utf8_encode(num2monto($sum_p_ejec)))
    ->setCellValue('H'.$i, utf8_encode(num2monto($sum_dif_acm)))
    ->setCellValue('I'.$i, utf8_encode(num2monto($sum_porc)))
    ->setCellValue('J'.$i, utf8_encode(num2monto($sum_total)));
}
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Resumen de Presupuesto');
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Resumen de Presupuesto.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>