<?php
$n = 0;
function countComprobantes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_comprobante WHERE 1';
	$db->setQuery($query);
	$db->execute();
	$num_rows = $db->getNumRows();
	return $num_rows;
	}
function cuenta(){
	$db =& JFactory::getDBO();
	$query = 'SELECT c.*, p.id as p_id, p.nombre as p_nombre, p.codigo as p_codigo 
	FROM #__erp_conta_cuentas AS c  
	LEFT JOIN #__erp_conta_cuentas as p ON c.id_padre = p.id 
	WHERE c.id = '.JRequest::getVar('id', '0', 'get');
	$db->setQuery($query);  
	$cuenta = $db->loadObject();
	return $cuenta;
	}
	
function monto($codigo){
	$db =& JFactory::getDBO();  
	$query = 'SELECT SUM(debe) AS total_debe, SUM(haber) AS total_haber FROM #__erp_conta_comprobante_detalle WHERE codigo LIKE "'.$codigo.'%"';  
	$db->setQuery($query);  
	$monto = $db->loadObject();
	return $monto->total_debe - $monto->total_haber;
	}
function hasChild($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id_padre) FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" AND codigo != "0"';
	$db->setQuery($query);  
	$padre = $db->loadResult();
	if($padre > 0)
		$child = true;
		else
		$child = false;
	return $child;
	}

function hasComp($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT() FROM #__erp_conta_comprobante_detalle WHERE id_cuenta = "'.$id.'"';
	$db->setQuery($query);  
	$comp = $db->loadResult();
	if($comp > 0)
		$child = true;
		else
		$child = false;
	return $child;
	}
	
// Cuentas contable
function getCuentas(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE 1 ORDER BY codigo'; 
	$db->setQuery($query); 
	$cuentas = $db->loadObjectList();  
	return $cuentas;
	}
function getCuenta($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id = "'.$id.'"'; 
	$db->setQuery($query); 
	$cuenta = $db->loadObject();
	return $cuenta;
	}
function getCuentasComprobante($id="", $m = 0){
	$db =& JFactory::getDBO();
	
	$rango = JRequest::getVar('rango', JRequest::getVar('r'), 'post');
	$mes = JRequest::getVar('mes', '', 'post');
	$fecha_ini = JRequest::getVar('fecha_ini', JRequest::getVar('fi'), 'post');
	$fecha_fin = JRequest::getVar('fecha_fin', JRequest::getVar('ff'), 'post');
	$nro_comp_inicio = JRequest::getVar('nro_comp_inicio', JRequest::getVar('nro_comp_inicio', '', 'get'), 'post');
	$nro_comp_fin = JRequest::getVar('nro_comp_fin', JRequest::getVar('nro_comp_fin', '', 'get'), 'post');
		
	$where = '';
	if($rango != 1){
		if($mes != ''){
			$where .= ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';}
    }else{
		if($fecha_ini != ''){
			$where.= ' AND c.fec_creacion >= "'.fecha2($fecha_ini).'"';
        }
		if($fecha_fin != ''){
			$where.= ' AND c.fec_creacion <= "'.fecha2($fecha_fin).'"';
        }
    }
    //presupuestos
    if($m != 0){
        $where .= ' AND c.fec_creacion LIKE "%-'.$m.'-%"';
    }
	if($nro_comp_inicio != ''){
		$where.= ' AND c.numero >= "'.$nro_comp_inicio.'"';
		}
	if($nro_comp_fin != ''){
		$where.= ' AND c.numero <= "'.$nro_comp_fin.'"';
		}
	/*if($id=''){
        $where .= ' AND ';
    }*/
	$query = 'SELECT d.*, c.id, c.numero, c.detalle, c.cliente, c.fec_creacion, c.tipo_cambio, t.tipo
	FROM #__erp_conta_comprobante_detalle AS d 
	LEFT JOIN #__erp_conta_comprobante AS c ON d.id_comprobante = c.id 
	LEFT JOIN #__erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE d.id_cuenta = "'.$id.'" AND c.revertido!="1"'.$where.'
	ORDER BY c.numero ASC';
    /*echo '</br>';
    echo '</br>';
	echo $query;*/
	$db->setQuery($query); 
	$cuentas = $db->loadObjectList();  
	return $cuentas;
	}

function cuentas($id, $indent){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();  
	$layout = JRequest::getVar('layout', '', 'get');
	if($layout == 'edita' || $layout == 'nuevo' || $layout == 'relaciona'){
		$link = 'onclick="asigna(\'{cuenta_nombre}\', \'{cuenta_id}\')"';
		}else{
		$link = 'href="index.php?option=com_erp&view=contacuentas&layout=edita&id={cuenta_id}"';
		}
		
	foreach($cuentas as $cuenta) {
		if(verifyCuentaContable($cuenta->id) > 0)
			$td_add = '<a href="" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>';
		
		$link2 = str_replace('{cuenta_id}', $cuenta->id, $link);
		$link2 = str_replace('{cuenta_nombre}', $cuenta->nombre, $link2);
		
		$GLOBALS['n']++;
		echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
                                    <td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i><a '.$link2.'> '.$cuenta->nombre.'</a></td>
									<td style="text-align:right">'.number_format(monto($cuenta->codigo),2,",",".").'</td>
                                  </tr>';
		if(hasChild($cuenta->id))
			cuentas($cuenta->id, ($indent+1));
		}
	}

function creaTemporal(){
	$db =& JFactory::getDBO();
	$query = 'CREATE TEMPORARY TABLE #__erp_conta_tempbalance
	(
    id int(11) NOT NULL auto_increment,
    id_cuenta int(11) NOT NULL,
    codigo bigint(20), 
    cuenta varchar(100),
    debe decimal(11,2),
	haber decimal(11,2),
    PRIMARY KEY  (`id`)
    );';
	$db->setQuery($query);  
	$db->query();
	}
function vaciaTemporal(){
	$db =& JFactory::getDBO();
	$query = 'TRUNCATE #__erp_conta_tempbalance';
	$db->setQuery($query);  
	$db->query();
	}
function cuentasBalanceExcel($id, $indent, $padre){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" AND codigo LIKE "'.$padre.'%" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();  
		
	$i = 1;
	
	foreach($cuentas as $cuenta) {
		$GLOBALS['n']++;
		
		$debe ='';
		$haber = '';
		
		if($cuenta->eb == 1){
			$total = sumaCuentaBalance($cuenta->codigo);
			if($total < 0){
				$debe = $total * (-1);
				$haber = '';
				}else{
				$debe = '';
				$haber = $total;
				}
			}
		
		$query = 'INSERT INTO #__erp_conta_tempbalance(id_cuenta,  codigo, cuenta, debe, haber) VALUES(';
		$query.= '"'.$cuenta->id.'"';
		$query.= ', "'.$cuenta->codigo.'"';
		$query.= ', "'.$cuenta->nombre.'"';
		$query.= ', "'.$debe.'"';
		$query.= ', "'.$haber.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		if(hasChild($cuenta->id) && $cuenta->eb == 0)
			cuentasBalanceExcel($cuenta->id, ($indent+1), $padre);
		}
	}

function cuentasBalance($id, $indent, $padre){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" AND codigo LIKE "'.$padre.'%" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();  
		
	$i = 1;
	
	foreach($cuentas as $cuenta) {
		$GLOBALS['n']++;
		
		$debe ='';
		$haber = '';
		
		if($cuenta->eb == 1){
			$total = sumaCuentaBalance($cuenta->codigo);
			if($total < 0){
				$debe = $total * (-1);
				$haber = '';
				}else{
				$debe = '';
				$haber = $total;
				}
			}
		
		$query = 'INSERT INTO #__erp_conta_tempbalance(id_cuenta,  codigo, cuenta, debe, haber) VALUES(';
		$query.= '"'.$cuenta->id.'"';
		$query.= ', "'.$cuenta->codigo.'"';
		$query.= ', "'.$cuenta->nombre.'"';
		$query.= ', "'.$debe.'"';
		$query.= ', "'.$haber.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		if($haber > 0 || $debe > 0 || $cuenta->eb == 0){
			if(JRequest::getVar('layout', '', 'get') == 'imprime_balance' || JRequest::getVar('layout', '', 'get') == 'imprime_resultados'){
				echo '                                  <tr>
                                    <td><i style="margin-left:'.($indent*20).'px"></i> '.$cuenta->nombre.'</td>
									<td style="text-align:right">'.number_format($debe, 2, ',', ' ').'</td>
									<td style="text-align:right">'.number_format($haber, 2, ',', ' ').'</td>
                                  </tr>';
				}else{
				echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
                                    <td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px"></i> '.$cuenta->nombre.'</td>
									<td style="text-align:right">'.number_format($debe, 2, ',', ' ').'</td>
									<td style="text-align:right">'.number_format($haber, 2, ',', ' ').'</td>
                                  </tr>';
				}
			}
		
		if(hasChild($cuenta->id) && $cuenta->eb == 0)
			cuentasBalance($cuenta->id, ($indent+1), $padre);
		}
	}
function getTempBalance(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_tempbalance WHERE 1';
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;
	}

function sumaCuentaBalance($codigo){
	$db =& JFactory::getDBO();
	
	$total_debe = 0;
	$total_haber = 0;
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'post');
	
	$fecha = JRequest::getVar('fecha', JRequest::getVar('fecha','','get'), 'post');
	$f = explode('/', $fecha);
	//echo $fecha;
	if($fecha != '')
		$where = ' AND fec_creacion <= "'.$f[2].'-'.$f[1].'-'.$f[0].'"';
	
	$query = 'SELECT cd.* 
	FROM #__erp_conta_comprobante_detalle AS cd 
	LEFT JOIN #__erp_conta_comprobante AS c ON cd.id_comprobante = c.id 
	WHERE cd.codigo LIKE "'.$codigo.'%" AND c.id_gestion = "'.$id_gestion.'"'.$where;
	$db->setQuery($query);
	$cuentas = $db->loadObjectList();
	
	foreach($cuentas as $cuenta){
		$total_debe+= $cuenta->debe;
		$total_haber+= $cuenta->haber;
		}
	
	$total = $total_haber - $total_debe;
    
	return $total;
	}


$grantotal_debe = 0;
$grantotal_haber = 0;
$grantotal_deudor = 0;
$grantotal_acreedor = 0;

function cuentasListaSS($id, $indent){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
		
	foreach($cuentas as $cuenta) {
		
		$total_debe = 0;
		$total_haber = 0;
		foreach(getCuentasComprobante($cuenta->id) as $detalle){
			$total_debe+= $detalle->debe;
			$total_haber+= $detalle->haber;
			}
		
		$GLOBALS['grantotal_debe']+= $total_debe;
		$GLOBALS['grantotal_haber']+= $total_haber;
		//echo $GLOBALS['grantotal_debe'].'<br>';
		
		$saldo = $total_debe - $total_haber;
		//echo $saldo.'<br>';
		if($saldo < 0){
			$saldo_haber = $saldo * (-1);
			$saldo_debe = 0.00;
			$GLOBALS['grantotal_acreedor']+= $saldo * (-1);
			}else{
			$saldo_haber =  0.00;
			$saldo_debe = $saldo;
			$GLOBALS['grantotal_deudor']+= $saldo;
			}
		//echo $saldo_debe.' - '.$saldo_haber.'<br>';
		if($saldo_debe != '0' || $saldo_haber != '0' || $total_haber != '0'){
			echo '<tr><td>'.$cuenta->codigo.'</td><td>'.$cuenta->nombre.'</td><td style="text-align: right">'.number_format($total_debe, 2, ',', ' ').'</td><td style="text-align: right">'.number_format($total_haber, 2, ',', ' ').'</td><td style="text-align: right">'.number_format($saldo_debe, 2, ',', ' ').'</td><td style="text-align: right">'.number_format($saldo_haber, 2, ',', ' ').'</td></tr>';	
			}
		
		if(hasChild($cuenta->id))
			cuentasListaSS($cuenta->id, ($indent+1));
		}
	}

	
function cuentasListaGE($id, $indent){
	$db =& JFactory::getDBO();
	if($id == 0)
		$where = 'id_padre = "0" AND codigo < 4';
		else
		$where = 'id_padre = "'.$id.'"';
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE '.$where.' ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
		
	foreach($cuentas as $cuenta) {
		
		$total_debe = 0;
		$total_haber = 0;
		foreach(getCuentasComprobante($cuenta->id) as $detalle){
			$total_debe+= $detalle->debe;
			$total_haber+= $detalle->haber;
			}
		
		$GLOBALS['grantotal_debe']+= $total_debe;
		$GLOBALS['grantotal_haber']+= $total_haber;
		//echo $GLOBALS['grantotal_debe'].'<br>';
		
		$saldo = $total_debe - $total_haber;
		//echo $saldo.'<br>';
		if($saldo < 0){
			$saldo_haber = $saldo * (-1);
			$saldo_debe = 0.00;
			$GLOBALS['grantotal_acreedor']+= $saldo * (-1);
			}else{
			$saldo_haber =  0.00;
			$saldo_debe = $saldo;
			$GLOBALS['grantotal_deudor']+= $saldo;
			}
		//echo $saldo_debe.' - '.$saldo_haber.'<br>';
		if($saldo_debe != '0' || $saldo_haber != '0'){
			echo '
<tr>
  <td style="vertical-align:middle; text-align:center;"><i class="icon-resize-vertical" style="padding:0 5px; cursor:pointer"></i></td>
  <td>
	  '.$cuenta->codigo.'
	  <input name="codigo[]" type="hidden" value="'.$cuenta->codigo.'">
	  <input type="hidden" name="id[]" value="'.$cuenta->id.'">
  </td>
  <td>
  	'.$cuenta->nombre.'
	<input name="descripcion[]" type="hidden" value="'.$cuenta->nombre.'">
  </td>
  <td style="text-align:right">
  	'.number_format($saldo_debe, 2, ',', ' ').'
	<input name="debe[]" type="hidden" value="'.$saldo_debe.'">
  </td>
  <td style="text-align:right">
    '.number_format($saldo_haber, 2, ',', ' ').'
	<input name="haber[]" type="hidden" value="'.$saldo_haber.'">
  </td>
</tr>';
			}
		
		if(hasChild($cuenta->id))
			cuentasListaGE($cuenta->id, ($indent+1));
		}
	}

function cuentasListaSelect($id, $indent){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
		
	foreach($cuentas as $cuenta) {
		$espacio = '';
		for($i=0; $i<=($indent-1); $i++)
			$espacio.= '&nbsp;&nbsp;';
		
		echo '<option value="'.$cuenta->id.'">'.$espacio.'&rarr;'.$cuenta->nombre.'</option>';
		if(hasChild($cuenta->id))
			cuentasListaSelect($cuenta->id, ($indent+1));
		}
	}

function cuentasLista($id, $indent){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
		
	foreach($cuentas as $cuenta) {
		
		$enlaces = '<a href="index.php?option=com_erp&view=contacuentas&layout=edita&id='.$cuenta->id.'" class="btn btn-success span6"><i class="icon-pencil icon-white"></i></a>';
		if(verifyCuentaContable($cuenta->id) == 1)
			$enlaces.= '<a href="index.php?option=com_erp&view=contacuentas&layout=elimina&id='.$cuenta->id.'" class="btn btn-danger span6"><i class="icon-trash icon-white"></i></a>';
		
		$GLOBALS['n']++;
		echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
                                    <td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i> '.$cuenta->nombre.'</td>
									<td>'.$enlaces.'</td>
                                  </tr>';
		if(hasChild($cuenta->id))
			cuentasLista($cuenta->id, ($indent+1));
		}
	}
function cuentasListaBalance($id, $indent){
	$db =& JFactory::getDBO(); 
	$nivel = JRequest::getVar('nivel', 6, 'post');
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" AND nivel <= "'.$nivel.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
		
	foreach($cuentas as $cuenta) {
		
		$enlaces = '<a href="index.php?option=com_erp&view=contacuentas&layout=edita&id='.$cuenta->id.'" class="btn btn-success span6"><i class="icon-pencil icon-white"></i></a>';
		if(verifyCuentaContable($cuenta->id) == 1)
			$enlaces.= '<a href="index.php?option=com_erp&view=contacuentas&layout=elimina&id='.$cuenta->id.'" class="btn btn-danger span6"><i class="icon-trash icon-white"></i></a>';
		
		$GLOBALS['n']++;
		echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
                                    <td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i> '.$cuenta->nombre.'</td>
									<td><input type="text" name="id_'.$cuenta->id.'"></td>
                                  </tr>';
		if(hasChild($cuenta->id))
			cuentasListaBalance($cuenta->id, ($indent+1));
		}
	}
	
function verifyCuentaContable($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) AS cant FROM #__erp_conta_comprobante_detalle WHERE id_cuenta = "'.$id.'"';
	$db->setQuery($query);
	$cant_comprobantes = $db->loadResult();
	
	$query = 'SELECT COUNT(id) AS cant FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'"';
	$db->setQuery($query);
	$cant_cuentas = $db->loadResult();
	
	if($cant_comprobantes == 0 && $cant_cuentas == 0)
		$val = 1;
		else
		$val = 0;
	
	return $val;
	}

function cuentas_principales(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "0"';
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;
	}
function cuentas_lista($id, $indent, $id_html){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "'.$id.'" ORDER BY codigo'; 
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();  
	$layout = JRequest::getVar('layout', '', 'get');
	if($layout == 'edita' || $layout == 'nuevo')
		$link = 'onclick="asigna(\'{cuenta_nombre}\', \'{cuenta_id}\')"';
		else
		$link = 'href="index.php?option=com_erp&view=contacuentas&layout=edita&id={cuenta_id}"';
	foreach($cuentas as $cuenta) {
		$link = str_replace('{cuenta_id}', $cuenta->id, $link);
		$link = str_replace('{cuenta_nombre}', $cuenta->nombre, $link);
		$GLOBALS['n']++;
		if($cuenta->imputable == 1 || JRequest::getVar('layout', '', 'get') == 'listacuentas'){
			echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
									<td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i><a style="cursor:pointer" onclick="envia(\''.$cuenta->id.'\', \''.$cuenta->nombre.'\', \''.$cuenta->codigo.'\', \''.$id_html.'\')"> '.$cuenta->nombre.'</a></td>
                                  </tr>';
			}else{
			if(JRequest::getVar('tipo', 0, 'get') == 1){
				echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
									<td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i><a style="cursor:pointer" onclick="envia(\''.$cuenta->id.'\', \''.$cuenta->nombre.'\', \''.$cuenta->codigo.'\', \''.$id_html.'\')"> '.$cuenta->nombre.'</a></td>
                                  </tr>';
				}else{
				echo '                                  <tr>
                                    <td>'.$GLOBALS['n'].'</td>
									<td>'.$cuenta->codigo.'</td>
                                    <td><i style="margin-left:'.($indent*20).'px" class="icon-resize-horizontal"></i> '.$cuenta->nombre.'</td>
                                  </tr>';
				}
			}
		
		if(hasChild($cuenta->id))
			cuentas_lista($cuenta->id, ($indent+1), $id_html);
		}
	}
function cuenta_elimina(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
	
	if(verifyCuentaContable($id) == 1){
		$query = 'DELETE FROM #__erp_conta_cuentas WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		$val = 1;
		}else
		$val = 0;
	return $val;
	}
function cuenta_nueva(){
	$db =& JFactory::getDBO();
	$nombre   = JRequest::getVar('nombre', '', 'post');
	$id_padre = JRequest::getVar('id_padre', '0', 'post');
	$codigo_padre = JRequest::getVar('codigopadre', '', 'post');
	$codigo_hijo = JRequest::getVar('codigo', '', 'post');
	$nivel 	= nivel() + 1;
	//$codigo	= codigo();
	$codigo = $codigo_padre.$codigo_hijo;
	
	$query = 'SELECT id FROM #__erp_conta_cuentas WHERE codigo = "'.$codigo.'"';
	$db->setQuery($query);
	$id_codigo = $db->loadResult();
	
	if($id_codigo == ''){
		$query = 'INSERT INTO #__erp_conta_cuentas(`id_padre`, `codigo`, `nombre`, `nivel`) VALUES('; 
		$query.= '"'.$id_padre.'"';
		$query.= ', "'.$codigo.'"';
		$query.= ', "'.$nombre.'"';
		$query.= ', "'.$nivel.'")';
		$db->setQuery($query);  
		$db->query();
		$val = 1;
		}else
		$val = 0;
	return $val;
    newAccion('Creó nueva cuenta contable '.$nombre.', Codigo'.$codigo_hijo);
	}
function cuenta_edita(){
	$db =& JFactory::getDBO();
	$id		  = JRequest::getVar('id', '', 'get');
	$nombre   = JRequest::getVar('nombre', '', 'post');
	$id_padre = JRequest::getVar('id_padre', '0', 'post');
	$codigo_padre = JRequest::getVar('codigopadre', '', 'post');
	$codigo_hijo = JRequest::getVar('codigo', '', 'post');
	$codigo = $codigo_padre.$codigo_hijo;
	//echo JRequest::getVar('codigopadre', '', 'post').'-'.$codigo_padre.'-'.$codigo;
	
	$cuenta = cuenta();
	$codigo_antiguo = $cuenta->codigo;
	
	$query = 'SELECT id FROM #__erp_conta_cuentas WHERE codigo = "'.$codigo.'" AND id != "'.$id.'"';
	$db->setQuery($query);
	$id_codigo = $db->loadResult();
	
	//echo $cuenta->id_padre.'-'.$id_padre;
	
	if($id_codigo == ''){
		if($cuenta->id_padre != $id_padre){
			
			$nivel 	= nivel() + 1;
			//$codigo	= codigo();
			$query = 'UPDATE #__erp_conta_cuentas SET '; 
			$query.= '`id_padre` = "'.$id_padre.'"';
			$query.= ', `codigo` = "'.$codigo.'"';
			$query.= ', `nombre` = "'.$nombre.'"';
			$query.= ', `nivel` = "'.$nivel.'"';
			$query.= ' WHERE id = "'.$id.'"';
			$db->setQuery($query);  
			$db->query();
			
			$query = 'SELECT * FROM #__erp_conta_cuentas WHERE codigo LIKE "'.$codigo_antiguo.'%"';
			$db->setQuery($query);
			$ctas = $db->loadObjectList();
			$lencta = strlen($codigo_antiguo);
			foreach($ctas as $cta){
				$cod_nuevo = substr($cta->codigo, $lencta);
				$cod_nuevo = $codigo.$cod_nuevo;
				$nivel = $cta->nivel - 1;
				$query = 'UPDATE #__erp_conta_cuentas SET codigo = "'.$cod_nuevo.'", nivel = "'.$nivel.'" WHERE id = "'.$cta->id.'"';
				$db->setQuery($query);  
				$db->query();
				}
			
			}else{
			$query = 'UPDATE #__erp_conta_cuentas SET `nombre` = "'.$nombre.'", `codigo` = "'.$codigo.'" WHERE id = "'.$id.'"';
			$db->setQuery($query);  
			$db->query();
			}
			
		$val = 1;	
		}else
		$val = 0;
	newAccion('Editó cuenta contable '.$nombre.', Codigo'.$codigo);
	return $val;
	}
/*function cuenta_edita(){
	$nombre   = JRequest::getVar('nombre', '', 'post');
	$id_padre = JRequest::getVar('id_padre', '0', 'post');
	$nivel 	= nivel() + 1;
	$codigo	= codigo();
	imputable();
	
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_conta_cuentas SET '; 
	$query.= '`id_padre` = "'.$id_padre.'"';
	$query.= ', `codigo` = "'.$codigo.'"';
	$query.= ', `nombre` = "'.$nombre.'"';
	$query.= ', `nivel` = "'.$nivel.'"';
	$query.= ', `imputable` = "1"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}*/
	
function codigo(){
	$id_padre = JRequest::getVar('id_padre', '0', 'post');
	
	$db =& JFactory::getDBO();
	$query = 'SELECT codigo FROM #__erp_conta_cuentas WHERE id = "'.$id_padre.'"';
	$db->setQuery($query);
	$codigo_padre = $db->loadResult();
	if($codigo_padre == '')
		$codigo_padre = 0;
	
	$query = 'SELECT MAX(codigo) FROM #__erp_conta_cuentas WHERE id_padre = "'.$id_padre.'" LIMIT 1';
	$db->setQuery($query);
	$u = $db->loadResult();
	$ultimo = $u == '' ? 0 : $u;
	
	$nivel = nivel();
	if($nivel >= 3){
		$primero = '';
		for($i = 0; $i <= ($nivel-3); $i++){
			$primero.= '0';
			}
		$primero.= '1';
		}
		else{
		$primero = '1';
		}
	$codigo = $ultimo == 0 ? $codigo_padre.$primero : ($ultimo +1);
	return $codigo;
	}
function nivel(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT nivel FROM #__erp_conta_cuentas WHERE id = "'.JRequest::getVar('id_padre', '0', 'post').'"';
	$db->setQuery($query);  
	$nivel = $db->loadResult() == '' ? 0 : $db->loadResult();
	return $nivel; 
	}
function imputable(){
	$db =& JFactory::getDBO();  
	$query = 'UPDATE #__erp_conta_cuentas SET imputable = 0 WHERE id = '.JRequest::getVar('id_padre', '0', 'post');
	$db->setQuery($query);  
	$db->query(); 
	}
	
function tipodecambio(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT COUNT(id) FROM #__erp_conta_cambio WHERE 1';
	$db->setQuery($query);  
	$cambio = $db->loadResult() == '' ? 0 : $db->loadResult();
	return $cambio;
	}
function monedas(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_conta_moneda';  
	$db->setQuery($query);  
	$monedas = $db->loadObjectList(); 
	return $monedas;
	}
function guarda_cambio(){
	$db =& JFactory::getDBO();
	foreach(monedas() as $m){
		$query = 'INSERT INTO #__erp_conta_cambio(id_moneda, fecha, cambio) VALUES(';
		$query.= '"'.$m->id.'"';
		$query.= ', NOW()';
		$query.= ', "'.JRequest::getVar('moneda_'.$m->id, '0', 'post').'")';
		$db->setQuery($query);  
		$db->query(); 
		}
    newAccion('generó tipo de cambio');
	}
function cambio(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT cambio FROM #__erp_conta_cambio WHERE id_moneda = 1 ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$cambio = $db->loadResult();  
	return $cambio;  
	}

function getCompTotal($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT SUM(haber) AS haber, SUM(debe) AS debe FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id.'"';
	$db->setQuery($query);  
	$total = $db->loadObject();
	return $total;
	}
function getComprobante($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.*, t.tipo 
	FROM #__erp_conta_comprobante AS c 
	LEFT JOIN #__erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id 
	WHERE c.id = "'.$id.'"';
	$db->setQuery($query);  
	$comprobante = $db->loadObject();
	return $comprobante;
	}

function comprobante_guarda($rev = 0){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	$query = 'SELECT ivac.*, c.codigo, c.nombre 
	FROM #__erp_conta_lcv AS ivac 
	LEFT JOIN #__erp_conta_cuentas AS c ON ivac.id_impuesto = c.id 
	WHERE ivac.id = "1"';
	$db->setQuery($query);  
	$iva_credito = $db->loadObject();
	
	$query = 'SELECT ivav.*, c.codigo, c.nombre 
	FROM #__erp_conta_lcv AS ivav 
	LEFT JOIN #__erp_conta_cuentas AS c ON ivav.id_impuesto = c.id 
	WHERE ivav.id = "2"';
	$db->setQuery($query);  
	$iva_debito = $db->loadObject();
	
	$query = 'SELECT numero FROM #__erp_conta_comprobante ORDER BY numero DESC LIMIT 1';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	
	$id_origen	= JRequest::getVar('id', '0', 'get');
	$id_gestion	= JRequest::getVar('id_gestion', '0', 'post');
	$fecha   	= JRequest::getVar('fecha', '0000-00-00', 'post');
	$detalle 	= filtroCadena(JRequest::getVar('detalle', '', 'post'));
	$cambio  	= JRequest::getVar('cambio', '0.00', 'post');
	$tipo    	= JRequest::getVar('tipo', '', 'post');
	$cliente	= filtroCadena(JRequest::getVar('cliente_nombre', '', 'post'));
	$id_cliente	= JRequest::getVar('id_cliente', '0', 'post');
	
	/*$query = 'SELECT fec_creacion FROM #__erp_conta_comprobante ORDER BY fec_creacion DESC LIMIT 1';
	$db->setQuery($query);  
	$ultima_fecha = $db->loadResult();
	
	if($fecha >= $ultima_fecha){*/
		$query = 'INSERT INTO #__erp_conta_comprobante(id_tipo, id_gestion, numero, id_usuario, id_extcliente, id_origen, cliente, detalle, fec_creacion, tipo_cambio, revertido) VALUES(';
		$query.= '"'.$tipo.'"';
		$query.= ', "'.$id_gestion.'"';
		$query.= ', "'.($numero+1).'"';
		$query.= ', "'.$user->get('id').'"';
		$query.= ', "'.$id_cliente.'"';
		$query.= ', "'.$id_origen.'"';
		$query.= ', "'.$cliente.'"';
		$query.= ', "'.$detalle.'"';
		$query.= ', "'.$fecha.'"';
		$query.= ', "'.$cambio.'"';
		$query.= ', "'.$rev.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		if($rev == 1){
			$query = 'UPDATE #__erp_conta_comprobante SET revertido = "1" WHERE id = "'.$id_origen.'"';
			$db->setQuery($query);  
			$db->query();
			}
		
		$query = 'SELECT id FROM #__erp_conta_comprobante ORDER BY id DESC LIMIT 1';
		$db->setQuery($query);  
		$id_comprobante = $db->loadResult();
		
		$credito = 0;
		$debito = 0;
		$ultimo = 0;
		
		for($i=0; $i<count($_POST['id']); $i++){
			if($_POST['codigo'][$i] != ''){
				
				  // Verifica si el detalle esta relacionado a alguna factura
			      $id_compra = 0;
				  $id_venta = 0;
				  if($_POST['origen'][$i] == 1)
					  $id_venta = $_POST['id_factura'][$i];
				  if($_POST['origen'][$i] == 2)
					  $id_compra = $_POST['id_factura'][$i];
				  
				  //echo $_POST['codigo'][$i].' - '.$iva_debito->codigo.'<br>';
				  if($_POST['codigo'][$i] == $iva_credito->codigo || $_POST['codigo'][$i] == $iva_debito->codigo){
					  // Suma los montos de debido y haber del impuesto IVA
					  if($_POST['codigo'][$i] == $iva_credito->codigo)
						  $credito+= $_POST['debe'][$i];
					  if($_POST['codigo'][$i] == $iva_debito->codigo)
						  $debito+= $_POST['haber'][$i];
						
					  }else{
					  // Guarda el detalle en caso de que no sea un monto para impuestos
					  
					  if($_POST['haber'][$i] != 0)
					  	$ultimo++;
					  
					  if($ultimo == 1 && $credito > 0){
						  $query = 'INSERT INTO #__erp_conta_comprobante_detalle(`id_comprobante`, `id_cuenta`, `codigo`, `id_compra`, `id_venta`, `factura`, `concepto`, `debe`, `haber`) VALUES(';
						  $query.= '"'.$id_comprobante.'"';
						  $query.= ', "'.$iva_credito->id_impuesto.'"';
						  $query.= ', "'.$iva_credito->codigo.'"';
						  $query.= ', "0"';
						  $query.= ', "0"';
						  $query.= ', ""';
						  $query.= ', "'.filtroCadena($iva_credito->nombre).'"';
						  $query.= ', "'.$credito.'"';
						  $query.= ', "0"';
						  $query.= ')';
						  $db->setQuery($query);  
						  $db->query();
						  }
					  
					  $query = 'INSERT INTO #__erp_conta_comprobante_detalle(`id_comprobante`, `id_cuenta`, `codigo`, `id_compra`, `id_venta`, `factura`, `concepto`, `debe`, `haber`) VALUES(';
					  $query.= '"'.$id_comprobante.'"';
					  $query.= ', "'.$_POST['id'][$i].'"';
					  $query.= ', "'.$_POST['codigo'][$i].'"';
					  $query.= ', "'.$id_compra.'"';
					  $query.= ', "'.$id_venta.'"';
					  $query.= ', "'.filtroCadena($_POST['cliente'][$i]).'"';
					  $query.= ', "'.filtroCadena($_POST['descripcion'][$i]).'"';
					  $query.= ', "'.$_POST['debe'][$i].'"';
					  $query.= ', "'.$_POST['haber'][$i].'"';
					  $query.= ')';
					  $db->setQuery($query);  
					  $db->query();	  
					  }
				
				}
			
		  }	
		if($debito > 0){
				$query = 'INSERT INTO #__erp_conta_comprobante_detalle(`id_comprobante`, `id_cuenta`, `codigo`, `id_compra`, `id_venta`, `factura`, `concepto`, `debe`, `haber`) VALUES(';
				$query.= '"'.$id_comprobante.'"';
				$query.= ', "'.$iva_debito->id_impuesto.'"';
				$query.= ', "'.$iva_debito->codigo.'"';
				$query.= ', "0"';
				$query.= ', "0"';
				$query.= ', ""';
				$query.= ', "'.filtroCadena($iva_debito->nombre).'"';
				$query.= ', "0"';
				$query.= ', "'.$debito.'"';
				$query.= ')';
				$db->setQuery($query);  
				$db->query();	
				} 
		$val = 1;
		/*}else
		$val = $ultima_fecha;*/
    newAccion('Generó Comprobante ');
	return $id_comprobante.';'.$val;
	}
function comprobante_edita(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	$id_origen	= JRequest::getVar('id', '0', 'get');
	$fecha   	= JRequest::getVar('fecha', '0000-00-00', 'post');
	$detalle 	= filtroCadena(JRequest::getVar('detalle', '', 'post'));
	$cambio  	= JRequest::getVar('cambio', '0.00', 'post');
	$tipo    	= JRequest::getVar('tipo', '', 'post');
	$cliente	= filtroCadena(JRequest::getVar('cliente_nombre', '', 'post'));
	$id_cliente	= JRequest::getVar('id_cliente', '0', 'post');
	$id_comprobante = JRequest::getVar('id', '0', 'get');
	
	$query = 'UPDATE #__erp_conta_comprobante SET ';
	$query.= 'id_tipo = "'.$tipo.'"';
	$query.= ', id_extcliente = "'.$id_cliente.'"';
	$query.= ', id_origen = "'.$id_origen.'"';
	$query.= ', cliente = "'.$cliente.'"';
	$query.= ', fec_creacion = "'.$fecha.'"';
	$query.= ', detalle = "'.$detalle.'"';
	$query.= ' WHERE id = "'.$id_comprobante.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'DELETE FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id_comprobante.'"';
	$db->setQuery($query);  
	$db->query();
	
	for($i=0; $i<count($_POST['id']); $i++){
	  $id_compra = 0;
	  $id_venta = 0;
	  if($_POST['origen'][$i] == 1)
		  $id_venta = $_POST['id_factura'][$i];
		  
	  if($_POST['origen'][$i] == 2)
		  $id_compra = $_POST['id_factura'][$i];
		
	  $query = 'INSERT INTO #__erp_conta_comprobante_detalle(`id_comprobante`, `id_cuenta`, `codigo`, `id_compra`, `id_venta`, `factura`, `concepto`, `debe`, `haber`) VALUES(';
	  $query.= '"'.$id_comprobante.'"';
	  $query.= ', "'.$_POST['id'][$i].'"';
	  $query.= ', "'.$_POST['codigo'][$i].'"';
	  $query.= ', "'.$id_compra.'"';
	  $query.= ', "'.$id_venta.'"';
	  $query.= ', "'.filtroCadena($_POST['cliente'][$i]).'"';
	  $query.= ', "'.filtroCadena($_POST['descripcion'][$i]).'"';
	  $query.= ', "'.$_POST['debe'][$i].'"';
	  $query.= ', "'.$_POST['haber'][$i].'"';
	  $query.= ')';
	  $db->setQuery($query);  
	  $db->query();
	  }	
		
	}

function comprobante_elimina(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '0', 'get');
	$query = 'DELETE FROM #__erp_conta_comprobante WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'DELETE FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	}
	
function getRevertido($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT id FROM #__erp_conta_comprobante WHERE id_origen = "'.$id.'"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	return $id;
	}
	
function clientes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes ORDER BY id';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}

// Comprobantes
function getComprobantes(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('layout', '', 'get') == 'imprime_librodiario'){
		$id_gestion = JRequest::getVar('id_gestion', '', 'get');
		$id_cuenta = JRequest::getVar('id_cuenta', '', 'get');
		$fecha_inicio = JRequest::getVar('fi', '', 'get');
		$fecha_fin = JRequest::getVar('ff', '', 'get');
		$mes = JRequest::getVar('mes', '', 'get');
		$rango = JRequest::getVar('r', 0, 'get');
		$nro_comp_inicio = JRequest::getVar('nro_comp_inicio', '', 'get');
		$nro_comp_fin = JRequest::getVar('nro_comp_fin', '', 'get');
        $tipo = JRequest::getVar('tipo', '', 'get');
		}else{
		$id_gestion = JRequest::getVar('id_gestion', '', 'post');
		$id_cuenta = JRequest::getVar('id_cuenta', '', 'post');
		$fecha_inicio = JRequest::getVar('fecha_ini', '', 'post');
		$fecha_fin = JRequest::getVar('fecha_fin', '', 'post');
		$mes = JRequest::getVar('mes', '', 'post');
		$rango = JRequest::getVar('rango', 0, 'post');
		$nro_comp_inicio = JRequest::getVar('nro_comp_inicio', '', 'post');
		$nro_comp_fin = JRequest::getVar('nro_comp_fin', '', 'post');
        $tipo = JRequest::getVar('tipo', '', 'post');
		}
	
	$where_fecha = '';
	$where = '';
	
	if($rango == 0){
		$where_fecha = ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';
		}else{
		if($fecha_inicio != '')
			$where_fecha.= ' AND c.fec_creacion >= "'.$fecha_inicio.'"';
		if($fecha_fin != '')
			$where_fecha.= ' AND c.fec_creacion <= "'.$fecha_fin.'"';
		}
	
	if($id_cuenta != ''){
		$join = ' LEFT JOIN #__erp_conta_comprobante_detalle AS cd ON c.id = cd.id_comprobante ';
		$where.= ' AND cd.id_cuenta = "'.$id_cuenta.'"';
		$group = ' GROUP BY c.id';
		}
		
	if($nro_comp_inicio != ''){
		$where.= ' AND c.numero >= "'.$nro_comp_inicio.'"';
		}
	if($nro_comp_fin != ''){
		$where.= ' AND c.numero <= "'.$nro_comp_fin.'"';
		}
    if($tipo != ''){
		$where.= ' AND c.id_tipo = "'.$tipo.'"';
		}
	
	$query = 'SELECT c.*, t.tipo 
	FROM #__erp_conta_comprobante AS c 
	LEFT JOIN #__erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id 
	'.$join.'
	WHERE c.revertido != "1" '.$where_fecha.'
	'.$where.$group.'
	ORDER BY c.numero ASC';
    //echo $query;
	$db->setQuery($query);  
	$comprobantes = $db->loadObjectList();
	return $comprobantes;
	}
function getComprobantesDetalle($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id.'" ORDER BY id ASC';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
function comprobantes(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$pag = JRequest::getVar('p', '1', 'get');
	
	$where = '';
	if($session->get('filtro') != '')
		$where.= ' AND (c.detalle LIKE "%'.$session->get('filtro').'%" OR c.cliente LIKE "%'.$session->get('filtro').'%" OR c.numero = "'.$session->get('filtro').'")';
	if($session->get('fecha_ini') != '' || $session->get('fecha_fin') != ''){
		if($session->get('fecha_ini') != '' && $session->get('fecha_fin') != '')
			$where.= ' AND c.fec_creacion >= "'.$session->get('fecha_ini').'" AND c.fec_creacion <= "'.$session->get('fecha_fin').'"';
		elseif($session->get('fecha_ini') != '')
			$where.= ' AND c.fec_creacion >= "'.$session->get('fecha_ini').'"';
		else
			$where.= ' AND c.fec_creacion <= "'.$session->get('fecha_fin').'"';
		}
	if($session->get('tipo') != '')
		$where.= ' AND c.id_tipo = "'.$session->get('tipo').'"';
	
	$cant= 10;
    $page = $pag - 1;
	$limit = ' LIMIT '.(($page) * $cant).','.$cant;
	$query = 'SELECT c.*, t.tipo 
	FROM #__erp_conta_comprobante AS c 
	LEFT JOIN #__erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id 
	WHERE 1'.$where.' 
	ORDER BY c.numero DESC'.$limit;
    //echo $query;
	$db->setQuery($query);  
	$comprobantes = $db->loadObjectList();
	return $comprobantes;
	}
function pageComprobantes(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	$cant= 10;
	
	if($session->get('filtro') != '')
		$where = ' AND (c.detalle LIKE "%'.$session->get('filtro').'%" OR c.cliente LIKE "%'.$session->get('filtro').'%")';
	if($session->get('fecha_ini') != '' || $session->get('fecha_fin') != ''){
		if($session->get('fecha_ini') != '' && $session->get('fecha_fin') != '')
			$where = ' AND c.fec_creacion >= "'.$session->get('fecha_ini').'" AND c.fec_creacion <= "'.$session->get('fecha_fin').'"';
		elseif($session->get('fecha_ini') != '')
			$where = ' AND c.fec_creacion >= "'.$session->get('fecha_ini').'"';
		else
			$where = ' AND c.fec_creacion <= "'.$session->get('fecha_fin').'"';
		}
	if($session->get('tipo') != '')
		$where = ' AND c.id_tipo = "'.$session->get('tipo').'"';
	
	$query = 'SELECT COUNT(c.id) 
	FROM #__erp_conta_comprobante AS c 
	LEFT JOIN #__erp_conta_comprobante_tipo AS t ON c.id_tipo = t.id
	WHERE 1'.$where;
	$db->setQuery($query);  
	$comprobantes = $db->loadResult();
	
	$paginas = $comprobantes / $cant;
	if(($comprobantes % $cant) != 0)
		$paginas = ceil($paginas);
	return $paginas;
	}

function getComprobanteDetalle($id = 0){
	$db =& JFactory::getDBO();
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT * FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id.'" ORDER BY id';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
function getComprobanteDetallePrint($id = 0){
	$db =& JFactory::getDBO();
    $p  = JRequest::getVar('p', '1', 'get');
   $cant= 8;
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT * FROM #__erp_conta_comprobante_detalle WHERE id_comprobante = "'.$id.'" ORDER BY id';
    $query.= ' LIMIT '.(($p-1) * 8).',8';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
// cambio
function getTipoCambio(){
	$db =& JFactory::getDBO();
	$query = 'SELECT c.*, m.moneda, m.simbolo 
	FROM #__erp_conta_cambio AS c 
	LEFT JOIN #__erp_conta_moneda AS m ON c.id_moneda = m.id 
	WHERE m.id = "'.JRequest::getVar('id', '', 'get').'"
	ORDER BY c.fecha DESC';
	$db->setQuery($query);  
	$cambios = $db->loadObjectList();
	return $cambios;
	}

//
function getMoneda($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_moneda WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$moneda = $db->loadObject();
	return $moneda;
	}
function newTipoCambio(){
	$db =& JFactory::getDBO();
	$query = 'INSERT INTO #__erp_conta_cambio(`id_moneda`, `fecha`, `cambio`) VALUES(';
	$query.= '"'.JRequest::getVar('id', '', 'get').'"';
	$query.= ', NOW()';
	$query.= ', "'.JRequest::getVar('cambio', '', 'post').'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	}


// Tipos de comprobante
function getTipoComprobante($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT tipo FROM #__erp_conta_comprobante_tipo WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$tipo = $db->loadResult();
	return $tipo;
	}
function getTipoComp($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_comprobante_tipo WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$tipo = $db->loadObject();
	return $tipo;
	}
function getTipoComprobantes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_comprobante_tipo ORDER BY id';
	$db->setQuery($query);  
	$tipo = $db->loadObjectList();
	return $tipo;
	}

function newTipoComprobante(){
	$db =& JFactory::getDBO();
	$query = 'INSERT INTO #__erp_conta_comprobante_tipo(`tipo`) VALUES("'.JRequest::getVar('tipo', '', 'post').'")';
	$db->setQuery($query);  
	$db->query();
	}
function editTipoComprobante(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_conta_comprobante_tipo SET `tipo` = "'.JRequest::getVar('tipo', '', 'post').'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function deleteTipoComprobante(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_conta_comprobante_tipo WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}

// LCV
function getLCV($libro){
	$db =& JFactory::getDBO();
	$query = 'SELECT l.*, i.nombre AS i_nombre, i.codigo, c.nombre AS c_nombre, c.codigo AS c_codigo
	FROM #__erp_conta_lcv AS l 
	LEFT JOIN #__erp_conta_cuentas AS c ON l.id_relacion = c.id
	LEFT JOIN #__erp_conta_cuentas AS i ON l.id_impuesto = i.id
	WHERE l.libro = "'.$libro.'"';
	$db->setQuery($query);  
	$libro = $db->loadObject();
	return $libro;
	}
function editLCV(){
	$db =& JFactory::getDBO();
	
	$query = 'UPDATE #__erp_conta_lcv SET id_relacion = "'.JRequest::getVar('lc', '', 'post').'", id_impuesto = "'.JRequest::getVar('idpadrenombre_0', '', 'post').'" WHERE libro = "lc"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'UPDATE #__erp_conta_lcv SET id_relacion = "'.JRequest::getVar('lv', '', 'post').'", id_impuesto = "'.JRequest::getVar('idpadrenombre_1', '', 'post').'" WHERE libro = "lv"';
	$db->setQuery($query);  
	$db->query();
	}
function getIdLCV($libro){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.codigo 
	FROM #__erp_conta_lcv AS lcv 
	LEFT JOIN #__erp_conta_cuentas AS c ON lcv.id_relacion = c.id 
	WHERE lcv.libro = "'.$libro.'"';
	$db->setQuery($query);
	$codigo = $db->loadResult();
	
	return $codigo;
	}
function getDatosLCV($libro){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.* 
	FROM #__erp_conta_lcv AS lcv 
	LEFT JOIN #__erp_conta_cuentas AS c ON lcv.id_impuesto = c.id 
	WHERE lcv.libro = "'.$libro.'"';
	$db->setQuery($query);
	$cuenta = $db->loadObject();
	
	return $cuenta;
	}

function ordenaComprobantes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_conta_comprobante WHERE 1 ORDER BY fec_creacion';
	$db->setQuery($query);
	$comp = $db->loadObjectList();
	
	$n = 1;
	foreach($comp as $c){
		$query = 'UPDATE #__erp_conta_comprobante SET numero = "'.$n.'" WHERE id = "'.$c->id.'"';
		$db->setQuery($query);  
		$db->query();
		$n++;
		}
	}

// Gestiones

function getCuentaActivos(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id_cuenta FROM #__erp_conta_afc WHERE 1';
	$db->setQuery($query);
	$id = $db->loadResult();
	
	return $id;
	}
function getCuentaActivosDep(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id_cuenta_dep FROM #__erp_conta_afc WHERE 1';
	$db->setQuery($query);
	$id = $db->loadResult();
	
	return $id;
	}

 // Gestions
function getGestionActiva(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT id FROM #__erp_conta_gestion WHERE id_empresa = "'.$session->get('ide').'" AND activa = "1"';
	$db->setQuery($query);
	$id = $db->loadResult();
	
	return $id;
	}
function getGestiones(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT * FROM #__erp_conta_gestion WHERE id_empresa = "'.$session->get('ide').'" ORDER BY gestion DESC';
	$db->setQuery($query);
	$gestiones = $db->loadObjectList();
	
	return $gestiones;
	} 
function getGestion($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_conta_gestion WHERE id = "'.$id.'"';
	
	$db->setQuery($query);
	$gestion = $db->loadObject();
	
	return $gestion;
	}
function newGestion(){
	$db =& JFactory::getDBO();
	$gestion = JRequest::getVar('gestion', '', 'post');
	
	$query = 'INSERT INTO #__erp_conta_gestion(gestion, id_empresa) VALUES("'.$gestion.'", 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);
	$id_gestion = $db->loadResult();
	
	$cta = getCNTcuentasMAIN();
	foreach($cta as $c){
		$query = 'INSERT INTO #__erp_conta_cuentas(`id_origen`, `id_padre`, `id_gestion`, `codigo`, `nombre`, `nivel`, `lft`, `rgt`, `sec`, `id_empresa`) VALUES(';
		$query.= '"'.$c->id.'"';
		$query.= ', IFNULL((SELECT cc.id FROM cgn_erp_conta_cuentas_main cm, cgn_erp_conta_cuentas cc WHERE cm.id = cc.id_origen AND cm.id = '.$c->id_padre.' and cc.id_gestion = '.$id_gestion.'), 0)';
		$query.= ', "'.$id_gestion.'"';
		$query.= ', "'.$c->codigo.'"';
		$query.= ', "'.$c->nombre.'"';
		$query.= ', "'.$c->nivel.'"';
		$query.= ', "'.$c->lft.'"';
		$query.= ', "'.$c->rgt.'"';
		$query.= ', "'.$c->sec.'"';
		$query.= ', "1"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
    newAccion('Creó Nueva gestión '.$gestion);
	}
function editGestion(){
	$db =& JFactory::getDBO();
	$gestion = JRequest::getVar('gestion', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_conta_gestion SET gestion = "'.$gestion.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó gestión '.$gestion);
	}
function changeGestionActiva(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
    
	$query = 'UPDATE #__erp_conta_gestion SET activa = "0"';
	$db->setQuery($query);  
	$db->query();
    
    $query = 'UPDATE #__erp_conta_gestion SET activa = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó Gestión: ');
}
function deleteGestion(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'DELETE FROM #__erp_conta_gestion WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Eliminó gestión ');
	}

// Gesitones
function getGestionAc(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT id FROM #__erp_conta_gestion WHERE id_empresa = "'.$session->get('ide').'" AND activa = "1"';
	
	$db->setQuery($query);
	$id = $db->loadResult();
	
	return $id;
	}

// Cuentas Contables
function getCNThaschild($id = 1){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT rgt, lft FROM #__erp_conta_cuentas WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$c = $db->loadObject();
	
	if(($c->rgt - $c->lft) == 1)
		$child = 1;
		else
		$child = 0;
		
	return $child;
	}
function getCNTcuentacod($id_parent = 0){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.codigo, cp.codigo AS cod_padre 
	FROM #__erp_conta_cuentas AS c
	LEFT JOIN #__erp_conta_cuentas AS cp ON c.id_padre = cp.id
	WHERE c.id_padre = "'.$id_parent.'" 
	ORDER BY c.codigo DESC 
	LIMIT 1';
	$db->setQuery($query);
	$codigo = $db->loadObject();
	
	$len = strlen($codigo->cod_padre);
	
	$cod = substr($codigo->codigo, $len);
	$cod++;
	
	if($cod == '')
		$cod = 1;
	
	return $cod;
	}
function getCNTcuenta($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT c.*, p.nombre AS p_nombre
	FROM #__erp_conta_cuentas AS c
	LEFT JOIN #__erp_conta_cuentas AS p ON c.id_padre = p.id 
	WHERE c.id = "'.$id.'"';
	$db->setQuery($query);
	$ctas = $db->loadObject();
    //echo $query;
	return $ctas;
	}
function getCNTcuentabyname($nombre){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id FROM #__erp_conta_cuentas_main WHERE nombre = "'.$nombre.'"';
	$db->setQuery($query);
	$cta = $db->loadResult();
	return $cta;
	}
function getCNTcuentabyorigen($id, $id_gestion){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id FROM #__erp_conta_cuentas WHERE id_origen = "'.$id.'" AND id_gestion = "'.$id_gestion.'"';
	$db->setQuery($query);
	$cta = $db->loadResult();
	return $cta;
	}
function getCNTcuentas($id_gestion = '', $id_padre = 0, $aux = 0){
	$db =& JFactory::getDBO();
	
	$aux = JRequest::getVar('aux', $aux, 'get');
	$wherepost = '';
	if($id_gestion == '')
		$id_gestion = getGestionAc();
	
	if($id_padre != 0)
		$where = 'parent.id = "'.$id_padre.'" AND ';
	
	if($aux == 0)
		$whereaux = ' AND node.codigo != "0"';
	
    $nombrecuenta = JRequest::getVar('cuenta','','post');
    if($nombrecuenta != ''){
        $wherepost .= ' AND parent.nombre LIKE "%'.$nombrecuenta.'%"';
    }
    $nrocuenta = JRequest::getVar('nro_cta','','post');
    if($nrocuenta != ''){
        $wherepost .= ' AND parent.codigo LIKE "'.$nrocuenta.'%"';
    }
	$query = 'SELECT node.*, parent.nombre AS nombre_padre, CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", node.nivel - 1), node.nombre) AS nombre_completo, (COUNT(parent.nombre) - 1) AS depth, parent.codigo AS codigo_padre
	FROM #__erp_conta_cuentas AS node, #__erp_conta_cuentas AS parent 
	WHERE '.$where.'node.id_gestion = "'.$id_gestion.'" AND parent.id_gestion = "'.$id_gestion.'" AND node.lft BETWEEN parent.lft AND parent.rgt '.$whereaux.$wherepost.'
	GROUP BY node.id
	ORDER BY node.lft';
    //echo $query;
	$db->setQuery($query);
	$ctas = $db->loadObjectList();
    
	return $ctas;
	}
function getCNTcuentaprincipal($t){
	$db =& JFactory::getDBO();
	
	$id_gestion = JRequest::getVar('id_gestion', getGestionActiva(), 'post');
	$id_unidadnegocio = JRequest::getVar('id_unidadnegocio', '', 'post');
	
	$where = '';
	if($id_unidadnegocio != ''){
		$where.= ' AND id_unidadnegocio = "'.$id_unidadnegocio.'"';
		}
	
	$query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_padre = "0" AND sec = "'.$t.'" AND id_gestion = "'.$id_gestion.'"'.$where;
    //echo $query;
	$db->setQuery($query);
	$ctas = $db->loadObjectList();
    
	return $ctas;
	}
function deleteCNTcuentagrupo(){
	$db =& JFactory::getDBO();
	
	$ids = JRequest::getVar('seleccion_cta', '', 'post');
	
	foreach($ids as $id)
		deleteCNTcuenta($id);
	}
function deleteCNTcuenta($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT lft, rgt, (rgt - lft + 1) AS width FROM #__erp_conta_cuentas WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$cta = $db->loadObject();
	
	$query = 'DELETE FROM #__erp_conta_cuentas WHERE id = "'.$id.'"';
	//$query = 'DELETE FROM #__erp_conta_cuentas WHERE lft BETWEEN "'.$cta->lft.'" AND "'.$cta->rgt.'"';
	//$query = 'UPDATE #__erp_conta_cuentas SET codigo = "" WHERE lft BETWEEN "'.$cta->lft.'" AND "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'UPDATE #__erp_conta_cuentas SET rgt = (rgt - '.$cta->width.') WHERE rgt > "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'UPDATE #__erp_conta_cuentas SET lft = (lft - '.$cta->width.') WHERE lft > "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
	}
function newCNTcuenta($aux = 0){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$nombre = JRequest::getVar('nombre', '', 'post');
	$id_padre = JRequest::getVar('id_padre', '', 'post');
	$id_gestion = JRequest::getVar('id_gestion', '', 'post');
	$codigo_padre = JRequest::getVar('codigopadre', '', 'post');
	$codigo_hijo = JRequest::getVar('codigo', '', 'post');
	$id_unidadnegocio = JRequest::getVar('id_unidadnegocio', '', 'post');
    $presupuesto = JRequest::getVar('presupuesto','0','post');
	$nivel 	= nivel() + 1;
	
	//$codigo	= codigo();
	$codigo = $codigo_padre.$codigo_hijo;
	
/*	if($id_padre != 0)
		imputable();*/
	
	$query = 'SELECT id FROM #__erp_conta_cuentas WHERE codigo = "'.$codigo.'"';
	$db->setQuery($query);
	$id_codigo = $db->loadResult();
	
	if($id_codigo == '' || $aux == 1){
		if($id_padre == ''){
			$query = 'SELECT MAX(rgt) FROM #__erp_conta_cuentas';
			$db->setQuery($query);
			$lft_rgt = $db->loadResult();
			}else{
			if(getCNThaschild($id_padre)){
				$query = 'SELECT lft FROM #__erp_conta_cuentas WHERE id = "'.$id_padre.'"';
				$db->setQuery($query);
				$lft_rgt = $db->loadResult();
				}else{
				$query = 'SELECT rgt FROM #__erp_conta_cuentas WHERE id = "'.$id_padre.'"';
				$db->setQuery($query);
				$lft_rgt = $db->loadResult() - 1;
				}	
			}
			
		$query = 'UPDATE #__erp_conta_cuentas SET rgt = rgt + 2 WHERE rgt > "'.$lft_rgt.'"';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'UPDATE #__erp_conta_cuentas SET lft = lft + 2 WHERE lft > "'.$lft_rgt.'"';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'INSERT INTO #__erp_conta_cuentas(`id_empresa`, `id_padre`, `id_gestion`, `id_unidadnegocio`, `codigo`, `nombre`, `nivel`, `lft`, `rgt`, `presupuesto`) VALUES(';
		$query.= '"'.$session->get('ide').'"';
		$query.= ', "'.$id_padre.'"';
		$query.= ', "'.$id_gestion.'"';
		$query.= ', "'.$id_unidadnegocio.'"';
		$query.= ', "'.$codigo.'"';
		$query.= ', "'.$nombre.'"';
		$query.= ', "'.$nivel.'"';
		$query.= ', ('.$lft_rgt.' + 1)';
		$query.= ', ('.$lft_rgt.' + 2)';
		$query.= ', "'.$presupuesto.'")';
		$db->setQuery($query);  
		$db->query();
		
		$val = 1;
		}else
		$val = 0;
	return $val;
    newAccion('Creó Nueva cuenta contable '.$codigo_hijo);
	}
function editCNTcuenta(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$id_unidadnegocio = JRequest::getVar('id_unidadnegocio', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_conta_cuentas WHERE nombre = "'.$nombre.'" AND id != "'.$id.'"';
	$db->setQuery($query);
	$num = $db->loadResult();
	
	if($num == 0){
		$query = 'UPDATE #__erp_conta_cuentas SET nombre = "'.$nombre.'", id_unidadnegocio = "'.$id_unidadnegocio.'" WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		$val = 1;
		}else
		$val = 0;
	return $val;
    newAccion('Editó cuenta contable '.$nombre);
	}
function codigoRename($cod){
	$len = strlen($cod);
	$max = 10;
	for($i=0; $i<($max-$len); $i++)
		$cod.= '0';
	return $cod;
	}

// Cuentas Contables Principal
function getCNThaschildMAIN($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT rgt, lft FROM #__erp_conta_cuentas_main WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$c = $db->loadObject();
	
	if(($c->rgt - $c->lft) == 1)
		$child = 0;
		else
		$child = 1;
		
	return $child;
	}
function getCNTcuentacodMAIN($id_parent = 0){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.codigo, cp.codigo AS cod_padre 
	FROM #__erp_conta_cuentas_main AS c
	LEFT JOIN #__erp_conta_cuentas_main AS cp ON c.id_padre = cp.id
	WHERE c.id_padre = "'.$id_parent.'" 
	ORDER BY c.codigo DESC 
	LIMIT 1';
	$db->setQuery($query);
	$codigo = $db->loadObject();
	
	$len = strlen($codigo->cod_padre);
	
	$cod = substr($codigo->codigo, $len);
	$cod++;
	
	if($cod == '')
		$cod = 1;
	
	return $cod;
	}
function getCNTcuentasMAIN(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT node.*, parent.nombre nombre_padre, CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", node.nivel - 1), node.nombre) AS nombre_completo, (COUNT(parent.nombre) - 1) AS depth 
	FROM #__erp_conta_cuentas_main AS node, #__erp_conta_cuentas_main AS parent 
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
	GROUP BY node.codigo 
	ORDER BY node.lft';
	
	$db->setQuery($query);
	$ctas = $db->loadObjectList();
	return $ctas;
	}
function getCNTcuentaMAIN(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT c.*, p.nombre AS p_nombre
	FROM #__erp_conta_cuentas_main AS c
	LEFT JOIN #__erp_conta_cuentas_main AS p ON c.id_padre = p.id 
	WHERE c.id = "'.$id.'"';
	
	$db->setQuery($query);
	$ctas = $db->loadObject();
	return $ctas;
	}

function deleteCNTcuentagrupoMAIN(){
	$db =& JFactory::getDBO();
	
	$ids = JRequest::getVar('seleccion_cta', '', 'post');
	
	foreach($ids as $id)
		deleteCNTcuentaMAIN($id);
	}
function deleteCNTcuentaMAIN($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT lft, rgt, (rgt - lft + 1) AS width FROM #__erp_conta_cuentas_main WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$cta = $db->loadObject();
	
	$query = 'DELETE FROM #__erp_conta_cuentas_main WHERE lft BETWEEN "'.$cta->lft.'" AND "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'UPDATE #__erp_conta_cuentas_main SET rgt = (rgt - '.$cta->width.') WHERE rgt > "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'UPDATE #__erp_conta_cuentas_main SET lft = (lft - '.$cta->width.') WHERE lft > "'.$cta->rgt.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró cuenta contable principal');
	}
function newCNTcuentaMAIN(){
	$db =& JFactory::getDBO();
	
	$nombre   = JRequest::getVar('nombre', '', 'post');
	$id_padre = JRequest::getVar('id_padre', '', 'post');
	$codigo_padre = JRequest::getVar('codigopadre', '', 'post');
	$codigo_hijo = JRequest::getVar('codigo', '', 'post');
	$nivel 	= nivel() + 1;
	
	//$codigo	= codigo();
	$codigo = $codigo_padre.$codigo_hijo;
	
/*	if($id_padre != 0)
		imputable();*/
	
	$query = 'SELECT id FROM #__erp_conta_cuentas_main WHERE codigo = "'.$codigo.'"';
	$db->setQuery($query);
	$id_codigo = $db->loadResult();
	
	if($id_codigo == ''){
		if($id_padre == ''){
			$query = 'SELECT MAX(rgt) FROM #__erp_conta_cuentas_main';
			$db->setQuery($query);
			$lft_rgt = $db->loadResult();
			}else{
			if(getCNThaschild($id_padre)){
				$query = 'SELECT lft FROM #__erp_conta_cuentas_main WHERE id = "'.$id_padre.'"';
				$db->setQuery($query);
				$lft_rgt = $db->loadResult();
				}else{
				$query = 'SELECT rgt FROM #__erp_conta_cuentas_main WHERE id = "'.$id_padre.'"';
				$db->setQuery($query);
				$lft_rgt = $db->loadResult() - 1;
				}	
			}
			
		$query = 'UPDATE #__erp_conta_cuentas_main SET rgt = rgt + 2 WHERE rgt > "'.$lft_rgt.'"';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'UPDATE #__erp_conta_cuentas_main SET lft = lft + 2 WHERE lft > "'.$lft_rgt.'"';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'INSERT INTO #__erp_conta_cuentas_main(`id_padre`, `codigo`, `nombre`, `nivel`, `lft`, `rgt`) VALUES(';
		$query.= '"'.$id_padre.'"';
		$query.= ', "'.$codigo.'"';
		$query.= ', "'.$nombre.'"';
		$query.= ', "'.$nivel.'"';
		$query.= ', ('.$lft_rgt.' + 1)';
		$query.= ', ('.$lft_rgt.' + 2))';
		$db->setQuery($query);  
		$db->query();
		
		$val = 1;
		}else
		$val = 0;
	return $val;
    newAccion('Creó cuenta contable principal');
	}
function editCNTcuentaMAIN(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_conta_cuentas_main WHERE nombre = "'.$nombre.'" AND id != "'.$id.'"';
	$db->setQuery($query);
	$num = $db->loadResult();
	
	if($num == 0){
		$query = 'UPDATE #__erp_conta_cuentas_main SET nombre = "'.$nombre.'" WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		$val = 1;
		}else
		$val = 0;
	return $val;
    newAccion('Editó cuenta contable principal');
	}
function hasChildMAIN($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id_padre) FROM #__erp_conta_cuentas_main WHERE id_padre = '.$id;
	$db->setQuery($query);  
	$padre = $db->loadResult();
	if($padre > 0)
		$child = true;
		else
		$child = false;
	return $child;
	}
function searchCNTcuenta(){
	$db =& JFactory::getDBO();
	
	$codigo = JRequest::getVar('codigo', '', 'post');
	$codigo = invertir((int)invertir($codigo));
	
	$cuenta = JRequest::getVar('cuenta', '', 'post');
	
	if($codigo != '')
		$where = 'c.codigo LIKE "'.$codigo.'%"';
		else
		$where = 'c.nombre LIKE "'.$cuenta.'%"';
	
	$query = 'SELECT c.*, p.codigo AS codigo_padre, p.nombre AS cuenta_padre 
	FROM #__erp_conta_cuentas AS c
	LEFT JOIN #__erp_conta_cuentas AS p ON c.id_padre = p.id
	WHERE '.$where;
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	
	return $cuentas;
	}
function searchCNTcuentaCodigo(){
	$db =& JFactory::getDBO();
    
	$codigo = JRequest::getVar('codigo', '', 'post');
	
    $query = 'SELECT nivel FROM #__erp_conta_cuentas WHERE codigo = "'.$codigo.'"';
    $db->setQuery($query);  
	$cuenta = $db->loadResult();
    
    if($cuenta != '4'){
	   $codigo = invertir((int)invertir($codigo));        
    }
	$query = 'SELECT c.*, p.codigo AS codigo_padre, p.nombre AS cuenta_padre 
	FROM #__erp_conta_cuentas AS c
	LEFT JOIN #__erp_conta_cuentas AS p ON c.id_padre = p.id
	WHERE c.codigo = "'.$codigo.'"';
    //echo $query;
	$db->setQuery($query);  
	$cuenta = $db->loadObject();

	if($cuenta->id != '')
		$cta = $cuenta->id.'|'.codigoRename($cuenta->codigo).'|'.$cuenta->nombre.'|'.JRequest::getVar('id', '0', 'post');
	
	return $cta;
	}

// Comprobantes
function getCNTultimafecha(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT fec_creacion FROM #__erp_conta_comprobante WHERE 1 ORDER BY fec_creacion DESC LIMIT 1';
	$db->setQuery($query);  
	$fecha = $db->loadResult();
	
	return $fecha;
	}
function newCNTComprobante($rev = 0){
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	$db =& JFactory::getDBO();
	
	$id_origen	= JRequest::getVar('id', '0', 'get');
	$id_gestion	= JRequest::getVar('id_gestion', '0', 'post');
	$concepto 	= filtroCadena(JRequest::getVar('concepto', '', 'post'));
	$glosa 		= filtroCadena(JRequest::getVar('glosa', '', 'post'));
	$cambio  	= JRequest::getVar('cambio', '0.00', 'post');
	$tipo    	= JRequest::getVar('tipo', '', 'post');
	$cliente	= filtroCadena(JRequest::getVar('cliente_nombre', '', 'post'));
	$id_cliente	= JRequest::getVar('id_cliente', '0', 'post');
	$fecha 		= fecha2(JRequest::getVar('fecha', date('Y-m-d'), 'post'));
	$mes		= explode('-', $fecha);
	$banco    	= JRequest::getVar('id_banco', '', 'post');
    $cheque    	= JRequest::getVar('cheque_nro', '', 'post');
    $factura    = JRequest::getVar('factura_nro', '', 'post');
	$query = 'SELECT numero FROM #__erp_conta_comprobante WHERE id_gestion = "'.$id_gestion.'" AND id_empresa = "'.$session->get('ide').'" AND fec_creacion LIKE "'.$mes['0'].'-'.$mes[1].'-%" ORDER BY numero DESC LIMIT 1';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	
	$query = 'INSERT INTO #__erp_conta_comprobante(id_tipo, id_empresa, id_gestion, numero, id_usuario, id_extcliente, id_origen, cliente, detalle, glosa, fec_creacion, fec_registro, tipo_cambio, revertido, id_banco, cheque_nro, factura_nro) VALUES(';
	$query.= '"'.$tipo.'"';
	$query.= ', "'.$session->get('ide').'"';
	$query.= ', "'.$id_gestion.'"';
	$query.= ', "'.($numero+1).'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.$id_cliente.'"';
	$query.= ', "'.$id_origen.'"';
	$query.= ', "'.$cliente.'"';
	$query.= ', "'.$concepto.'"';
	$query.= ', "'.$glosa.'"';
	$query.= ', "'.$fecha.'"';
	$query.= ', NOW()';
	$query.= ', "'.$cambio.'"';
	$query.= ', "'.$rev.'"';
    $query.= ', "'.$banco.'"';
    $query.= ', "'.$cheque.'"';
    $query.= ', "'.$factura.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	if($rev == 1){
		$query = 'UPDATE #__erp_conta_comprobante SET revertido = "1" WHERE id = "'.$id_origen.'"';
		$db->setQuery($query);  
		$db->query();
		}
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);  
	$id_comprobante = $db->loadResult();
	
	$credito = 0;
	$debito = 0;
	$ultimo = 0;
	
	$codigo = JRequest::getVar('codigo', '', 'post');
	$id_cta = JRequest::getVar('id_cta', '', 'post');
	$cuenta = JRequest::getVar('cuenta', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');
	$debe = JRequest::getVar('debe', '', 'post');
	$haber = JRequest::getVar('haber', '', 'post');
	$cant = count($codigo);
	
	for($i=0; $i<$cant; $i++){
		if($codigo[$i] != ''){
			
			$query = 'INSERT INTO #__erp_conta_comprobante_detalle(`id_comprobante`, `id_cuenta`, `codigo`, `cuenta`, `detalle`, `debe`, `haber`) VALUES(';
			$query.= '"'.$id_comprobante.'"';
			$query.= ', "'.$id_cta[$i].'"';
			$query.= ', "'.$codigo[$i].'"';
			$query.= ', "'.filtroCadena($cuenta[$i]).'"';
			$query.= ', "'.filtroCadena($detalle[$i]).'"';
			$query.= ', "'.$debe[$i].'"';
			$query.= ', "'.$haber[$i].'"';
			$query.= ')';
			$db->setQuery($query);  
			$db->query();
			}
		}
	
	$id_factura = JRequest::getVar('id_factura_agrupada', '', 'post');
	
	foreach($id_factura as $id){
		$query = 'UPDATE #__erp_facturacion_cabecera SET id_comprobante = "'.$id_comprobante.'" WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		}
	
	$id_compra = JRequest::getVar('id_compra', '', 'post');
	
	foreach($id_compra as $id){
		$query = 'UPDATE #__erp_facturacion_compras SET id_comprobante = "'.$id_comprobante.'" WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		}
	
	return $id_comprobante;
    newAccion('Creó Comprobante Contable '.$concepto);
	}

// Presupuestos
function getCtaMonto($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT monto FROM #__erp_presupuesto_ctamonto WHERE id_cuenta = "'.$id.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	
	return $monto;
	}

function saveCNTctapresupuesto(){
	$db =& JFactory::getDBO();
	
	$id_cta = JRequest::getVar('id_cuenta', '', 'post');
	
	$query = 'UPDATE #__erp_conta_cuentas_main SET presupuesto = "0" WHERE 1';
	$db->setQuery($query);  
	$db->query();
	
	foreach($id_cta as $id){
		
		$query = 'UPDATE #__erp_conta_cuentas_main SET presupuesto = "1" WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		}
    newAccion('Guardó Cuenta de Presupuesto');
	}
function checkCNTctapresupuesto($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT presupuesto FROM #__erp_conta_cuentas WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$pre = $db->loadResult();
	
	return $pre;
	}
function saveCNTpresupuesto(){
	$db =& JFactory::getDBO();
	
	$id_cta = JRequest::getVar('id_cta', '', 'post');
	$presupuesto = JRequest::getVar('presupuesto', '', 'post');
	
	for($i=0; $i<count($id_cta); $i++){
		$query = 'SELECT COUNT(id) FROM #__erp_presupuesto_ctamonto WHERE id_cuenta = "'.$id_cta[$i].'"';
		$db->setQuery($query);
		$cant = $db->loadResult();
		
		if($cant == 0)
			$query = 'INSERT INTO #__erp_presupuesto_ctamonto(`id_cuenta`, `monto`) VALUES("'.$id_cta[$i].'", "'.$presupuesto[$i].'")';
			else
			$query = 'UPDATE #__erp_presupuesto_ctamonto SET `monto` = "'.$presupuesto[$i].'" WHERE `id_cuenta` = "'.$id_cta[$i].'"'; 
			
		$db->setQuery($query);  
		$db->query();
		}
    newAccion('Asignó Presupuesto');
	}
function getCNTpresupuesto($id){
	$db =& JFactory::getDBO();
	
	$mes = JRequest::getVar('mes', '01', 'get');
	
	$query = 'SELECT monto FROM #__erp_presupuesto_ctamonto WHERE id_cuenta = "'.$id.'" AND mes = "'.$mes.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	
	return $monto;
	}
function executeCNTpresupuesto($codigo, $mes = ''){
	$db =& JFactory::getDBO();
	
	if($mes != ''){
		if(strlen($mes) == 1)
			$mes = '0'.$mes;
		$where = ' AND c.fec_creacion LIKE "%-'.$mes.'-%"';
		}
	
	$query = 'SELECT d.debe, d.haber
	FROM #__erp_conta_comprobante_detalle AS d
	JOIN #__erp_conta_comprobante AS c ON d.id_comprobante = c.id
	WHERE d.codigo LIKE "'.$codigo.'%"'.$where;
	$db->setQuery($query);
	$detalle = $db->loadObjectList();
	$total = 0;
	foreach($detalle as $det)
		$total+= $det->haber - $det->debe;
	
	return $total;
	}
	
	
// SOLICITUDES
function newCNTsolicitud(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_cuenta = JRequest::getVar('cuenta_debe_id', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');
	$monto = JRequest::getVar('monto', '', 'post');
	
	$ruta = 'media/com_erp/adjunto/';
	$adjunto = '';
	if($_FILES['archivo']['name'] != ''){
		$ext = explode('.',$_FILES['archivo']['name']);
		$adjunto = date('U').'.'.array_pop($ext);
		copy($_FILES['archivo']['tmp_name'], $ruta.$adjunto);
	}
	
	$query = 'INSERT INTO #__erp_presupuesto_solicitud(`id_usuario`, `id_cuenta`, `detalle`, `adjunto`, `monto`, `fecha`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_cuenta.'"';
	$query.= ', "'.$detalle.'"';
	$query.= ', "'.$adjunto.'"';
	$query.= ', "'.$monto.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Envió solicitud de Presupuesto ');
	}
function getCNTsolicitudes(){
	$db =& JFactory::getDBO();
	$desde = JRequest::getVar('desde','','post');
	$hasta = JRequest::getVar('hasta','','post');
    $where = '';
    if($desde!=''){
        $where .= ' AND s.fecha >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where .= ' AND s.fecha <= "'.fecha2($hasta).'"';
    }
	$query = 'SELECT s.*, c.nombre AS cuenta, c.codigo, u.name AS usuario  
	FROM #__erp_presupuesto_solicitud AS s
	LEFT JOIN #__erp_conta_cuentas AS c ON c.id = s.id_cuenta
	LEFT JOIN #__users AS u ON s.id_usuario = u.id
    WHERE 1 '.$where.'
	ORDER BY s.fecha';
	$db->setQuery($query);
	$solicitudes = $db->loadObjectList();
	
	return $solicitudes;
	}
function getCNTsolicitud($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT s.*, c.nombre AS cuenta, c.codigo, u.name AS usuario 
	FROM #__erp_presupuesto_solicitud AS s
	LEFT JOIN #__erp_conta_cuentas AS c ON c.id = s.id_cuenta
	LEFT JOIN #__users AS u ON s.id_usuario = u.id
	WHERE s.id = "'.$id.'"';
	$db->setQuery($query);
	$solicitud = $db->loadObject();
	
	return $solicitud;
	}
function cambiaCNTcuentapresupuesto($id, $estado){
	$db =& JFactory::getDBO();
	
	$query = 'UPDATE cgn_erp_conta_cuentas SET presupuesto = '.$estado.' WHERE id = '.$id;
	$db->setQuery($query);  
	$db->query();
    newAccion('Cambió Cuenta de Presupuesto ');
	}
function getCNTpresupuestocta($id, $mes, $id_gestion){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT IFNULL(monto, 0) FROM cgn_erp_presupuesto WHERE id_cta_contable = "'.$id.'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	//echo $query;
	if(empty($monto))
		$monto = 0;
	
	return $monto;
	}
function checkPresupuesto($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM cgn_erp_presupuesto WHERE id_cta_contable = "'.$id.'"';
	$db->setQuery($query);
	$cant = $db->loadResult();
	
	if($cant > 0)
		return true;
	else
		return false;
	}
function getCNTpresupuestoctaAnterior($id, $mes){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT gestion, codigo
	FROM cgn_erp_conta_cuentas c, cgn_erp_conta_gestion g
	WHERE c.id_gestion = g.id AND c.id = "'.$id.'"';
	$db->setQuery($query);
	$ga = $db->loadObject();
	
	$query = 'SELECT c.id
	FROM cgn_erp_conta_gestion g, cgn_erp_conta_cuentas c
	WHERE g.id = c.id_gestion AND g.gestion  = "'.($ga->gestion - 1).'" AND c.codigo = "'.$ga->codigo.'"';
	$db->setQuery($query);
	$id_cta = $db->loadResult();
	
	$query = 'SELECT monto FROM cgn_erp_presupuesto WHERE id_cta_contable = "'.$id_cta.'" AND mes = "'.$mes.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	
	if($monto == '')
		$monto = 0;
	
	return $monto;
	}
function getCNTpresupuestoctaAnteriorTotal($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT gestion, codigo
	FROM cgn_erp_conta_cuentas c, cgn_erp_conta_gestion g
	WHERE c.id_gestion = g.id AND c.id = "'.$id.'"';
	$db->setQuery($query);
	$ga = $db->loadObject();
	
	$query = 'SELECT c.id
	FROM cgn_erp_conta_gestion g, cgn_erp_conta_cuentas c
	WHERE g.id = c.id_gestion AND g.gestion  = "'.($ga->gestion - 1).'" AND c.codigo = "'.$ga->codigo.'"';
	$db->setQuery($query);
	$id_cta = $db->loadResult();
	
	$query = 'SELECT SUM(monto) FROM cgn_erp_presupuesto WHERE id_cta_contable = "'.$id_cta.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	
	if($monto == '')
		$monto = 0;
	
	return $monto;
	}
function newCNTpresupuesto(){
	$db =& JFactory::getDBO();
	
	$val = false;
	$id_gestion = JRequest::getVar('id_gestion', '', 'post');
	$id = JRequest::getVar('id_cta', '', 'post');
	$monto_1 = JRequest::getVar('mes_actual_1', '', 'post');
	$monto_2 = JRequest::getVar('mes_actual_2', '', 'post');
	$monto_3 = JRequest::getVar('mes_actual_3', '', 'post');
	$monto_4 = JRequest::getVar('mes_actual_4', '', 'post');
	$monto_5 = JRequest::getVar('mes_actual_5', '', 'post');
	$monto_6 = JRequest::getVar('mes_actual_6', '', 'post');
	$monto_7 = JRequest::getVar('mes_actual_7', '', 'post');
	$monto_8 = JRequest::getVar('mes_actual_8', '', 'post');
	$monto_9 = JRequest::getVar('mes_actual_9', '', 'post');
	$monto_10 = JRequest::getVar('mes_actual_10', '', 'post');
	$monto_11 = JRequest::getVar('mes_actual_11', '', 'post');
	$monto_12 = JRequest::getVar('mes_actual_12', '', 'post');
	
	if($id != ''){
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 1, '.$monto_1.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 2, '.$monto_2.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 3, '.$monto_3.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 4, '.$monto_4.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 5, '.$monto_5.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 6, '.$monto_6.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 7, '.$monto_7.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 8, '.$monto_8.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 9, '.$monto_9.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 10, '.$monto_10.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 11, '.$monto_11.')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO cgn_erp_presupuesto(id_empresa, id_gestion, id_cta_contable, mes, monto) VALUES(1, '.$id_gestion.', '.$id.', 12, '.$monto_12.')';
		$db->setQuery($query);
		$db->query();
		$val = true;
		}
	return $val;
    newAccion('Asignó  Presupuestos');
	}
function getCNTpresupuestoctaejecutado($id, $mes){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT monto FROM cgn_erp_presupuesto WHERE id_cta_contable = '.$id.' AND mes = '.$mes;
	$db->setQuery($query);
	$monto = $db->loadResult();
	
	return $monto;
	}
function getCNTcuentaspre($id_gestion = 0, $presupuesto = 0, $sinpag=1){
	$db =& JFactory::getDBO();
	
	$where = '';
	if($id_gestion > 0)
		$where.= ' AND id_gestion = '.$id_gestion;
	if($presupuesto == 1)
		$where.= ' AND presupuesto = 1';
    
    $cuenta = JRequest::getVar('cuenta','','post');    
    $codigo = JRequest::getVar('codigo','','post');    
    if($cuenta != ''){
        $where.= ' AND nombre LIKE "%'.$cuenta.'%"';
    }
    if($codigo != ''){
        $where.= ' AND codigo LIKE "'.$codigo.'%"';
    }
    $limit = '';
    if($sinpag==0){
        $cant= 20;
        $pag  = JRequest::getVar('p', '1', 'get');
        $page = $pag - 1;
        $limit = ' LIMIT '.(($page) * $cant).','.$cant;
    }
    
	$query = 'SELECT CONCAT( REPEAT("&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;", nivel - 1), nombre) AS nombre_completo, `id`, `id_empresa`, `id_origen`, `id_padre`, `id_gestion`, `id_unidadnegocio`, `codigo`, `nombre`, `nivel`, `rel`, `lft`, `rgt`, `sec`, `presupuesto`
	FROM cgn_erp_conta_cuentas
	WHERE (codigo LIKE "3%" OR codigo LIKE "4%")'.$where.'
	ORDER BY lft'.$limit;
	$db->setQuery($query);
	$ctas = $db->loadObjectList();
	return $ctas;
	}
function getCNTcuentasprePag($id_gestion = 0, $presupuesto = 0){
	$db =& JFactory::getDBO();
	
	$where = '';
	if($id_gestion > 0)
		$where.= ' AND id_gestion = '.$id_gestion;
	if($presupuesto == 1)
		$where.= ' AND presupuesto = 1';
    
    $cuenta = JRequest::getVar('cuenta','','post');    
    $codigo = JRequest::getVar('codigo','','post');    
    if($cuenta != ''){
        $where.= ' AND nombre LIKE "%'.$cuenta.'%"';
    }
    if($codigo != ''){
        $where.= ' AND codigo LIKE "'.$codigo.'%"';
    }
	$query = 'SELECT COUNT(*)
	FROM cgn_erp_conta_cuentas
	WHERE (codigo LIKE "3%" OR codigo LIKE "4%")'.$where.'
	ORDER BY lft';	
	$db->setQuery($query);
	$ctas = $db->loadResult();
	return $ctas;
	}
function getCNTcuentages($id_origen, $id_gestion){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT SUM(monto) AS suma
	FROM #__erp_presupuesto_ctamonto AS p
	LEFT JOIN #__erp_conta_cuentas AS c ON p.id_cuenta = c.id
	WHERE c.id_origen = "'.$id_origen.'" AND id_gestion = "'.$id_gestion.'"
	GROUP BY c.id_origen';
	$db->setQuery($query);
	$monto = $db->loadResult();
	return $monto;
	}
function getCNTgestionpre($ge = ''){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	if($ge != ''){
		$ges = $ge - 1;
		$where = 'AND gestion = "'.$ges.'"';
		}else
		$where = 'AND activa = "1"';
	
	$query = 'SELECT id, gestion FROM #__erp_conta_gestion WHERE id_empresa = "'.$session->get('ide').'" '.$where;
	$db->setQuery($query);
	$gestiones = $db->loadObject();
	return $gestiones;
	}
function getCNTcuentapre($id_gestion, $id_origen){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id FROM #__erp_conta_cuentas WHERE id_gestion = "'.$id_gestion.'" AND id_origen = "'.$id_origen.'"';
	$db->setQuery($query);
	$id = $db->loadResult();
	return $id;
	}
function getCNTcuentamonto($id, $mes){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT monto FROM #__erp_presupuesto_ctamonto WHERE id_cuenta = "'.$id.'" AND mes = "'.$mes.'"';
	$db->setQuery($query);
	$monto = $db->loadResult();
	return $monto;
	}



function getFacturaDetalleCuenta($id){
	$db =& JFactory::getDBO();
		
	$query = 'SELECT d.*, c.codigo, c.nombre AS cuenta, f.numero 
	FROM #__erp_facturacion_detalle AS d
	LEFT JOIN #__erp_facturacion_cabecera AS f ON d.id_factura = f.id
	LEFT JOIN #__erp_conta_cuentas AS c ON d.id_ctacontable = c.id
	WHERE d.id_factura = "'.$id.'"';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	
	$emp = getEmpresa();
	$imp = getLCV('lv');
	
	foreach($detalle as $d){
		$iva = round(($d->cantidad * $d->precio) * ($emp->impuesto/100), 2);
		$monto = ($d->cantidad * $d->precio) - $iva;
		
		$query = 'INSERT INTO #__erp_conta_comprobante_temp(id_cuenta, numero, codigo, cuenta, monto) VALUES(';
		$query.= '"'.$d->id_ctacontable.'"';
		$query.= ', "'.$d->numero.'"';
		$query.= ', "'.$d->codigo.'"';
		$query.= ', "'.$d->cuenta.'"';
		$query.= ', "'.$monto.'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		
		$query = 'INSERT INTO #__erp_conta_comprobante_temp(id_cuenta, numero, codigo, cuenta, monto) VALUES(';
		$query.= '"'.$imp->id_impuesto.'"';
		$query.= ', "'.$d->numero.'"';
		$query.= ', "'.$imp->codigo.'"';
		$query.= ', "'.$imp->i_nombre.'"';
		$query.= ', "'.$iva.'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
	}
function getTemporalFact(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id_cuenta, codigo, cuenta, SUM(monto) AS monto FROM #__erp_conta_comprobante_temp WHERE 1 GROUP BY id_cuenta';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
function createTemporalFact(){
	$db =& JFactory::getDBO();
	$query = 'CREATE TEMPORARY TABLE #__erp_conta_comprobante_temp
	(
    id int(11) NOT NULL auto_increment,
    id_cuenta int(11) NOT NULL,
	numero int(11),
    codigo bigint(20), 
    cuenta varchar(100),
    monto decimal(11,2),
    PRIMARY KEY  (`id`)
    );';
	$db->setQuery($query);  
	$db->query();
	}
function clearTemporalFact(){
	$db =& JFactory::getDBO();
	$query = 'TRUNCATE #__erp_conta_comprobante_temp';
	$db->setQuery($query);  
	$db->query();
	}

function getCNTReporteFacturas(){
	$db =& JFactory::getDBO();
	
	$fecha_ini = JRequest::getVar('fecha_ini', JRequest::getVar('ini','','get'), 'post');
	$fecha_fin = JRequest::getVar('fecha_fin', JRequest::getVar('fin','','get'), 'post');
	$id_cuenta = JRequest::getVar('id_cuenta', JRequest::getVar('cta','','get'), 'post');
	$id_cobrador = JRequest::getVar('id_cobrador', JRequest::getVar('cob','','get'), 'post');
	
	$where = '';
	if($fecha_ini)
		$where.= ' AND f.fecha >= "'.fecha2($fecha_ini).'"';
	if($fecha_fin)
		$where.= ' AND f.fecha <= "'.fecha2($fecha_fin).'"';
	if($id_cuenta)
		$where.= ' AND c.id = "'.$id_cuenta.'"';
	
	$query = 'SELECT f.fecha, f.numero, f.nit, f.nombre detalle, f.total monto, f.id_formapago, c.codigo cuenta, c.nombre concepto
	FROM cgn_erp_facturacion_cabecera f, cgn_erp_facturacion_detalle d, cgn_erp_conta_cuentas c, cgn_erp_clientes e, cgn_erp_clientes_info i
	WHERE f.id = d.id_factura AND c.id = d.id_ctacontable AND f.id_empresa = e.id AND e.id = i.id_cliente AND d.cuotas = 1 AND i.id_usuario_cobrador = "'.$id_cobrador.'"'.$where;
	
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
function getCNTReporteCobranzas(){
	$db =& JFactory::getDBO();
	
	$fi_f = JRequest::getVar('fi_f', JRequest::getVar('fi_f','','get'), 'post');
	$ff_f = JRequest::getVar('ff_f', JRequest::getVar('ff_f','','get'), 'post');
    
    $fi_p = JRequest::getVar('fi_p', JRequest::getVar('fi_p','','get'), 'post');
	$ff_p = JRequest::getVar('ff_p', JRequest::getVar('ff_p','','get'), 'post');
    
	$id_cuenta = JRequest::getVar('id_cuenta', JRequest::getVar('id_cuenta','','get'), 'post');
	$id_sucursal = JRequest::getVar('id_sucursal', JRequest::getVar('id_sucursal'), 'post');
	
	$where = '';
    $fecha = 'f.fecha';
	if($fi_f != ''){
		$where.= ' AND f.fecha >= "'.fecha2($fi_f).'"';
		$fecha = 'f.fecha AS fecha';
    }
    if($ff_f != ''){
		$where.= ' AND f.fecha <= "'.fecha2($ff_f).'"';
        $fecha = 'f.fecha AS fecha';
    }
    if($fi_p != ''){
		$where.= ' AND f.fecha_pago >= "'.fecha2($fi_p).'"';
        $fecha = 'f.fecha_pago AS fecha';
    }
    if($ff_p != ''){
		$where.= ' AND f.fecha_pago <= "'.fecha2($ff_p).'"';
        $fecha = 'f.fecha_pago AS fecha';
    }    
	if($id_cuenta != ''){
		$where.= ' AND c.id = "'.$id_cuenta.'"';        
    }
	
	$query = 'SELECT '.$fecha.', f.numero, f.nit, f.nombre detalle, f.total monto, f.id_formapago, c.codigo cuenta, c.nombre concepto
	FROM cgn_erp_facturacion_cabecera f, cgn_erp_facturacion_detalle d, cgn_erp_conta_cuentas c
	WHERE f.id = d.id_factura AND d.id_ctacontable= c.id AND f.id_sucursal = "'.$id_sucursal.'"'.$where. 'GROUP BY f.numero';
	//echo $query;
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}
function newPresupuesto($id_gestion){
    $db =& JFactory::getDBO();
    
    $id_cta = JRequest::getVar('id_cta', '', 'post');

    for($i=1; $i<=12; $i++){
        $query = 'SELECT COUNT(id) FROM #__erp_presupuesto WHERE id_cta_contable = "'.$id_cta.'" AND id_gestion = "'.$id_gestion.'" AND mes = "'.$i.'"';
        $db->setQuery($query);
        $cant = $db->loadResult();

        $monto = JRequest::getVar('mes_'.$i, '', 'post');

        if($cant == 0){
            $query = 'INSERT INTO #__erp_presupuesto(`id_cta_contable`, `monto`,`id_gestion`,`mes`) VALUES("'.$id_cta.'", "'.$monto.'", "'.$id_gestion.'", "'.$i.'")';
        }else{
            $query = 'UPDATE #__erp_presupuesto SET `monto` = "'.$monto.'" WHERE `id_cta_contable` = "'.$id_cta.'" AND mes = "'.$i.'" AND id_gestion = "'.$id_gestion.'"'; 
        }
        /*echo $query;
        echo '</br>';*/
        $db->setQuery($query);
        $db->query();
        newAccion('Asignó Presupuestos');
    }
}
function getPresupuesto(){
    $db =& JFactory::getDBO();

    $id_cta = JRequest::getVar('id_cta', '', 'post');

    $query = 'SELECT * FROM #__erp_presupuesto_ctamonto WHERE id_cuenta = "'.$id_cta.'"';
    $db->setQuery($query);
    $presupuesto = $db->loadObjectList();
    return $presupuesto;
}
function searchCtaPresupuesto($id){
    $db =& JFactory::getDBO();
    $codigo = JRequest::getVar('codigo','','post');
    $query = 'SELECT * FROM #__erp_conta_cuentas WHERE id_gestion = "'.$id.'" AND codigo LIKE "'.$codigo.'%" AND presupuesto = "1"';
    $db->setQuery($query);  
	$cuentas = $db->loadObjectList();
    return $cuentas;
}
function getMontoPresupuestoBloque($id_cuenta, $id_gestion, $mes){
    $db =& JFactory::getDBO();
    $query = 'SELECT monto FROM #__erp_presupuesto WHERE id_cta_contable = "'.$id_cuenta.'" AND id_gestion = "'.$id_gestion.'" AND mes = "'.$mes.'"';
    //echo $query;
    $db->setQuery($query);  
	$monto = $db->loadResult();
    if($monto!=''){
        $total_mes = $monto;
    }else{
        $total_mes = 0;
    }
    return $total_mes;
}
function newPresupuestoBloque($id_gestion){
    $db =& JFactory::getDBO();
    $numero = JRequest::getVar('numero','','post');
  
    for($i = 1; $i <= $numero; $i++){
        $cta = JRequest::getVar('idcta_'.$i,'','post');
        $query = 'SELECT COUNT(id) FROM #__erp_presupuesto WHERE id_cta_contable = "'.$cta.'" AND id_gestion= "'.$id_gestion.'"';
        $db->setQuery($query);
        $cant = $db->loadResult();
        if($cant==0){
            for($j = 1; $j <= 12; $j++){
                $monto = JRequest::getVar('mes_'.$j.'_'.$i,'','post');
                $query = 'INSERT INTO `#__erp_presupuesto`( `id_empresa`, `id_gestion`, `id_cta_contable`, `mes`, `monto`) VALUES (';
                $query.='"1"';
                $query.=', "'.$id_gestion.'"';
                $query.=', "'.$cta.'"';
                $query.=', "'.$j.'"';
                $query.=', "'.$monto.'"';
                $query.=')';
                $db->setQuery($query);
                $db->query();
            }
        }else{
            for($j = 1; $j <= 12; $j++){
                $monto = JRequest::getVar('mes_'.$j.'_'.$i,'','post');
                $query = 'UPDATE #__erp_presupuesto SET monto = "'.$monto.'" WHERE id_cta_contable = "'.$cta.'" AND id_gestion= "'.$id_gestion.'" AND mes ="'.$j.'"';
                $db->setQuery($query);
                $db->query();
            }
        }
    }
    newAccion('Asignó Presupuestos');
}
function getAreasPresupuesto(){
    $db =& JFactory::getDBO();
    $query = 'SELECT * FROM #__erp_presupuesto_areas WHERE estado = "1"';
    $db->setQuery($query);
    $cuentas = $db->loadObjectList();
    return $cuentas;
}
function getPreEjecuctado($id){
    $db =& JFactory::getDBO();
    $cta = JRequest::getVar('codigo','','post'); 
	$query = 'SELECT e.*, c.codigo, c.nombre, c.id
    FROM #__erp_presupuesto_ejecutado AS e
    LEFT JOIN #__erp_conta_cuentas AS c ON e.id_cta_contable = c.id
    WHERE c.id_gestion = "'.$id.'" AND c.codigo LIKE "'.$cta.'%" AND e.monto != "0"';
    //echo $query;
    $db->setQuery($query);
    $cuentas = $db->loadObjectList();
    return $cuentas;
}
function getPreExec($id_gestion, $id_cta){
    $db =& JFactory::getDBO();
	$query = 'SELECT e.monto
    FROM #__erp_presupuesto_ejecutado AS e
    LEFT JOIN #__erp_conta_cuentas AS c ON e.id_cta_contable = c.id
    WHERE c.id_gestion = "'.$id_gestion.'" AND  e.id_cta_contable = "'.$id_cta.'" AND e.monto != "0"';
    //echo $query;
    $db->setQuery($query);
    $cuenta = $db->loadResult();
    return $cuenta;
}
function getAreasPresupuestoAdm(){
    $db =& JFactory::getDBO();
    $query = 'SELECT a.*, c.codigo
    FROM #__erp_presupuesto_areas AS a
    LEFT JOIN #__erp_conta_cuentas AS c ON c.id = a.id_cta';
    $db->setQuery($query);
    $cuentas = $db->loadObjectList();
    return $cuentas;
}
function getAreaPresupuesto(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $query = 'SELECT a.*, c.codigo
    FROM #__erp_presupuesto_areas AS a
    LEFT JOIN #__erp_conta_cuentas AS c ON a.id_cta = c.id
    WHERE a.id = "'.$id.'"';
    $db->setQuery($query);
    $cuenta = $db->loadObject();
    return $cuenta;
}
function newAreaPresupuesto(){
    $db =& JFactory::getDBO();
    $id_cta = JRequest::getVar('id_cta','','post');
    $area = JRequest::getVar('area','','post');
    $query = 'INSERT INTO `cgn_erp_presupuesto_areas`(`id_cta`, `area`, `estado`) VALUES (';    
    $query .= '"'.$id_cta.'"';
    $query .= ', "'.$area.'"';
    $query .= ', "1"';
    $query .= ')';
    $db->setQuery($query);
    $db->query();
    newAccion('Creó área de presupuesto '.$area);
}
function editAreaPresupuesto(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id','','post');
    $id_cta = JRequest::getVar('id_cta','','post');
    $area = JRequest::getVar('area','','post');
    $estado = JRequest::getVar('estado','','post');
    $query = 'UPDATE #__erp_presupuesto_areas 
    SET id_cta = "'.$id_cta.'", area = "'.$area.'", estado = "'.$estado.'"
    WHERE id = "'.$id.'"';
    $db->setQuery($query);
    $db->query();
    newAccion('Editó Area de presupuesto '.$area);
}
function changeEstadoAreaP(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $estado = JRequest::getVar('estado');
    if($estado==1){
        $e = 0;
    }else{
        $e = 1;
    }
    $query = 'UPDATE #__erp_presupuesto_areas 
    SET estado = "'.$e.'"
    WHERE id = "'.$id.'"';
    $db->setQuery($query);
    $db->query();
}
function buscarAreas(){
    $db =& JFactory::getDBO();
    $codigo = invertir(invertir(JRequest::getVar('codigo','','post')));
    $query = 'SELECT c.id, c.nombre
    FROM #__erp_conta_cuentas AS c
    LEFT JOIN #__erp_presupuesto_areas AS a ON a.id_cta != c.id
    WHERE c.codigo = "'.$codigo.'"';
    $db->setQuery($query);
    $cuenta = $db->loadObject();
    return $cuenta;
    newAccion('Editó estado de Area de presupuesto');
}
function getPresupuestoGestion($id_cta, $id_gestion){
    $db =& JFactory::getDBO();

    $query = 'SELECT SUM(monto) FROM #__erp_presupuesto WHERE id_cta_contable = "'.$id_cta.'" AND id_gestion = "'.$id_gestion.'"';
    $db->setQuery($query);
    $total = $db->loadResult();

    return $total;
}
function getCNTcuentaspreRep($id_gestion, $todo=0, $mes=0){
    $db =& JFactory::getDBO();
	$where = '';
    $select = '';
	if($id_gestion > 0){
		$where.= ' AND p.id_gestion = '.$id_gestion;
    }   
    if($mes == 1){
	    $mes = JRequest::getVar('mes','1','get');
        $select.= ', p.monto';
        $where.= ' AND p.mes = "'.$mes.'%"';
    }
    $cta = JRequest::getVar('id_cta','','post');
    if($cta != ''){
        $select.= ', SUM(p.monto) AS monto';
        $where.= ' AND p.id_cta_contable = "'.$cta.'%"';
    }
    
    if($todo == 1){
        $select.= ', SUM(p.monto) AS monto';
    }
    
	$query = 'SELECT c.id, c.codigo, c.nombre'.$select.'
	FROM #__erp_conta_cuentas AS c
    LEFT JOIN #__erp_presupuesto AS p ON c.id = p.id_cta_contable
	WHERE (c.codigo LIKE "3%" OR c.codigo LIKE "4%") AND c.presupuesto = "1" '.$where.'
    GROUP BY p.id_cta_contable
	ORDER BY lft';
    //echo $query;
	$db->setQuery($query);
	$ctas = $db->loadObjectList();
	return $ctas;
}
/*---REPORTES PRESUPUESTOS*/
//parametro 3__001
function getRepPresupuestos($cta=0){
    $db =& JFactory::getDBO();
    $gestion = JRequest::getVar('gestion','','post');
    $mes = JRequest::getVar('mes','','post');
    $where = '';
    /*if($mes != ''){
        $where.= ' AND (p.mes = "'.$mes.'" AND p.id_gestion = "'.$gestion.'")';
    }*/
    $cuenta = '';
    if($cta != 0){
        $cuenta = ' AND c.codigo LIKE "'.$cta.'%"';
    }
    $query = 'SELECT c.id, c.nombre, c.codigo, c.id_gestion, e.monto AS monto_e
    FROM cgn_erp_conta_cuentas AS c
    LEFT JOIN cgn_erp_presupuesto_ejecutado AS e ON c.id = e.id_cta_contable
    LEFT JOIN cgn_erp_presupuesto AS p ON c.id = p.id_cta_contable
    WHERE c.presupuesto = "1" '.$cuenta.' '.$where;
    $query.= ' GROUP BY c.id';
    $db->setQuery($query);
	$ctas = $db->loadObjectList();
	return $ctas;
}
function getPMesesBefore($cta,$mes, $id_gestion){
    $db =& JFactory::getDBO();
    $query = 'SELECT monto
    FROM cgn_erp_presupuesto 
    WHERE id_cta_contable = "'.$cta.'" AND mes = "'.$mes.'" AND id_gestion = "'.$id_gestion.'"';
    $db->setQuery($query);
    $cta = $db->loadResult();
    return $cta;
}
function getPresupuestado($id_cta,$id_gestion){
    $db =& JFactory::getDBO();
    $query = 'SELECT SUM(monto) FROM `#__erp_presupuesto` WHERE `id_gestion` = "'.$id_gestion.'" AND `id_cta_contable` = "'.$id_cta.'"';
    $db->setQuery($query);
    $cta = $db->loadResult();
    return $cta;
}
/*function reformarCodigo(){
    $db =& JFactory::getDBO();
    $query= 'SELECT * FROM `TABLE 190` WHERE id_cta != "0"';
    $db->setQuery($query);
	$ctas = $db->loadObjectList();
    foreach ($ctas as $cta){
        $enero = str_replace(',','.',$cta->enero);  
        $febrero = str_replace(',','.',$cta->febrero);  
        $marzo = str_replace(',','.',$cta->marzo);  
        $abril = str_replace(',','.',$cta->abril);  
        $mayo = str_replace(',','.',$cta->mayo);  
        $junio = str_replace(',','.',$cta->junio);  
        $julio = str_replace(',','.',$cta->julio);  
        $agosto = str_replace(',','.',$cta->agosto);  
        $septiembre = str_replace(',','.',$cta->septiembre);  
        $octubre = str_replace(',','.',$cta->octubre);  
        $noviembre = str_replace(',','.',$cta->noviembre);  
        $diciembre = str_replace(',','.',$cta->diciembre);  
        $query = 'UPDATE `TABLE 190` SET 
        enero = "'.$enero.'",
        febrero = "'.$febrero.'",
        marzo = "'.$marzo.'",
        abril = "'.$abril.'",
        mayo = "'.$mayo.'",
        junio = "'.$junio.'",
        julio = "'.$julio.'",
        agosto = "'.$agosto.'",
        septiembre = "'.$septiembre.'",
        octubre = "'.$octubre.'",
        noviembre = "'.$noviembre.'",
        diciembre = "'.$diciembre.'"
        WHERE id = "'.$cta->id.'"';
        $db->setQuery($query);
        $db->query();
    }
    foreach ($ctas as $cta){
        for ($i = 1; $i <= 12; $i++){
            switch ($i){
                case '1':
                    $mesact = $cta->enero;
                    break;
                case '2':
                    $mesact = $cta->febrero;
                    break;
                case '3':
                    $mesact = $cta->marzo;
                    break;
                case '4':
                    $mesact = $cta->abril;
                    break;
                case '5':
                    $mesact = $cta->mayo;
                    break;
                case '6':
                    $mesact = $cta->junio;
                    break;
                case '7':
                    $mesact = $cta->julio;
                    break;
                case '8':
                    $mesact = $cta->agosto;
                    break;
                case '9':
                    $mesact = $cta->septiembre;
                    break;
                case '10':
                    $mesact = $cta->octubre;
                    break;
                case '11':
                    $mesact = $cta->noviembre;
                    break;
                case '12':
                    $mesact = $cta->diciembre;
                    break;
            }
            $query = 'INSERT INTO `cgn_erp_presupuesto`(`id_empresa`, `id_gestion`, `id_cta_contable`, `mes`, `monto`) VALUES (';
            $query.= '"1"';
            $query.= ', "20"';
            $query.= ', "'.$cta->id_cta.'"';
            $query.= ', "'.$i.'"';
            $query.= ', "'.$mesact.'"';
            $query.= ')';
            $db->setQuery($query);
            $db->query();            
        }
    }
    echo 'Procesado';
}*/
/*function reformarCodigo(){
    $db =& JFactory::getDBO();
    $query= 'SELECT * FROM `TABLE 191`';
    $db->setQuery($query);
	$ctas = $db->loadObjectList();
    foreach ($ctas as $cta){
        $abril = str_replace('.',',',$cta->abril);  
        $query = 'UPDATE `TABLE 190` SET abril = "'.$abril.'" WHERE id = "'.$cta->id.'"';
        $db->setQuery($query);
        $db->query();
    }
}*/
?>