<?
// Bancos
function getLBcuentas(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$query = 'SELECT * FROM #__erp_lb_bancos WHERE id_empresa = "'.$session->get('ide').'" ORDER BY banco, cuenta';
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;
	}
function getLBcuenta($id = 0){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'post');
	
	$query = 'SELECT * FROM #__erp_lb_bancos WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$cuenta = $db->loadObject();
	return $cuenta;
	}
function newLBcuenta(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$banco = JRequest::getVar('namebanco', '', 'post');
	$cuenta = JRequest::getVar('nrocuenta', '', 'post');
	$moneda = JRequest::getVar('tipomoneda', '', 'post');
	$digitos = JRequest::getVar('digitos', '', 'post');
	$debe = JRequest::getVar('debe', '', 'post');
	$haber = JRequest::getVar('haber', '', 'post');
	$imp_moneda = JRequest::getVar('impmoneda', '', 'post');
	$activa = JRequest::getVar('indicador', '1', 'post');
	$mesliteral = JRequest::getVar('mesliteral', '', 'post');
	$tipocambio = JRequest::getVar('tipo_cambio','','post');
    
	$query = 'INSERT INTO #__erp_lb_bancos(`id_empresa`, `id_usuario`, `banco`, `cuenta`, `moneda`, `tipo_cambio`, `digitos`, `debe`, `haber`, `imp_moneda`, `mesliteral`, `activa`, `fecha`) VALUES(';
	$query.= '"'.$session->get('ide').'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.$banco.'"';
	$query.= ', "'.$cuenta.'"';
	$query.= ', "'.$moneda.'"';
	$query.= ', "'.$tipocambio.'"';
	$query.= ', "'.$digitos.'"';
	$query.= ', "'.$debe.'"';
	$query.= ', "'.$haber.'"';
	$query.= ', "'.$imp_moneda.'"';
	$query.= ', "'.$mesliteral.'"';
	$query.= ', "'.$activa.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	$saldoinicial = JRequest::getVar('saldoinicial', '', 'post');
	
	$query = 'INSERT INTO #__erp_lb_bancos_cuentas(`id_cuenta`, `id_usuario`, `fecha`, `fecha_registro`, `detalle`, `debe`, `haber`, `apertura`) VALUES(';
	$query.= '"'.$id.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.fecha2($fecha).'"';
	$query.= ', NOW()';
	$query.= ', "Saldo Inicial"';
	$query.= ', "'.$saldoinicial.'"';
	$query.= ', "0"';
	$query.= ', "1"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Nuevo Banco: '.$banco);
	}
function editLBcuenta(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$id = JRequest::getVar('id', '', 'post');
	$banco = JRequest::getVar('namebanco', '', 'post');
	$cuenta = JRequest::getVar('nrocuenta', '', 'post');
	$moneda = JRequest::getVar('tipomoneda', '', 'post');
	$digitos = JRequest::getVar('digitos', '', 'post');
	$debe = JRequest::getVar('debe', '', 'post');
	$haber = JRequest::getVar('haber', '', 'post');
	$imp_moneda = JRequest::getVar('impmoneda', '', 'post');
    $tipocambio = JRequest::getVar('tipo_cambio','','post');
	$mesliteral = JRequest::getVar('mesliteral', '', 'post');
	
	$query = 'UPDATE #__erp_lb_bancos SET ';
	$query.= '`banco` = "'.$banco.'"';
	$query.= ', `cuenta` = "'.$cuenta.'"';
	$query.= ', `moneda` = "'.$moneda.'"';
	$query.= ', `digitos` = "'.$digitos.'"';
	$query.= ', `debe` = "'.$debe.'"';
	$query.= ', `haber` = "'.$haber.'"';
	$query.= ', `imp_moneda` = "'.$imp_moneda.'"';
	$query.= ', `tipo_cambio` = "'.$tipocambio.'"';
	$query.= ', `mesliteral` = "'.$mesliteral.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	//echo $query;
    newAccion('Editó Cuenta de banco'.$banco);
	}
function editLBcuentacheque(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$id = JRequest::getVar('id', '', 'post');
	$cantidad = JRequest::getVar('cantidad', '', 'post');
	$posx_montonum = JRequest::getVar('posx_montonum', '', 'post');
	$posy_montonum = JRequest::getVar('posy_montonum', '', 'post');
	$posx_montolit = JRequest::getVar('posx_montolit', '', 'post');
	$posy_montolit = JRequest::getVar('posy_montolit', '', 'post');
	$posx_nombre = JRequest::getVar('posx_nombre', '', 'post');
	$posy_nombre = JRequest::getVar('posy_nombre', '', 'post');
	$posx_moneda = JRequest::getVar('posx_moneda', '', 'post');
	$posy_moneda = JRequest::getVar('posy_moneda', '', 'post');
	$posx_ciudad = JRequest::getVar('posx_ciudad', '', 'post');
	$posy_ciudad = JRequest::getVar('posy_ciudad', '', 'post');
	$posx_dd = JRequest::getVar('posx_dd', '', 'post');
	$posy_dd = $posy_ciudad;
	$posx_mm = JRequest::getVar('posx_mm', '', 'post');
	$posy_mm = $posy_ciudad;
	$posx_aa = JRequest::getVar('posx_aa', '', 'post');
	$posy_aa = $posy_ciudad;
	
	$query = 'UPDATE #__erp_lb_bancos SET ';
	$query.= '`cantidad` = "'.$cantidad.'"';
	$query.= ', `posx_montonum` = "'.$posx_montonum.'"';
	$query.= ', `posy_montonum` = "'.$posy_montonum.'"';
	$query.= ', `posx_montolit` = "'.$posx_montolit.'"';
	$query.= ', `posy_montolit` = "'.$posy_montolit.'"';
	$query.= ', `posx_nombre` = "'.$posx_nombre.'"';
	$query.= ', `posy_nombre` = "'.$posy_nombre.'"';
	$query.= ', `posx_moneda` = "'.$posx_moneda.'"';
	$query.= ', `posy_moneda` = "'.$posy_moneda.'"';
	$query.= ', `posx_ciudad` = "'.$posx_ciudad.'"';
	$query.= ', `posy_ciudad` = "'.$posy_ciudad.'"';
	$query.= ', `posx_dd` = "'.$posx_dd.'"';
	$query.= ', `posy_dd` = "'.$posy_dd.'"';
	$query.= ', `posx_mm` = "'.$posx_mm.'"';
	$query.= ', `posy_mm` = "'.$posy_mm.'"';
	$query.= ', `posx_aa` = "'.$posx_aa.'"';
	$query.= ', `posy_aa` = "'.$posy_aa.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó Cheque');
	}
function editLBcuentachequeimg(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$id = JRequest::getVar('id', '', 'post');
	
	$ruta = 'media/com_erp/cheques/';
	$imagen = '';
	if($_FILES['imagen']['name'] != ''){
		$ext = explode('.',$_FILES['imagen']['name']);
		$imagen = date('U').'_'.rand().'.'.array_pop($ext);
		copy($_FILES['imagen']['tmp_name'], $ruta.$imagen);
		creaImagen($ruta.$imagen,800,400);
	}
	
	$query = 'UPDATE #__erp_lb_bancos SET ';
	$query.= '`imagen` = "'.$imagen.'"';
	$query.= ' WHERE id = "'.$id.'"';
	//echo $query;
	$db->setQuery($query);
	$db->query();
    newAccion('Editó Imagen de cheque');
	}
function disableLBcuenta(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$activa = JRequest::getVar('activa','0','post');
    
	$query = 'UPDATE #__erp_lb_bancos SET ';
	$query.= '`activa` = "'.$activa.'"';
	$query.= ', `id_usuariodes` = "'.$user->get('id').'"';
	$query.= ', `fecha_des` = NOW()';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Deshabilitó Cuenta de Banco');
	}

// Chequera
function getLBchequeras($id = 0){
	$db =& JFactory::getDBO(); 
	
	if($id != 0)
		$where = 'WHERE id_cuenta = "'.$id.'"';
	
	$query = 'SELECT * FROM #__erp_lb_chequera '.$where.' ORDER BY desde DESC';
	$db->setQuery($query);  
	$chequeras = $db->loadObjectList();
	return $chequeras;
	}
function getLBchequera($id = 0){
	$db =& JFactory::getDBO(); 
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'post');
	
	$query = 'SELECT * FROM #__erp_lb_chequera WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$chequera = $db->loadObject();
	return $chequera;
	}
function getLBchequerahasta($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT hasta FROM #__erp_lb_chequera WHERE id_cuenta = "'.$id.'" ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$hasta = $db->loadResult();
	
	if($hasta == '')
		$hasta = 0;
	
	return $hasta;
	}
function getLBchequescant($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_lb_cheque WHERE id_chequera = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	return $cant;
	}
function enableLBchequera($id){
	$db =& JFactory::getDBO();
	
	$query = 'UPDATE #__erp_lb_chequera SET activo = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Habilitó Chquera');
	}
function newLBchequera(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$id_cuenta = JRequest::getVar('banco', '', 'post');
	$desde = getLBchequerahasta($id_cuenta) + 1;
	$hasta = JRequest::getVar('hasta', '', 'post');
	
	$query = 'INSERT INTO #__erp_lb_chequera(`id_usuario`, `id_cuenta`, `desde`, `hasta`, `fecha`) VALUES(';
	$query.= '"'.$user->get('id').'"';
	$query.= ', "'.$id_cuenta.'"';
	$query.= ', "'.$desde.'"';
	$query.= ', "'.$hasta.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Nueva chequera');
	}
function editLBchequera(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$id_cuenta = JRequest::getVar('banco', '', 'post');
	$desde = getLBchequerahasta($id_cuenta) + 1;
	$hasta = JRequest::getVar('hasta', '', 'post');
	
	$query = 'UPDATE #__erp_lb_chequera SET ';
	$query.= '`id_cuenta` = "'.$id_cuenta.'"';
	$query.= ', `desde` = "'.$desde.'"';
	$query.= ', `hasta` = "'.$hasta.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó chequera');
	}
function activeLBchequera($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT id FROM #__erp_lb_chequera WHERE id_cuenta = "'.$id.'"'; 
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	return $id;
	}

// Cheque
function getLBcheques($id = 0, $imp = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$where = '1';
	if($id != 0)
		$where.= ' AND id_cuenta = "'.$id.'"';
	
	if($imp != 0)
		$where.= ' AND impreso = "0"';
    
    $del = explode('/',JRequest::getVar('del','','post'));
    $al = explode('/',JRequest::getVar('al','','post'));
	
    if(JRequest::getVar('del','','post') != '' and JRequest::getVar('al','','post') != ''){
        $where.= ' AND fecha_reg >= "'.$del[1].'-'.$del[0].'-01" AND fecha_reg <= "'.$al[1].'-'.$al[0].'-31"';
    }
	$query = 'SELECT * FROM #__erp_lb_cheque WHERE '.$where.' ORDER BY numero';
    //echo $query;
	$db->setQuery($query);  
	$cheques = $db->loadObjectList();
	return $cheques;
	}
function getLBcheque($id = 0){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'post');
	
	$query = 'SELECT * FROM #__erp_lb_cheque WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$cheque = $db->loadObject();
	return $cheque;
	}
function newLBcheque(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$fecha_reg = fecha2(JRequest::getVar('fecha', '', 'post'));
	$ciudad = JRequest::getVar('ciudad', '', 'post');
	$monto = JRequest::getVar('monto', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');
	$numero = JRequest::getVar('cheque', '', 'post');
	$id_cuenta = JRequest::getVar('banco', '', 'post');
	$id_chequera = activeLBchequera($id_cuenta);
	
	$query = 'INSERT INTO #__erp_lb_cheque(`id_cuenta`, `id_chequera`, `id_usuario`, `ciudad`, `numero`, `nombre`, `detalle`, `monto`, `fecha_reg`) VALUES(';
	$query.= '"'.$id_cuenta.'"';
	$query.= ', "'.$id_chequera.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.$ciudad.'"';
	$query.= ', "'.$numero.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$detalle.'"';
	$query.= ', "'.$monto.'"';
	$query.= ', "'.$fecha_reg.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Nuevo Cheque');
	}
function editLBcheque(){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$ciudad = JRequest::getVar('ciudad', '', 'post');
	$fecha_reg = JRequest::getVar('fecha', '', 'post');
	$monto = JRequest::getVar('monto', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');
	$numero = JRequest::getVar('cheque', '', 'post');
	$id_cuenta = JRequest::getVar('banco', '', 'post');
	$id_chequera = activeLBchequera($id_cuenta);
	
	$query = 'UPDATE #__erp_lb_cheque SET ';
	$query.= '`id_cuenta` = "'.$id_cuenta.'"';
	$query.= ', `ciudad` = "'.$ciudad.'"';
	$query.= ', `numero` = "'.$numero.'"';
	$query.= ', `nombre` = "'.$nombre.'"';
	$query.= ', `detalle` = "'.$detalle.'"';
	$query.= ', `monto` = "'.$monto.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('editó cheque');
	}
function annulLBcheque(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$motivo = JRequest::getVar('motivo', '', 'post');
	
	$query = 'UPDATE  #__erp_lb_cheque SET ';
	$query.= '`id_usuarioanu` = "'.$user->get('id').'"';
	$query.= ', `motivo_anu` = "'.$motivo.'"';
	$query.= ', `fecha_anu` = NOW()';
	$query.= ', `anulado` = "1"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Anuló cheque');
	}
function printLBcheque(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	
	$ids = $session->get('arraycheques');
	foreach($ids as $id){
		$query = 'UPDATE #__erp_lb_cheque SET ';
		$query.= '`id_usuarioprint` = "'.$user->get('id').'"';
		$query.= ', `fecha_print` = NOW()';
		$query.= ', `impreso` = "1"';
		$query.= ' WHERE id = "'.$id.'"';
		$db->setQuery($query);  
		$db->query();
		
		$cheque = getLBcheque($id);
		$query = 'INSERT INTO #__erp_lb_bancos_cuentas(`id_cuenta`, `id_usuario`, `id_cheque`, `fecha`, `fecha_registro`, `detalle`, `debe`, `haber`) VALUES(';
		$query.= '"'.$cheque->id_cuenta.'"';
		$query.= ', "'.$cheque->id_usuario.'"';
		$query.= ', "'.$id.'"';
		$query.= ', "'.$cheque->fecha_reg.'"';
		$query.= ', "'.$cheque->fecha_reg.'"';
		$query.= ', "'.$cheque->detalle.'"';
		$query.= ', "0"';
		$query.= ', "'.$cheque->monto.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	$session->clear('arraycheques');
    newAccion('Imprimió Cheques');
	}

// 
function newLBingeg($t){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_cuenta = JRequest::getVar('banco', '', 'post');
	$fecha = JRequest::getVar('fecha', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');
	if($t == 'I'){
		$haber = 0;
		$debe = JRequest::getVar('monto', 0, 'post');
		}else{
		$haber = JRequest::getVar('monto', 0, 'post');
		$debe = 0;
		}
	
	$query = 'INSERT INTO #__erp_lb_bancos_cuentas(`id_cuenta`, `id_usuario`, `fecha`, `fecha_registro`, `detalle`, `debe`, `haber`) VALUES(';
	$query.= '"'.$id_cuenta.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.fecha2($fecha).'"';
	$query.= ', NOW()';
	$query.= ', "'.$detalle.'"';
	$query.= ', "'.$debe.'"';
	$query.= ', "'.$haber.'"';
	$query.= ')';    
	$db->setQuery($query);  
	$db->query();
	}
function getLBingeg($id, $c = 0){
	$db =& JFactory::getDBO();
	
	$del = JRequest::getVar('del', JRequest::getVar('del'), 'post');
	$al = JRequest::getVar('al',JRequest::getVar('al'), 'post');
	$id_usuario_conciliado = JRequest::getVar('conciliador', JRequest::getvar('conciliador'), 'post');
	$id_usuario = JRequest::getVar('por', JRequest::getvar('por'), 'post');
	
	$where = '';
	if($del != '' && $al != '')
		$where = ' AND c.fecha >= "'.fecha3($del).'-01" AND c.fecha <= "'.fecha3($al).'-31"';
		elseif($del == '' && $al != '')
		$where = ' AND c.fecha <= "'.fecha3($al).'-31"';
		elseif($del != '' && $al == '')
		$where = ' AND c.fecha >= "'.fecha3($del).'-01"';
		
	if($id_usuario_conciliado != '')
		$where.= ' AND c.id_usuario_conciliado = "'.$id_usuario_conciliado.'"';
	if($id_usuario_conciliado != '')
		$where.= ' AND c.id_usuario = "'.$id_usuario.'"';
	
	if($c == 1)
		$where.= ' AND c.conciliado = "1"';
	
	$query = 'SELECT c.*, b.banco, b.cuenta, ch.numero, ch.nombre 
	FROM #__erp_lb_bancos_cuentas AS c
	LEFT JOIN #__erp_lb_bancos AS b ON b.id = c.id_cuenta
	LEFT JOIN #__erp_lb_cheque AS ch ON c.id_cheque = ch.id
	WHERE b.id = "'.$id.'" '.$where.'
	ORDER BY c.fecha ASC';
	//echo $query;
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;    
	}
function conciliaLBtrans($val){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	if($val == 0){
		$id_usuario_conciliado = 0;
		$fecha_conciliado = '"0000-00-00"';
		}else{
		$id_usuario_conciliado = $user->get('id');
		$fecha_conciliado = 'NOW()';
		}
	
	$query = 'UPDATE #__erp_lb_bancos_cuentas SET ';
	$query.= '`id_usuario_conciliado` = "'.$id_usuario_conciliado.'"';
	$query.= ', `fecha_conciliado` = '.$fecha_conciliado;
	$query.= ', `conciliado` = "'.$val.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Realizó conciliación bancaria');
	}
function getLBflujo($m){
	$db =& JFactory::getDBO();
	
	$del = JRequest::getVar('del', '', 'post');
	$al = JRequest::getVar('al', '', 'post');
	
	if($del != '')
		$where = ' AND c.fecha BETWEEN "'.fecha2($del).'" AND "'.fecha2($al).'"';
	
	$query = 'SELECT b.id, b.banco, b.cuenta, SUM(c.debe) AS ingresos, SUM(c.haber) AS egresos, SUM(c.debe - c.haber) AS saldo 
	FROM #__erp_lb_bancos_cuentas AS c 
	JOIN #__erp_lb_bancos AS b ON c.id_cuenta = b.id
	WHERE c.apertura = "0" AND c.conciliado = "1" AND b.moneda = "'.$m.'" '.$where.'
	GROUP BY c.id_cuenta';
	$db->setQuery($query);  
	$flujo = $db->loadObjectList();
	return $flujo;
	}
function getLBflujoap($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT debe FROM #__erp_lb_bancos_cuentas WHERE id_cuenta = "'.$id.'" AND apertura = "1"';
	$db->setQuery($query);  
	$inicial = $db->loadResult();
	return $inicial;
	}
?>