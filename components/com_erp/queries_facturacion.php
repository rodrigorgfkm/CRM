<?php
//sucursal
function getIdSucursalUsuarioF(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id_suc', '', 'get');
	
	$query = 'SELECT id_sucursal FROM #__erp_rel_usuario_sucursal WHERE id_usuario = "'.$user->get('id').'" AND id_sucursal = "'.$id.'"';
	$db->setQuery($query);  
	$id_sucursal = $db->loadResult();
	return $id_sucursal;
	}

// Tipo
function tipoImpresion(){
	$db =& JFactory::getDBO();
	$query = 'SELECT tipo FROM #__erp_facturacion_configuracion';
	$db->setQuery($query);  
	$tipo = $db->loadResult();
	return $tipo;
	}

// Operador
function getOperador(){
	$db =& JFactory::getDBO();
	$query = 'SELECT u.id, u.name
	FROM cgn_users AS u 
	LEFT JOIN #__user_usergroup_map AS ugm ON u.id = ugm.user_id 
	LEFT JOIN #__erp_rel_usuario_grupo AS rug ON u.id = rug.id_usuario 
	LEFT JOIN #__erp_rel_grupos_acceso AS rga ON rug.id_grupo = rga.id_grupo 
	WHERE rga.id_acceso = "14" OR ugm.group_id = "8" 
	GROUP BY u.id
	ORDER BY u.name';
	$db->setQuery($query);  
	$usuarios = $db->loadObjectList();
	return $usuarios;
	}

// Facturacion
function limiteFactura(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_configuracion WHERE 1';
	$db->setQuery($query);  
	$conf = $db->loadObject();
	return $conf;
	}
function facturasMes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_cabecera WHERE fecha LIKE "'.date('Y-m-').'%"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}

function filtroComillas($txt){
	$txt = str_replace('"', '&quot;', $txt);
	$txt = str_replace("'", '&quot;', $txt);
	return $txt;
	}
function newFactura(){
	$llave = getLlave();
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$sucursal = getSucursalUsuario();
	$id_usuario = $user->get('id');
	$id_cliente = trim(JRequest::getVar('id_cliente', '', 'post'));
	$id_empresa = trim(JRequest::getVar('id_empresa', '', 'post'));
	
	$nombre = trim(JRequest::getVar('cliente', '', 'post'));
	$anombre = trim(JRequest::getVar('nombre', '', 'post'));
	$nit = trim(JRequest::getVar('nit', 0, 'post'));
	$origen = trim(JRequest::getVar('origen', '', 'post'));
	$id_origen = trim(JRequest::getVar('id_origen', '', 'post'));
	$id_factura = trim(JRequest::getVar('id_factura', '1', 'post'));
	$id_tipopago = trim(JRequest::getVar('id_tipopago', '1', 'post'));
	$cheque_numero = trim(JRequest::getVar('cheque_numero', '1', 'post'));
	$cheque_banco = trim(JRequest::getVar('cheque_banco', '1', 'post'));
	$cant = JRequest::getVar('cant', '0', 'post');
    //echo $cant;    
	$cambio = JRequest::getVar('cambio', '0', 'post');
	$descuento = JRequest::getVar('descuento', '0.00', 'post');
	
	if(JRequest::getVar('id_suc', '', 'get') == '')
		$id_sucursal = $sucursal->id;
		else
		$id_sucursal = JRequest::getVar('id_suc', '', 'get');

	$numero = getLastFactura($id_sucursal) + 1;

	$query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
	$db->setQuery($query);
	$fec = $db->loadResult();
	if($fec == 1)
		$fecha = '"'.fecha2(JRequest::getVar('fecha', date('d/m/Y'), 'post')).'"';
		else
		$fecha = 'NOW()';
	
	if($id_origen != '')
		$addquery = ', `id_origen`, `origen`';
		
	$query = 'INSERT INTO #__erp_facturacion_cabecera(`id_llave`, `id_sucursal`, `id_usuario`, `id_usconsolida`, `id_empresa`, `numero`, `nombre`, `nit`, `fecha`, `fecha_pago`, `hora`, `estado`, `id_formapago`, `cheque_nro`, `cheque_banco`, `tipo_cambio`'.$addquery.') VALUES(';
	$query.= '"'.$llave->id.'"';
	$query.= ', "'.$id_sucursal.'"';
	$query.= ', "'.$id_usuario.'"';
	$query.= ', "'.$id_usuario.'"';
	$query.= ', "'.$id_cliente.'"';
	$query.= ', "'.$numero.'"';
	$query.= ', "'.$anombre.'"';
	$query.= ', "'.$nit.'"';
	$query.= ', '.$fecha;
	$query.= ', NOW()';
	$query.= ', NOW()';
	$query.= ', "V"';
	$query.= ', "'.$id_tipopago.'"';
	$query.= ', "'.$cheque_numero.'"';
	$query.= ', "'.$cheque_banco.'"';
	$query.= ', "'.$cambio.'"';
	if($id_origen != ''){
		$query.= ', "'.$id_origen.'"';
		$query.= ', "'.$origen.'"';
		}
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'UPDATE #__erp_facturacion_llave SET numero = "'.$numero.'" WHERE estado = "1" AND id_factura = "'.$id_factura.'" AND id_sucursal = "'.$id_sucursal.'"';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT id FROM #__erp_facturacion_cabecera ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	$total = 0;
	$aporte = getAporteCta();
	
	for($i=0; $i<=$cant; $i++){
		
		$codigo = JRequest::getVar('codigo_'.$i, '0', 'post');
		$id_producto = JRequest::getVar('id_producto_'.$i, '0', 'post');
		$id_ctacontable = JRequest::getVar('id_ctacontable_'.$i, '0', 'post');
		$cantidad = JRequest::getVar('cantidad_'.$i, '0', 'post');
		$detalle = JRequest::getVar('detalle_'.$i, '0', 'post');
		$precio = JRequest::getVar('precio_'.$i, '0', 'post');
		
		if($codigo != 'DESC-001'){
		  $total+= $cantidad * $precio;
        }
        if($cantidad > 0){
            if($aporte->id == $id_ctacontable){
                $field = ', `cuotas`';
                $value = ', 1';
            }else{
                $field = '';
                $value = '';
            }
            $query = 'INSERT INTO #__erp_facturacion_detalle(`id_factura`, `id_producto`, `id_ctacontable`, `codigo`, `cantidad`, `detalle`, `precio`'.$field.') VALUES(';
            $query.= '"'.$id.'"';
            $query.= ', "'.$id_producto.'"';
            $query.= ', "'.$id_ctacontable.'"';
            $query.= ', "'.filtroComillas($codigo).'"';
            $query.= ', "'.$cantidad.'"';
            $query.= ', "'.filtroComillas($detalle).'"';
            $query.= ', "'.$precio.'"'.$value;
            $query.= ')';
            $db->setQuery($query);
            $db->query();	
            echo $query;
            echo '</br>';
        }
    }
    if($detalle == 'Descuento'){
        $total = $total - $descuento;
    }
	$query = 'UPDATE #__erp_facturacion_cabecera SET ';
	$query.= '`total` = "'.$total.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	if($id_empresa != '')
		$where = 'id_cliente = "'.$id_empresa.'"';
		else
		$where = 'id_cliente = "'.$id_cliente.'"';
	
	$query = 'SELECT nit FROM #__erp_clientes_nit WHERE '.$where.' AND nit = "'.$nit.'"';
	$db->setQuery($query);  
	$resultado = $db->loadResult();
	if($resultado == ''){
		if($id_empresa != '')
			$id_cli = $id_empresa;
			else
			$id_cli = $id_cliente;
		$query = 'INSERT INTO #__erp_clientes_nit(`id_cliente`, `etiqueta`, `nombre`, `nit`) VALUES(';
		$query.= '"'.$id_cli.'"';
		$query.= ', "'.$anombre.'"';
		$query.= ', "'.$anombre.'"';
		$query.= ', "'.$nit.'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
	
	return $id;
    newAccion('Generó factura ',$numero);
	}
function editFactura(){
	$llave = getLlave();
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'post');
	$id_tipopago = trim(JRequest::getVar('id_tipopago', '1', 'post'));
	$cheque_numero = trim(JRequest::getVar('cheque_numero', '1', 'post'));
	$cheque_banco = trim(JRequest::getVar('cheque_banco', '1', 'post'));
	
	$query = 'UPDATE #__erp_facturacion_cabecera SET ';
	$query.= '`id_formapago` = "'.$id_tipopago.'"';
	$query.= ', `cheque_nro` = "'.$cheque_numero.'"';
	$query.= ', `cheque_banco` = "'.$cheque_banco.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó factura');
	}
function consFactura(){
	$llave = getLlave();
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$id_tipopago = JRequest::getVar('id_tipopago', '', 'post');
	$cheque_numero = JRequest::getVar('cheque_numero', '', 'post');
	$cheque_banco = JRequest::getVar('cheque_banco', '', 'post');
	$fecha = fecha2(JRequest::getVar('fecha', '', 'post'));
	
	$query = 'UPDATE #__erp_facturacion_cabecera SET ';
	$query.= '`id_usconsolida` = "'.$user->get('id').'"';
	$query.= ', `id_formapago` = "'.$id_tipopago.'"';
	$query.= ', `cheque_nro` = "'.$cheque_numero.'"';
	$query.= ', `cheque_banco` = "'.$cheque_banco.'"';
	$query.= ', `fecha_pago` = "'.$fecha.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

function guardaCodigoFactura($id, $codigo){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_facturacion_cabecera SET ';
	$query.= '`codigo` = "'.$codigo.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function getLastFactura($id_sucursal = 0){
	$db =& JFactory::getDBO();

	if($id_sucursal == 0)
		$id_sucursal = getIdSucursalUsuario();
	
	$id_factura = JRequest::getVar('id_factura', '1', 'post');
	
	$query = 'SELECT numero FROM #__erp_facturacion_llave WHERE estado =  "1" AND id_factura = "'.$id_factura.'" AND id_sucursal = "'.$id_sucursal.'" LIMIT 1';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	return $numero;
	}
function getFacturaDatos($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_clientes_nit WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	return $numero;
	}
function getFacturas($t = '', $token = ''){
	$session = JFactory::getSession();
	    
	if($session->get('rango') == 1){
		$fecha_ini = $session->get('fecha_ini');
		$fecha_fin = $session->get('fecha_fin');
		$w = ' AND f.fecha >= "'.$fecha_ini.'" AND f.fecha <= "'.$fecha_fin.'"';
		}else{
		$mes = $session->get('mes');
		$anio = $session->get('anio');
		$w = ' AND f.fecha LIKE "'.$anio.'-'.$mes.'-%"';
		}
	
	$s = $session->get('s')=='' ? checksucursalPred() : $session->get('s');

	$where = ' WHERE 1';
	if($session->get('filtro') != '')
		$where.= ' AND f.nombre LIKE "%'.$session->get('filtro').'%"';
	if($fecha_ini != '' || $mes != '')
		$where.= $w;
	if($s != '')
		$where.= ' AND f.id_sucursal = "'.$s.'"';
	if($session->get('t') != '')
		$where.= ' AND l.id_factura = "'.$session->get('t').'"';
	if($session->get('estado') != '')
		$where.= ' AND f.estado = "'.$session->get('estado').'"';
	if($session->get('u') != '')
		$where.= ' AND f.id_usuario = "'.$session->get('u').'"';
	if($session->get('numero') != '')
		$where.= ' AND f.numero = "'.$session->get('numero').'"';
	if($session->get('nit') != '')
		$where.= ' AND f.nit = "'.$session->get('nit').'"';
	
	if($t != ''){
		$select = ', SUM(d.cantidad * d. precio) AS subtotal';
		$join = 'LEFT JOIN #__erp_facturacion_detalle AS d ON f.id = d.id_factura';
		if($t == 'c')
			$where.= ' AND d.id_producto = "1"';
			else
			$where.= ' AND d.id_producto != "1"';
		}
	$p  = JRequest::getVar('p', '1', 'get');
	
	if(!empty($token)){
		$where.= ' AND f.token = "'.$token.'"';
	}

	$db =& JFactory::getDBO();
	$query = 'SELECT f.*, i.empresa, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla '.$select.'
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id 
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON l.id_factura = ff.id 
	'.$join.'
	'.$where.' 
	GROUP BY f.id
	ORDER BY f.id DESC';
	$query.= ' LIMIT '.(($p-1) * 20).',20';
    //echo $query;
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}
function getTFacturas($t = '', $token = ''){
	$session = JFactory::getSession();
	    
	if(JRequest::getVar('mes','','post')!=''){
		$mes = JRequest::getVar('mes','','post');
		$anio = JRequest::getVar('anio','','post');;
		$w = ' AND f.fecha LIKE "'.$anio.'-'.$mes.'-%"';
		}
	
	$s = JRequest::getVar('sucursal','','post')=='' ? checksucursalPred() : JRequest::getVar('sucursal','','post');

	$where = ' WHERE 1';
	if($session->get('filtro') != '')
		$where.= ' AND f.nombre LIKE "%'.$session->get('filtro').'%"';
	if($fecha_ini != '' || $mes != '')
		$where.= $w;
	if($s != '')
		$where.= ' AND f.id_sucursal = "'.$s.'"';
	if($session->get('t') != '')
		$where.= ' AND l.id_factura = "'.$session->get('t').'"';
	if(JRequest::getVar('estado','','post') != '')
		$where.= ' AND f.estado = "'.JRequest::getVar('estado','','post').'"';
	if(JRequest::getVar('usuario','','post') != '')
		$where.= ' AND f.id_usuario = "'.JRequest::getVar('usuario','','post').'"';
	if(JRequest::getVar('numero','','post') != '')
		$where.= ' AND f.numero = "'.$session->get('numero').'"';
	if($session->get('nit') != '')
		$where.= ' AND f.nit = "'.$session->get('nit').'"';
	
	if($t != ''){
		$select = ', SUM(d.cantidad * d. precio) AS subtotal';
		$join = 'LEFT JOIN #__erp_facturacion_detalle AS d ON f.id = d.id_factura';
		if($t == 'c')
			$where.= ' AND d.id_producto = "1"';
			else
			$where.= ' AND d.id_producto != "1"';
		}
	$p  = JRequest::getVar('p', '1', 'get');
	
	if(!empty($token)){
		$where.= ' AND f.token = "'.$token.'"';
	}

	$db =& JFactory::getDBO();
	$query = 'SELECT f.*, i.empresa, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla '.$select.'
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id 
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON l.id_factura = ff.id 
	'.$join.'
	'.$where.' 
	GROUP BY f.id
	ORDER BY f.id DESC';
	$query.= ' LIMIT '.(($p-1) * 20).',20';
    //echo $query;
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}
function getFacturasPaginacion($t = '', $token = ''){
	$session = JFactory::getSession();
	
	if($session->get('rango') == 1){
		$fecha_ini = $session->get('fecha_ini');
		$fecha_fin = $session->get('fecha_fin');
		$w = ' AND f.fecha >= "'.$fecha_ini.'" AND f.fecha <= "'.$fecha_fin.'"';
		}else{
		$mes = $session->get('mes');
		$anio = $session->get('anio');
		$w = ' AND f.fecha LIKE "'.$anio.'-'.$mes.'-%"';
		}
	
	$where = ' WHERE i.activo = "1"';
	if($session->get('filtro') != '')
		$where.= ' AND f.nombre LIKE "%'.$session->get('filtro').'%"';
	if($fecha_ini != '' || $mes != '')
		$where.= $w;
	if($session->get('s') != '')
		$where.= ' AND f.id_sucursal = "'.$session->get('s').'"';
	if($session->get('t') != '')
		$where.= ' AND l.id_factura = "'.$session->get('t').'"';
	if($session->get('estado') != '')
		$where.= ' AND f.estado = "'.$session->get('estado').'"';
	if($session->get('u') != '')
		$where.= ' AND f.id_usuario = "'.$session->get('u').'"';
	if($session->get('numero') != '')
		$where.= ' AND f.numero = "'.$session->get('numero').'"';
	if($session->get('nit') != '')
		$where.= ' AND f.nit = "'.$session->get('nit').'"';
	
	if($t != ''){
		$select = ', SUM(d.cantidad * d. precio) AS subtotal';
		$join = 'LEFT JOIN #__erp_facturacion_detalle AS d ON f.id = d.id_factura';
		if($t == 'c')
			$where.= ' AND d.id_producto = "1"';
			else
			$where.= ' AND d.id_producto != "1"';
		}
	
	if(!empty($token)){
		$where.= ' AND f.token = "'.$token.'"';
	}

	$cant= 20;
	$p  = JRequest::getVar('p', '1', 'post');
	
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(f.id)
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id 
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON l.id_factura = ff.id 
	'.$join.'
	'.$where;
	$db->setQuery($query);  
	$facturas = $db->loadResult();
	
	$paginas = $facturas / $cant;
	if(($facturas % $cant) != 0)
		$paginas = ceil($paginas);
	return $paginas;
	}
function getFacturasVentas(){
	$db =& JFactory::getDBO();
	
	$where = ' WHERE i.activo = "1" AND f.id_comprobante = "0"';
	if(JRequest::getVar('filtro', '', 'post') != '')
		$where.= ' AND '.JRequest::getVar('campo', '', 'post').' LIKE "%'.JRequest::getVar('filtro', '', 'post').'%"';
	if(JRequest::getVar('mes', '', 'post') != '')
		$where.= ' AND f.fecha LIKE "'.JRequest::getVar('anio', '', 'post').'-'.JRequest::getVar('mes', '', 'post').'%"';
	if(JRequest::getVar('sucursal', '', 'post') != '')
		$where.= ' AND f.id_sucursal = "'.JRequest::getVar('sucursal', '', 'post').'"';
	if(JRequest::getVar('tipo', '', 'post') != '')
		$where.= ' AND l.id_factura = "'.JRequest::getVar('tipo', '', 'post').'"';
	if(JRequest::getVar('estado', '', 'post') != '')
		$where.= ' AND f.estado = "'.JRequest::getVar('estado', '', 'post').'"';
	
	
	$query = 'SELECT f.*, i.empresa, s.nombre AS sucursal_nombre, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla 
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_llave AS l ON f.id_llave = l.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON l.id_factura = ff.id
	'.$where.' 
	ORDER BY f.id ASC';
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}

function getFacturasAsigna(){
	$where = ' WHERE id_persona = "0" AND id_empresa = "0" ';
	if(JRequest::getVar('filtro', '', 'post') != '')
		$where.= ' AND '.JRequest::getVar('campo', '', 'post').' LIKE "%'.JRequest::getVar('filtro', '', 'post').'%"';
	if(JRequest::getVar('mes', '', 'post') != '')
		$where.= ' AND fecha LIKE "'.JRequest::getVar('anio', '', 'post').'-'.JRequest::getVar('mes', '', 'post').'%"';
	
	$db =& JFactory::getDBO();
	$query = 'SELECT f.*, i.empresa 
	FROM #__erp_facturacion_cabecera AS f 
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id 
	LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id 
	'.$where.' 
	ORDER BY f.id DESC
	LIMIT 10';
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}
function getFactura($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT f.*, p.forma, i.empresa, c.registro, cat.categoria, e.estado AS cliente_estado 
	FROM #__erp_facturacion_cabecera AS f
	LEFT JOIN #__erp_clientes_info AS i ON f.id_empresa = i.id_cliente
	LEFT JOIN #__erp_clientes AS c ON f.id_empresa = c.id
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON rce.id_cliente = c.id
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	LEFT JOIN #__erp_facturacion_formapago AS p ON f.id_formapago = p.id
	WHERE f.id = "'.$id.'"';
	$db->setQuery($query);
	$factura = $db->loadObject();
	return $factura;
	}
function getFacturaNum($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT numero FROM #__erp_facturacion_cabecera WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$factura = $db->loadResult();
	return $factura;
	}
function getFacturaDetalle($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
		
	$query = 'SELECT * FROM #__erp_facturacion_detalle WHERE id_factura = "'.$id.'"';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}


function anulaFactura(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$query = 'UPDATE #__erp_facturacion_cabecera SET ';
	$query.= '`estado` = "A"';
	$query.= ', `id_anulado` = "'.$user->get('id').'"';
	$query.= ', `motivo_anulado` = "'.JRequest::getVar('motivo', '', 'post').'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Anuló Factura, por motivo de: ',JRequest::getVar('motivo', '', 'post'));
	}
function asignaCliente(){
	$db =& JFactory::getDBO();

	for($i=0; $i<count($_POST['id_factura']); $i++){
		$datos = explode('|', $_POST['id_cliente'][$i]);
		if($datos[0] == 'e')
			$campo = 'id_empresa';
		else
			$campo = 'id_persona';

		$query = 'UPDATE #__erp_facturacion_cabecera SET ';
		$query.= $campo.' = "'.$datos[1].'"';
		$query.= ' WHERE id = "'.$_POST['id_factura'][$i].'"';
		$db->setQuery($query);
		$db->query();
		}
	}
function actualizaFactura(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_facturacion_cabecera SET `impreso` = "1" WHERE id = "'.JRequest::getVar('id', '', 'post').'"';
	$db->setQuery($query);
	$db->query();
	}
	
// Facturación Masiva
function actualizaFacturaMasiva(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_facturacion_masiva SET `impreso` = "1" WHERE id = "'.JRequest::getVar('id', '', 'post').'"';
	$db->setQuery($query);
	$db->query();
	}
function sumFacturacionMasiva($token){
	$db =& JFactory::getDBO();

	$query = 'SELECT SUM(total) FROM #__erp_facturacion_cabecera WHERE token = "'.$token.'"';
	$db->setQuery($query);  
	$suma = $db->loadResult();

	if(empty($suma)){
		$suma = 0;
	}

	return $suma;
}
function newFacturaMasiva(){
    $db =& JFactory::getDBO();

    $llave = getLlave();
    $user =& JFactory::getUser();
    $aporteCta = getAporteCta();

    $id_usuario = $user->get('id');
    //$id_categoria = JRequest::getVar('id_categoria', 1, 'post');
    $filas = JRequest::getVar('filas', 1, 'post');
    $detalle = JRequest::getVar('detalle', '', 'post');
    $mes = JRequest::getVar('mes', '', 'post');
    $anio = JRequest::getVar('anio', '', 'post');
    $tipo_cambio = JRequest::getVar('cambio', '', 'post');
    $fecha_pago = JRequest::getVar('fecha_pago', '', 'post');
    $token = date('U').'_'.rand();

    $id_factura = trim(JRequest::getVar('id_factura', '1', 'post'));

    if(JRequest::getVar('id_suc', '', 'get') == ''){
        $id_sucursal = $sucursal->id;        
    }else{
        $id_sucursal = JRequest::getVar('id_suc', '', 'get');        
    }

    $query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
    $db->setQuery($query);
    $fec = $db->loadResult();
    if($fec == 1){
        $fecha = '"'.fecha2(JRequest::getVar('fecha', date('d/m/Y'), 'post')).'"';        
    }else{
        $fecha = 'NOW()';
    }

    $query = 'SELECT c.id, i.id_categoria
    FROM #__erp_clientes AS c
    LEFT JOIN #__erp_clientes_info AS i ON i.id_cliente = c.id
    LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
    LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
    LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
    LEFT JOIN #__erp_clientes_mca AS f ON f.id = i.id_usuario_cobrador
    WHERE c.masiva = "1" AND i.activo = "1" AND rce.activo = "1" AND rce.id_estado = 1 AND f.habilitado = 1 AND c.registro != ""';

    $db->setQuery($query);  
    $ids = $db->loadObjectList();

    $query = 'INSERT INTO #__erp_facturacion_masiva(`id_usuario`, `id_tipofactura`, `descripcion`, `fecha`, `mes`, `anio`, `token`) VALUES(';
    $query.= '"'.$id_usuario.'"';
    $query.= ', "'.$id_factura.'"';
    $query.= ', "'.filtroCadena2($detalle).'"';
    $query.= ', "'.fecha2($fecha_pago).'"';
    $query.= ', "'.$mes.'"';
    $query.= ', "'.$anio.'"';
    $query.= ', "'.$token.'"';
    $query.= ')';
    $db->setQuery($query);
    $db->query();

    foreach($ids as $id_cliente){
 
        $query = 'SELECT `nombre`, `nit` FROM #__erp_clientes_nit WHERE id_cliente = "'.$id_cliente->id.'" AND principal = "1"';
        $db->setQuery($query);  
        $nit = $db->loadObject();

        if($nit->nit != ''){
        $nombre = $nit->nombre;
        $nit = trim($nit->nit);
        }else{
        $query = 'SELECT empresa FROM #__erp_clientes_info WHERE id_cliente = "'.$id_cliente->id.'" AND activo = "1"';
        $db->setQuery($query);  
        $nombre = $db->loadResult();
        $nit = 0;
        }

        if(checkAporte($id_cliente->id) == 0){
        $numero = getLastFactura($id_sucursal) + 1;
        $monto = getCategoriaAporte($id_cliente->id_categoria);

        $query = 'INSERT INTO #__erp_facturacion_cabecera(`id_llave`, `id_sucursal`, `id_usuario`, `id_empresa`, `numero`, `nombre`, `nit`, `tipo_cambio`, `fecha`, `fecha_pago`, `hora`, `estado`, `total`, `id_formapago`, `token`) VALUES(';
        $query.= '"'.$llave->id.'"';
        $query.= ', "'.$id_sucursal.'"';
        $query.= ', "'.$id_usuario.'"';
        $query.= ', "'.$id_cliente->id.'"';
        $query.= ', "'.$numero.'"';
        $query.= ', "'.filtroCadena2($nombre).'"';
        $query.= ', "'.$nit.'"';
        $query.= ', "'.$tipo_cambio.'"';
        $query.= ', '.$fecha;
        $query.= ', "'.fecha2($fecha_pago).'"';
        $query.= ', NOW()';
        $query.= ', "V"';
        $query.= ', "'.$monto.'"';
        $query.= ', "12"';
        $query.= ', "'.$token.'"';
        $query.= ')';
        $db->setQuery($query);
        $db->query();

        $query = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query);  
        $id = $db->loadResult();

        $query = 'UPDATE #__erp_facturacion_llave SET numero = "'.$numero.'" WHERE estado = "1" AND id_factura = "'.$id_factura.'" AND id_sucursal = "'.$id_sucursal.'"';
        $db->setQuery($query);
        $db->query();

        $detalle = JRequest::getVar('detalle_fact', '', 'post').' '.mes($mes).' '.$anio;

        $query = 'INSERT INTO #__erp_facturacion_detalle(`id_producto`, `id_ctacontable`, `id_factura`, `cantidad`, `detalle`, `precio`, `cuotas`) VALUES(';
        $query.= '"1"';
        $query.= ', "'.$aporteCta->id.'"';
        $query.= ', "'.$id.'"';
        $query.= ', "'.JRequest::getVar('cantidad', '1', 'post').'"';
        $query.= ', "'.$detalle.'"';
        $query.= ', "'.$monto.'"';
        $query.= ', "1"';
        $query.= ')';
        $db->setQuery($query);
        $db->query(); 

        $query = 'INSERT INTO #__erp_aportes_pagos(`id_cliente`, `id_factura`, `id_usuario`, `fecha`, `cant_aportes`, `monto`) VALUES(';
        $query.= '"'.$id_cliente->id.'"';
        $query.= ', "'.$id.'"';
        $query.= ', "'.$id_usuario.'"';
        $query.= ', NOW()';
        $query.= ', "1"';
        $query.= ', "'.$monto.'"';
        $query.= ')';
        $db->setQuery($query);
        $db->query();

        $query = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query);  
        $id_pago = $db->loadResult();

        $query = 'INSERT INTO #__erp_aportes_mes(`id_cliente`, `id_pago`, `monto`, `mes`, `anio`) VALUES(';
        $query.= '"'.$id_cliente->id.'"';
        $query.= ', "'.$id_pago.'"';
        $query.= ', "'.$monto.'"';
        $query.= ', "'.$mes.'"';
        $query.= ', "'.$anio.'"';
        $query.= ')';
        $db->setQuery($query);
        $db->query();

        $query = 'INSERT INTO #__erp_aportes_pagos_deuda(`id_cliente`, `id_usuario_registro`, `monto`, `glosa`, `fecha_registro`) VALUES("'.$id_cliente->id.'", "'.$id_usuario.'", "'.$monto.'", "Registro por el mes de '.$mes.'/'.$anio.'", NOW())';
        $db->setQuery($query);
        $db->query();

                $query = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query);  
        $id_portes_pagos_deuda = $db->loadResult();

        $query = 'INSERT INTO #__erp_aportes_deuda(id_cliente, id_portes_pagos_deuda, monto, mes, anio, detalle, fecha_reg, f_pago) VALUES("'.$id_cliente->id.'", "'.$id_portes_pagos_deuda.'", "'.$monto.'", "'.$mes.'", "'.$anio.'", "'.$detalle.'", NOW(), "'.fecha2($fecha_pago).'")';
        $db->setQuery($query);
        $db->query();
    }
 }
return $token;
    newAccion('Generó Facturación Masiva');
}
function checkAporte($id){
	$db =& JFactory::getDBO();
	
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_aportes_mes WHERE id_cliente = "'.$id.'" AND mes = "'.$mes.'" AND anio = "'.$anio.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	return $cant;
	}
function RevisaAporte($id, $mes, $anio){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_aportes_mes WHERE id_cliente = "'.$id.'" AND mes = "'.$mes.'" AND anio = "'.$anio.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	return $cant;
	}
function generaDeuda($id, $mes, $anio, $monto){
	$db =& JFactory::getDBO();
	
	$query = 'INSERT INTO #__erp_aportes_deuda(`id_cliente`, `monto`, `mes`, `anio`) VALUES("'.$id.'", "'.$monto.'", "'.$mes.'", "'.$anio.'")';
	$db->setQuery($query);
	$db->query();
	}
function countFacturacionMasiva(){
	$db =& JFactory::getDBO();
	$session =& JFactory::getSession();
	
	$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT * FROM #__erp_facturacion_masiva WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$factura = $db->loadObject();
	
	return $factura;
	}
function countFacturaMasiva(){
	$db =& JFactory::getDBO();
	$session =& JFactory::getSession();
	
	$token = $session->get('token');
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_cabecera WHERE token = "'.$token.'" AND codigo = ""';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	return $cant;
	}
function getFacturaMasiva(){
	$db =& JFactory::getDBO();
	$session =& JFactory::getSession();
	
	$token = $session->get('token');
	
	$query = 'SELECT id FROM #__erp_facturacion_cabecera WHERE token = "'.$token.'" AND codigo = "" LIMIT 1';
	$db->setQuery($query);  
	$factura = $db->loadResult();
	
	return $factura;
	}
function getFacturasMasiva(){
	$db =& JFactory::getDBO();
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
    $where = '';
    
    if($mes!=''){
        $where.=' AND m.fecha LIKE "%-'.$mes.'-%"';
    }
    if($anio!=''){
        $where.=' AND m.fecha LIKE "'.$anio.'-%-%"';
    }
    if($s!=''){
        $where.=' AND f.id_sucursal = "'.$s.'"';
    }
    if($u!=''){
        $where.=' AND m.id_usuario = "'.$u.'"';
    }
	$query = 'SELECT m.*, COUNT(f.id) AS cant, t.factura 
	FROM #__erp_facturacion_masiva AS m
	LEFT JOIN #__erp_facturacion_factura AS t ON m.id_tipofactura = t.id
	LEFT JOIN #__erp_facturacion_cabecera AS f ON m.token = f.token
    WHERE 1'.$where.'
	GROUP BY f.token
	ORDER BY m.fecha DESC';
    //echo $query;
	$db->setQuery($query);  
	$masivo = $db->loadObjectList();
	
	return $masivo;
	}
function getFacturasLista(){
	$db =& JFactory::getDBO();
	$p  = JRequest::getVar('p', '1', 'get');
	$token = JRequest::getVar('token', '', 'get');
	$cant= 40;
    
	$query = 'SELECT * FROM #__erp_facturacion_cabecera WHERE token = "'.$token.'"';
    $query.= ' LIMIT '.(($p-1) * 10).',10';
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	
	return $facturas;
	}
function getFacturasListaPag(){
	$db =& JFactory::getDBO();
	
	$token = JRequest::getVar('token', '', 'get');
	$cant= 20;
	$p  = JRequest::getVar('p', '1', 'post');
	$query = 'SELECT * FROM #__erp_facturacion_cabecera WHERE token = "'.$token.'"';
	$db->setQuery($query);  
	
	$facturas = $db->loadResult();
	echo $facturas;
	$paginas = $facturas / $cant;
    
	if(($facturas % $cant) != 0)
		$paginas = ceil($paginas);
    $paginas= $paginas+1 ;
    echo $paginas;
	return $paginas;
	}
// Llaves de dosificacion
function compruebaLlave(){
	$db =& JFactory::getDBO();
	$id_sucursal = JRequest::getVar('id_suc', '', 'get');
	$id_factura = JRequest::getVar('id_factura', '1', 'post');
	
	$fecha_actual = date('Y-m-d');
	$query = 'SELECT fecha_limite FROM #__erp_facturacion_llave WHERE estado = "1" AND id_factura = "'.$id_factura.'" AND id_sucursal = "'.$id_sucursal.'"';
	$db->setQuery($query);  
	$llave = $db->loadResult();
	if($llave >= $fecha_actual)
		return true;
		else{
		$query = 'SELECT * FROM #__erp_facturacion_llave WHERE fecha_limite > "'.$fecha_actual.'" AND id_factura = "'.$id_factura.'" AND id_sucursal = "'.$id_sucursal.'"';
		$db->setQuery($query);  
		$nuevallave = $db->loadObject();
		if($nuevallave->id !=''){
			$query = 'UPDATE #__erp_facturacion_llave SET estado = "0" WHERE id_sucursal = "'.$id_sucursal.'" AND id_factura = "'.$id_factura.'"';
			$db->setQuery($query);
			$db->query();
			$query = 'UPDATE #__erp_facturacion_llave SET estado = "1" WHERE id = "'.$nuevallave->id.'"';
			$db->setQuery($query);
			$db->query();
			return true;
			}else
			return false;
		}
	}
function getLlave($id = 0){
	$db =& JFactory::getDBO();
	$id_sucursal = JRequest::getVar('id_sucursal', JRequest::getVar('id_suc', '', 'get'), 'post');
	$id_factura = JRequest::getVar('id_factura', '1', 'post');
	
	if($id == 0)
		$where = 'id_sucursal = "'.$id_sucursal.'" AND id_factura = "'.$id_factura.'" AND estado = "1"';
		else
		$where = 'id = "'.$id.'"';
	
	$query = 'SELECT * FROM #__erp_facturacion_llave WHERE '.$where;
	$db->setQuery($query);
	$llave = $db->loadObject();
	return $llave;
	}
function getLlaves(){
	$db =& JFactory::getDBO();
	$query = 'SELECT l.*, s.nombre, f.factura 
	FROM #__erp_facturacion_llave AS l 
	LEFT JOIN #__erp_sucursales AS s ON l.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_factura AS f ON id_factura = f.id 
	ORDER BY l.id DESC';
	$db->setQuery($query);  
	$llaves = $db->loadObjectList();
	return $llaves;
	}
function deleteLlave(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_facturacion_llave WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function newLlave(){
	$db =& JFactory::getDBO();
	
	$autorizacion = JRequest::getVar('autorizacion', '', 'post');
	$llave = JRequest::getVar('llave', '', 'post');
	$fecha_limite = explode('/',JRequest::getVar('fecha_limite', '', 'post'));
	$id_sucursal = JRequest::getVar('id_sucursal', '', 'post');
	$id_factura = JRequest::getVar('id_factura', '', 'post');
	
	$query = 'INSERT INTO #__erp_facturacion_llave(`id_sucursal`, `id_factura`, `autorizacion`, `llave`, `fecha_creacion`, `fecha_limite`) VALUES(';
	$query.= '"'.$id_sucursal.'"';
	$query.= ', "'.$id_factura.'"';
	$query.= ', "'.$autorizacion.'"';
	$query.= ', "'.addslashes($llave).'"';
	$query.= ', NOW()';
	$query.= ', "'.$fecha_limite[2].'-'.$fecha_limite[1].'-'.$fecha_limite[0].'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	}
function verifyFactura($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_cabecera WHERE id_llave = "'.$id.'" GROUP BY id_llave';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}

// Libro de Compras
function deleteCompra(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_facturacion_compras WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function getEmpresasCompra($t = 0){
	if($t == 1)
		$where = '1';
		else
		$where = 'empresa LIKE "%'.JRequest::getVar('empresa', '', 'post').'%"';
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_compras_empresa WHERE '.$where.' ORDER BY empresa';
	$db->setQuery($query);  
	$empresas = $db->loadObjectList();
	return $empresas;
	}
function getNitCompra(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_compras_empresa WHERE nit = "'.JRequest::getVar('nit', '', 'post').'"';
	$db->setQuery($query);  
	$nit = $db->loadObject();
	return $nit;
	}
function newCompra(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$facturas = '';
	
	$cant = JRequest::getVar('cantidad', '', 'post');
	
	for($i=0; $i<=$cant; $i++){
		
		$empresa = filtroCadena(JRequest::getVar('empresa_'.$i, '', 'post'));
		$id_empresa = JRequest::getVar('id_empresa_'.$i, '', 'post');
		$nit = JRequest::getVar('nit_'.$i, '', 'post');
		$numero = JRequest::getVar('numero_'.$i, '', 'post');
		$autorizacion = JRequest::getVar('autorizacion_'.$i, '', 'post');
		$fecha_emision = JRequest::getVar('fecha_emision_'.$i, '', 'post');
		$codigo = JRequest::getVar('codigo_'.$i, '', 'post');
		$total = JRequest::getVar('total_'.$i, '', 'post');
		$nocredito = JRequest::getVar('nocredito_'.$i, '', 'post');
		$descuento = JRequest::getVar('descuento_'.$i, '', 'post');
		$dui = JRequest::getVar('dui_'.$i, '', 'post');
		$tipo = JRequest::getVar('tipo_'.$i, '', 'post');
		$id_producto = JRequest::getVar('servicio_'.$i, '', 'post');
		
		$query = 'SELECT id FROM #__erp_facturacion_compras WHERE nit = "'.$nit.'" AND numero = "'.$numero.'" AND autorizacion = "'.$autorizacion.'"';
		$db->setQuery($query);  
		$id = $db->loadResult();
		
		if($id == ''){
			$query = 'INSERT INTO #__erp_facturacion_compras(`id_usuario`, `id_producto`, `id_empresa`, `empresa`, `nit`, `numero`, `autorizacion`, `fecha_emision`, `codigo`, `total`, `fecha`, `hora`, `nocredito`, `descuento`, `dui`, `tipo`) VALUES(';
			$query.= '"'.$user->get('id').'"';
			$query.= ', "'.$id_producto.'"';
			$query.= ', "'.$id_empresa.'"';
			$query.= ', "'.$empresa.'"';
			$query.= ', "'.$nit.'"';
			$query.= ', "'.$numero.'"';
			$query.= ', "'.$autorizacion.'"';
			$query.= ', "'.fecha2($fecha_emision).'"';
			$query.= ', "'.$codigo.'"';
			$query.= ', "'.$total.'"';
			$query.= ', NOW()';
			$query.= ', NOW()';
			$query.= ', "'.$nocredito.'"';
			$query.= ', "'.$descuento.'"';
			$query.= ', "'.$dui.'"';
			$query.= ', "'.$tipo.'"';
			$query.= ')';
			$db->setQuery($query);
			$db->query();
			
			$query = 'SELECT COUNT(empresa) FROM #__erp_facturacion_compras_empresa WHERE empresa = "'.$empresa.'" AND nit = "'.$nit.'"';
			$db->setQuery($query);  
			$resultado = $db->loadResult();
			if($resultado == '0'){
				$query = 'INSERT INTO #__erp_facturacion_compras_empresa(`empresa`, `nit`) VALUES(';
				$query.= '"'.$empresa.'"';
				$query.= ', "'.$nit.'"';
				$query.= ')';
				$db->setQuery($query);
				$db->query();
				}
			}else{
			$facturas = $nit.'|'.$numero.'|'.$autorizacion.':';
			}
		}
	return $facturas;
    newAccion('Generó nueva Compra, Empresa: '.$empresa);
	}
function editCompra(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$query = 'UPDATE #__erp_facturacion_compras SET ';
	$query.= '`id_empresa` = "'.JRequest::getVar('id_empresa', '', 'post').'"';
	$query.= ', `empresa` = "'.JRequest::getVar('empresa', '', 'post').'"';
	$query.= ', `nit` = "'.JRequest::getVar('nit', '', 'post').'"';
	$query.= ', `numero` = "'.JRequest::getVar('numero', '', 'post').'"';
	$query.= ', `autorizacion` = "'.JRequest::getVar('autorizacion', '', 'post').'"';
	$query.= ', `fecha_emision` = "'.fecha2(JRequest::getVar('fecha_emision', '', 'post')).'"';
	$query.= ', `codigo` = "'.JRequest::getVar('codigo', '', 'post').'"';
	$query.= ', `total` = "'.JRequest::getVar('total', '', 'post').'"';
	$query.= ', `nocredito` = "'.JRequest::getVar('nocredito', '', 'post').'"';
	$query.= ', `descuento` = "'.JRequest::getVar('descuento', '', 'post').'"';
	$query.= ', `dui` = "'.JRequest::getVar('dui', '', 'post').'"';
	$query.= ', `tipo` = "'.JRequest::getVar('tipo', '', 'post').'"';
	$query.= ', `id_producto` = "'.JRequest::getVar('servicio', '', 'post').'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
    
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT empresa FROM #__erp_facturacion_compras_empresa WHERE empresa = "'.$_POST['empresa'][$i].'" AND nit = "'.$_POST['nit'][$i].'"';
	$db->setQuery($query);  
	$resultado = $db->loadResult();
	if($resultado == ''){
		$query = 'INSERT INTO #__erp_facturacion_compras_empresa(`empresa`, `nit`) VALUES(';
		$query.= '"'.JRequest::getVar('empresa', '', 'post').'"';
		$query.= ', "'.JRequest::getVar('nit', '', 'post').'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
    newAccion('editó Compra, Empresa: '.$empresa);
	}
function getCompras($p = ''){
	$db =& JFactory::getDBO();
	
	if(JRequest::getVar('rango', '', 'post') == 1){
		$fecha_ini = JRequest::getVar('fecha_ini', '', 'post');
		$fecha_fin = JRequest::getVar('fecha_fin', '', 'post');
		$w = ' AND c.fecha_emision <= "'.$fecha_fin.'" AND c.fecha_emision >= "'.$fecha_ini.'"';
		}else{
		$mes = JRequest::getVar('mes', '', 'post');
		$anio = JRequest::getVar('anio', '', 'post');
		$w = ' AND c.fecha_emision LIKE "'.$anio.'-'.$mes.'-%"';
		}
		
	$where = ' WHERE c.id_comprobante = "0"';
	if(JRequest::getVar('filtro', '', 'post') != '')
		$where.= ' AND c.'.JRequest::getVar('campo', '', 'post').' LIKE "%'.JRequest::getVar('filtro', '', 'post').'%"';
	if($fecha_ini != '' || $mes != '')
		$where.= $w;
	
	if($p == 1){
		$select = ', p.name AS servicio';
		$join = 'LEFT JOIN #__erp_producto_items AS p ON c.id_producto = p.id';
		$where.= ' AND c.id_producto != "0"';
		}
	
	$query = 'SELECT c.*, u.name '.$select.'
	FROM #__erp_facturacion_compras AS c 
	LEFT JOIN #__users AS u ON c.id_usuario = u.id
	'.$join.'
	'.$where.' 
	ORDER BY c.fecha_emision ASC';
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}
function getCompra($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_compras WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$compra = $db->loadObject();
	return $compra;
	}
function importCompra(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	if($_FILES['libro']['name'] != ''){
		$e = explode('.', $_FILES['libro']['name']);
		$ext = array_pop($e);
		if($ext == 'txt' || $ext == 'TXT'){
			copy($_FILES['libro']['tmp_name'], 'media/com_erp/libro.txt');
			
			$fp = fopen ('media/com_erp/libro.txt', 'r');
			$i = 0;
			while ($data = fgetcsv ($fp, 1000, "|")) {
				if(count($data) != 16){
					$val = 3; // No es un archivo TXT
					}
				else{
					if($data[1] != ''){
						
					$query = 'SELECT COUNT(id) FROM #__erp_facturacion_compras WHERE nit = "'.$data[3].'" AND numero = "'.$data[5].'" AND autorizacion = "'.$data[7].'"';
					$db->setQuery($query);  
					$c = $db->loadResult();
					
					if($c == 0){
						
						$query = 'SELECT COUNT(id) FROM #__erp_facturacion_compras_empresa WHERE nit = "'.$data[3].'"';
						$db->setQuery($query);  
						$e = $db->loadResult();
							
						if($e == 1)
							$query = 'SELECT * FROM #__erp_facturacion_compras_empresa WHERE nit = "'.$data[3].'"';
							else{
							$query = 'INSERT INTO #__erp_facturacion_compras_empresa(`empresa`, `nit`) VALUES(';
							$query.= '"'.filtroCadena($data[4]).'"';
							$query.= ', "'.$data[3].'"';
							$query.= ')';
							$db->setQuery($query);
							$db->query();
							$query = 'SELECT * FROM #__erp_facturacion_compras_empresa ORDER BY id DESC LIMIT 1';
							}
						$db->setQuery($query);
						$empresa = $db->loadObject();
							
						$query = 'INSERT INTO #__erp_facturacion_compras(`id_usuario`, `id_empresa`, `numero`, `autorizacion`, `empresa`, `nit`, `fecha_emision`, `codigo`, `total`, `fecha`, `hora`, `nocredito`, `descuento`, `dui`, `tipo`) VALUES(';
						$query.= '"'.$user->get('id').'"';
						$query.= ', "'.$empresa->id.'"';
						$query.= ', "'.$data[5].'"';
						$query.= ', "'.$data[7].'"';
						$query.= ', "'.filtroCadena($empresa->empresa).'"';
						$query.= ', "'.$data[3].'"';
						$query.= ', "'.fecha2($data[2]).'"';
						$query.= ', "'.$data[14].'"';
						$query.= ', "'.$data[8].'"';
						$query.= ', NOW()';
						$query.= ', NOW()';
						$query.= ', "'.$data[9].'"';
						$query.= ', "'.$data[11].'"';
						$query.= ', "'.$data[6].'"';
						$query.= ', "'.$data[15].'"';
						$query.= ')';
						$db->setQuery($query);
						$db->query();
							}else{
							$facturas.= $data[3].'|'.$data[5].'|'.$data[7].':';
							}
					    }
				    }
			    }
			fclose ($fp);
			$val = $facturas;
			}else
			$val = 2; // No es un archivo TXT
		}else
		$val = 1; // No se subio el archivo
	return $val;
    newAccion('Importó Compra');
	}

// Tipos de Factura
function getTipoFacturas(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_factura ORDER BY id';
	$db->setQuery($query);  
	$tipos = $db->loadObjectList();
	return $tipos;
	}
function getTipoFactura($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_factura WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$tipo = $db->loadObject();
	return $tipo;
	}
function countTipoFactura(){
	$db =& JFactory::getDBO();
	$id_sucursal = getIdSucursalUsuario();
	$query = 'SELECT COUNT(id) AS cant FROM #__erp_facturacion_factura';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function deleteTipoFactura(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_facturacion_factura WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function newTipoFactura(){
	$db =& JFactory::getDBO();
	$query = 'INSERT INTO #__erp_facturacion_factura(`id_template`, `factura`, `sigla`, `pie`) VALUES(';
	$query.= '"'.JRequest::getVar('id_template', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('factura', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('codigo', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('pie', '', 'post').'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT id FROM #__erp_facturacion_factura ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id_factura = $db->loadResult();
	
	$cant = count($_POST['actividades']);
	//for($i=0; $i<$cant; $i++){
	foreach($_POST['act'] as $act){
		$query = 'INSERT INTO #__erp_rel_tipo_actividad(`id_factura`, `id_rubro`) VALUES(';
		$query.= '"'.$id_factura.'"';
		$query.= ', "'.$act.'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
    newAccion('Creó Tipo de factura');
	}
function editTipoFactura(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_facturacion_factura SET ';
	$query.= '`id_template` = "'.JRequest::getVar('id_template', '', 'post').'"';
	$query.= ', `factura` = "'.JRequest::getVar('factura', '', 'post').'"';
	$query.= ', `sigla` = "'.JRequest::getVar('codigo', '', 'post').'"';
	$query.= ', `pie` = "'.JRequest::getVar('pie', '', 'post').'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	
	$id_factura = JRequest::getVar('id', '', 'get');
	$cant = count($_POST['actividades']);
	
	$query = 'DELETE FROM #__erp_rel_tipo_actividad WHERE id_factura = "'.$id_factura.'"';
	$db->setQuery($query);
	$db->query();
	
	foreach($_POST['act'] as $act){
		$query = 'INSERT INTO #__erp_rel_tipo_actividad(`id_factura`, `id_rubro`) VALUES(';
		$query.= '"'.$id_factura.'"';
		$query.= ', "'.$act.'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
    newAccion('editó tipo de Factura');
	}
function verifyTipoFactura($id_rubro){
	$db =& JFactory::getDBO();
	$id_factura = JRequest::getVar('id', '', 'get');
	$query = 'SELECT id_factura FROM #__erp_rel_tipo_actividad WHERE id_factura = "'.$id_factura.'" AND id_rubro = "'.$id_rubro.'"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	if($id != '')
		$val = 1;
		else
		$val = 0;
	return $val;
	}

function getPlantillaEspecial($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT id_template FROM #__erp_facturacion_factura WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$id_plantilla = $db->loadResult();
	
	$query = 'SELECT plantilla FROM #__erp_plantilla WHERE id = "'.$id_plantilla.'"';
	$db->setQuery($query);  
	$plantilla = $db->loadResult();
	return $plantilla;
	}

function newFacturaManual(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	$user =& JFactory::getUser();
	
	$sucursal = getSucursalUsuario();
	$duplicado = array();
	$n = 0;
	
	for($i=0; $i<count($_POST['empresa']); $i++){
		$empresa = filtroCadena($_POST['empresa'][$i]);
		if(getFacturaManual($_POST['autorizacion'][$i], $_POST['numero'][$i], $_POST['nit'][$i]) == 0){
			$query = 'INSERT INTO #__erp_facturacion_manual(`id_tipo`, `id_sucursal`, `id_usuario`, `nombre`, `nit`, `numero`, `autorizacion`, `fecha`, `total`, `estado`) VALUES(';
			$query.= '"'.$_POST['id_tipo'][$i].'"';
			$query.= ', "'.$sucursal->id.'"';
			$query.= ', "'.$user->get('id').'"';
			$query.= ', "'.$empresa.'"';
			$query.= ', "'.$_POST['nit'][$i].'"';
			$query.= ', "'.$_POST['numero'][$i].'"';
			$query.= ', "'.$_POST['autorizacion'][$i].'"';
			$query.= ', "'.$_POST['fecha'][$i].'"';
			$query.= ', "'.$_POST['total'][$i].'"';
			$query.= ', "'.$_POST['estado'][$i].'"';
			$query.= ')';
			$db->setQuery($query);
			$db->query();
			}else{
			$duplicado[$n] = $empresa.'||'.$_POST['nit'][$i].'||'.$_POST['numero'][$i];
			$n++;
			}
	    newAccion('Generó Facura Manual: '.$_POST['numero'][$i]);
		}
	$session->set('duplicado', $duplicado);
	}
function getFacturasManual(){
	$db =& JFactory::getDBO();
	
	$fecha_ini = JRequest::getVar('fecha_ini', '', 'post');
	$fecha_fin = JRequest::getVar('fecha_fin', '', 'post');
	$where = ' WHERE 1';
	if(JRequest::getVar('filtro', '', 'post') != '')
		$where.= ' AND '.JRequest::getVar('campo', '', 'post').' LIKE "%'.JRequest::getVar('filtro', '', 'post').'%"';
	if($fecha_ini != '')
		$where.= ' AND f.fecha >= "'.$fecha_ini.'" AND f.fecha <= "'.$fecha_fin.'"';
	if(JRequest::getVar('sucursal', '', 'post') != '')
		$where.= ' AND f.id_sucursal = "'.JRequest::getVar('sucursal', '', 'post').'"';
	if(JRequest::getVar('tipo', '', 'post') != '')
		$where.= ' AND f.id_tipo = "'.JRequest::getVar('tipo', '', 'post').'"';
	if(JRequest::getVar('estado', '', 'post') != '')
		$where.= ' AND f.estado = "'.JRequest::getVar('estado', '', 'post').'"';
	if(JRequest::getVar('usuario', '', 'post') != '')
		$where.= ' AND f.id_usuario = "'.JRequest::getVar('usuario', '', 'post').'"';
	
	$query = 'SELECT f.*, s.codigo AS sucursal_codigo, ff.factura AS tipo_factura, ff.sigla AS tipo_factura_sigla 
	FROM #__erp_facturacion_manual AS f 
	LEFT JOIN #__erp_sucursales AS s ON f.id_sucursal = s.id 
	LEFT JOIN #__erp_facturacion_factura AS ff ON f.id_tipo = ff.id 
	'.$where.' 
	ORDER BY f.fecha, f.numero DESC';
	$db->setQuery($query);  
	$facturas = $db->loadObjectList();
	return $facturas;
	}
function getFacturaManual($auth, $numero, $nit){
	$db =& JFactory::getDBO();
	$query = 'SELECT id FROM #__erp_facturacion_manual WHERE autorizacion = "'.$auth.'" AND numero = "'.$numero.'" AND nit = "'.$nit.'"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	if($id != '')
		$val = 1;
		else
		$val = 0;
	return $val;
	}
function getFacturaManualC($id = 0){
	$db =& JFactory::getDBO();
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT * FROM #__erp_facturacion_manual WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$factura = $db->loadObject();
	return $factura;
	}
function editFacturaManual(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
	$empresa = JRequest::getVar('empresa', '', 'post');
	$query = 'UPDATE #__erp_facturacion_manual SET ';
	$query.= '`id_tipo` = "'.JRequest::getVar('id_tipo', '', 'post').'"';
	$query.= ', `nombre` = "'.$empresa.'"';
	$query.= ', `nit` = "'.JRequest::getVar('nit', '', 'post').'"';
	$query.= ', `numero` = "'.JRequest::getVar('numero', '', 'post').'"';
	$query.= ', `autorizacion` = "'.JRequest::getVar('autorizacion', '', 'post').'"';
	$query.= ', `fecha` = "'.JRequest::getVar('fecha', '', 'post').'"';
	$query.= ', `total` = "'.JRequest::getVar('total', '', 'post').'"';
	$query.= ', `estado` = "'.JRequest::getVar('estado', '', 'post').'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó Facura Manual: '.JRequest::getVar('numero', '', 'post'));
	}
function deleteFacturaManual(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
	$query = 'DELETE FROM #__erp_facturacion_manual WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function revierteFactura(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id', '', 'get');
	$query = 'UPDATE #__erp_facturacion_cabecera SET impreso = "0" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// Formas de pago
function getFormasPago(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_facturacion_formapago WHERE eliminado = "0" ORDER BY forma';
	$db->setQuery($query);  
	$formas = $db->loadObjectList();
	return $formas;
	}
function getFormaPago($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_formapago WHERE id = "'.$id.'"';
	
	$db->setQuery($query);  
	$forma = $db->loadObject();
	return $forma;
	}
function newFormaPago(){
	$db =& JFactory::getDBO();
	
	$forma = JRequest::getVar('forma', '', 'post');
	$figura = JRequest::getVar('simbolo', '', 'post');
	
	$query = 'INSERT INTO #__erp_facturacion_formapago(`forma`,`figura`) VALUES("'.$forma.'","'.$figura.'")';
	$db->setQuery($query);
	$db->query();
    newAccion('Creó Nueva Forma de Pago');
	}
function editFormaPago(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$forma = JRequest::getVar('forma', '', 'post');
    $figura = JRequest::getVar('simbolo', '', 'post');
	
	$query = 'UPDATE #__erp_facturacion_formapago `forma` = "'.$forma.'", `figura` = "'.$figura.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó Forma de Pago'. $forma);
	}
function deleteFormaPago(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_facturacion_formapago SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Eliminó Forma de Pago');
	}

// Aportes
function getAportesCliente(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_aportes_mes WHERE id_cliente = "'.$id.'" ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$aporte = $db->loadObject();
	return $aporte;
	}

// Aportes por categoria
// Cargo Personal
function getCategoriaAporte($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT monto FROM #__erp_clientes_categoria_aportes WHERE id_categoria = "'.$id.'" ORDER BY fecha DESC LIMIT 1';
	$db->setQuery($query);  
	$monto = $db->loadResult();
	return $monto;
	}
function newCategoriaAporte(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id_categoria', '', 'post');
	$monto = JRequest::getVar('monto', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_categoria_aportes(`id_categoria`, `monto`, `fecha`) VALUES(';
	$query.= '"'.$id.'"';
	$query.= ', "'.$monto.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
    newAccion('Creó Nueva categoria de Aportes');
	}
function editCategoriaAporte(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id_categoria', '', 'post');
	$monto = JRequest::getVar('monto', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_categoria_aportes SET ';
	$query.= '`monto` = "'.$monto.'"';
	$query.= ', `fecha` = NOW()';
	$query.= ' WHERE id = '.$id;
    //echo $query;
	$db->setQuery($query);
	$db->query();
    newAccion('Editó Categoría de Aporte');
	}

// APORTES
function getSociadoAportesA(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT anio FROM #__erp_aportes_mes WHERE id_cliente = "'.$id.'" GROUP BY anio';
	$db->setQuery($query);  
	$anios = $db->loadObjectList();
	return $anios;
	}
/*function getSociadoAportesM($anio){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT mes, monto FROM #__erp_aportes_mes WHERE anio = "'.$anio.'" AND id_cliente = "'.$id.'" ORDER BY mes, id';//AND estado = "V"
	//echo $query;
    $db->setQuery($query);  
	$mes = $db->loadObjectList();
	return $mes;
	}*/
function getSociadoAportesM($anio){
    $db =& JFactory::getDBO();

    $id = JRequest::getVar('id', '', 'get');

    $query = 'SELECT mes, SUM(monto) AS monto FROM #__erp_aportes_mes WHERE anio = "'.$anio.'" AND id_cliente = "'.$id.'" GROUP BY mes ORDER BY mes, id'; //AND estado = "V"
    //echo $query;
    $db->setQuery($query);  
    $mes = $db->loadObjectList();
    return $mes;
}

// Formas de pago
function getFACformas(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_facturacion_formapago WHERE eliminado = "0" ORDER BY forma';
	$db->setQuery($query);  
	$formas = $db->loadObjectList();
	return $formas;
	}
function getFACforma($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_facturacion_formapago WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$forma = $db->loadObject();
	return $forma;
	}
function newFACforma(){
	$db =& JFactory::getDBO();
	
	$forma = JRequest::getVar('forma', '', 'post');
	
	$query = 'INSERT INTO #__erp_facturacion_formapago(`forma`) VALUES("'.$forma.'")';
	$db->setQuery($query);
	$db->query();
	}
function editFACforma(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$forma = JRequest::getVar('forma', '', 'post');
	
	$query = 'UPDATE #__erp_facturacion_formapago SET `forma` = "'.$forma.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteFACforma(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_facturacion_formapago SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
// Tipos de cobranza
function getFACcobranzas(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_clientes_modoenvio WHERE eliminado = "0" ORDER BY modo_envio';
	$db->setQuery($query);  
	$modos = $db->loadObjectList();
	return $modos;
	}
function getFACcobranza($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_modoenvio WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$modo = $db->loadObject();
	return $modo;
	}
function newFACcobranza(){
	$db =& JFactory::getDBO();
	
	$modo_envio = JRequest::getVar('modo_envio', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_modoenvio(`modo_envio`) VALUES("'.$modo_envio.'")';
	$db->setQuery($query);
	$db->query();
	}
function editFACcobranza(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$modo_envio = JRequest::getVar('modo_envio', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_modoenvio SET `modo_envio` = "'.$modo_envio.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteFACcobranza(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_modoenvio SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// APORTES
function newAporte($id_factura){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$fact = getFactura($id_factura);
	
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	$mes_ini = JRequest::getVar('mes_ini', '', 'post');
	$anio_ini = JRequest::getVar('anio_ini', '', 'post');
	$mes_fin = JRequest::getVar('mes_fin', '', 'post');
	$anio_fin = JRequest::getVar('anio_fin', '', 'post');
	$precio = JRequest::getVar('precio_0', '', 'post');
	$subtotal = JRequest::getVar('subtotal_0', '', 'post');
	
	if($mes_fin == 'NaN'){
		$mes_fin = $mes_ini;
		$anio_fin = $anio_ini;
		}
	
	$cant = (($anio_fin - $anio_ini) - ($mes_ini - 1)) + $mes_fin;
	
	$query = 'INSERT INTO #__erp_aportes_pagos(`id_cliente`, `id_factura`, `id_usuario`, `fecha`, `cant_aportes`, `monto`) VALUES(';
	$query.= '"'.$id_cliente.'"';
	$query.= ', "'.$fact->id.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', NOW()';
	$query.= ', "'.$cant.'"';
	$query.= ', "'.$subtotal.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);
	$id_pago = $db->loadResult();
	
	$query = 'SELECT id_categoria FROM #__erp_clientes_info WHERE id_cliente = "'.$fact->id_persona.'" AND activo = "1"';
	$db->setQuery($query);
	$id_categoria = $db->loadResult();
	
	$aporte = getCategoriaAporte($id_categoria);
	
	for($i=$anio_ini; $i<=$anio_fin; $i++){
		if($anio_fin == $anio_ini){
			$ini = $mes_ini;
			$fin = $mes_fin;
			}
		elseif($i == $anio_ini){
			$ini = $mes_ini;
			$fin = 12;
			}
		elseif($i == $anio_fin){
			$ini = 1;
			$fin = $mes_fin;
			}
		else{
			$ini = 1;
			$fin = 12;
			}
						
		for($j=$ini; $j<=$fin; $j++){
			$query = 'INSERT INTO #__erp_aportes_mes(`id_cliente`, `id_pago`, `monto`, `mes`, `anio`, `estado`) VALUES(';
			$query.= '"'.$id_cliente.'"';
			$query.= ', "'.$id_pago.'"';
			$query.= ', "'.$precio.'"';
			$query.= ', "'.$j.'"';
			$query.= ', "'.$i.'"';
			$query.= ', "V"';
			$query.= ')';
			$db->setQuery($query);
			$db->query();
			
			$query = 'UPDATE #__erp_aportes_deuda SET pagado = 1 WHERE id_cliente = "'.$id_cliente.'" AND mes= "'.$j.'" AND anio = "'.$i.'"';
			$db->setQuery($query);
			$db->query();
			}
		}
	}

function changeAporteCta(){
	$db =& JFactory::getDBO();
	
	$id_cta = JRequest::getVar('cuenta_debe_id', '', 'post');
	
	$query = 'UPDATE #__erp_facturacion_aporte SET id_cta = "'.$id_cta.'" WHERE 1';
	$db->setQuery($query);
	$db->query();
	}
function getAporteCta(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.id, c.nombre 
	FROM #__erp_facturacion_aporte AS a
	LEFT JOIN #__erp_conta_cuentas AS c ON a.id_cta = c.id
	WHERE a.id = "1"';
	$db->setQuery($query);
	$ap = $db->loadObject();
	return $ap;
	}
function editAporteCta(){
	$db =& JFactory::getDBO();
	
	$id_cta = JRequest::getVar('id_cta', '', 'post');
	
	$query = 'UPDATE #__erp_facturacion_aporte SET id_cta = "'.$id_cta.'" WHERE id = 1';
	$db->setQuery($query);
	$db->query();
	}
function getAsociadosDebito($id_masiva){
    $db =& JFactory::getDBO();
    $cant= 20;
    $pag  = JRequest::getVar('p', '1', 'get');
    $page = $pag - 1;
    $limit = ' LIMIT '.(($page) * $cant).','.$cant;
    $query = 'SELECT * FROM cgn_erp_facturacion_notadebito WHERE id_facturacion_masiva = '.$id_masiva.$limit;
    //echo $query;
    $db->setQuery($query);
    $lista = $db->loadObjectList();
    return $lista;
}
function getAsociadosDebitoPag($id_masiva){
    $db =& JFactory::getDBO();
    
    $query = 'SELECT COUNT(*) FROM cgn_erp_facturacion_notadebito WHERE id_facturacion_masiva = '.$id_masiva;

    $db->setQuery($query);
    $lista = $db->loadResult();
    return $lista;
}
function newGeneraDeuda($mes, $anio, $id){
    $db =& JFactory::getDBO();

    $query = 'INSERT INTO cgn_erp_facturacion_notadebito(id_facturacion_masiva, id_cliente, id_categoria, empresa, direccion, zona, ciudad, monto, mes, anio)
    SELECT '.$id.', c.id, i.id_categoria, i.empresa, i.direccion, i.zona, i.ciudad, 
    (SELECT SUM(monto) FROM cgn_erp_aportes_deuda WHERE id_cliente = c.id AND pagado = 0), '.$mes.', '.$anio.'
    FROM cgn_erp_clientes AS c, cgn_erp_clientes_info AS i, cgn_erp_clientes_categoria AS cat, cgn_erp_clientes_rel_estado AS rce, cgn_erp_clientes_estado AS e
    WHERE i.id_cliente = c.id AND i.id_categoria = cat.id AND c.id = rce.id_cliente AND rce.id_estado = e.id
    AND c.masiva = "0" AND i.activo = "1" AND rce.activo = "1" AND rce.id_estado = 1 AND c.registro != ""
    AND NOT EXISTS(SELECT 1 FROM cgn_erp_aportes_mes WHERE id_cliente = c.id AND mes = "'.$mes.'" AND anio = "'.$anio.'")';
    //echo $query;
    $db->setQuery($query);
    $db->query();
    $query = 'UPDATE cgn_erp_facturacion_masiva SET deuda_generada = 1 WHERE id = "'.$id.'"';

    $db->setQuery($query);
    $db->query();
    newAccion('Generó Notas al Débito');
}

	
// Campos para impresión
function getFacturaCampos($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT p.*, c.campo 
	FROM #__erp_facturacion_impreso_posicion AS p
	LEFT JOIN #__erp_facturacion_impreso_campos AS c ON p.id_campo = c.id
	WHERE p.id_sucursal = "'.$id.'"';
	$db->setQuery($query);
	$lista = $db->loadObjectList();
	
	return $lista;
	}
function getFacturaCampo($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_facturacion_impreso_posicion WHERE id_campo = "'.$id.'"';
	$db->setQuery($query);
	$campo = $db->loadObject();
	
	return $campo;
	}
function editFacturaCampo(){
	$db =& JFactory::getDBO();
    
	$id_sucursal = JRequest::getVar('id_sucursal','','post');
	$id_campo = JRequest::getVar('id', '', 'post');
	$pos_x = JRequest::getVar('pos_x', '', 'post');
	$pos_y = JRequest::getVar('pos_y', '', 'post');
    $tam_fuente = JRequest::getVar('tam_fuente', '', 'post');
	$ancho = JRequest::getVar('ancho', '', 'post');
    $visible = JRequest::getVar('visible', '', 'post');
	
	$query = 'UPDATE #__erp_facturacion_impreso_posicion SET 
	pos_x = "'.$pos_x.'",
	pos_y = "'.$pos_y.'",
    tam_fuente = "'.$tam_fuente.'",
	ancho = "'.$ancho.'",
    visible = "'.$visible.'"
	WHERE id_campo = "'.$id_campo.'" AND id_sucursal = "'.$id_sucursal.'"';
	$db->setQuery($query);
	$db->query();
	}

function editDatosPreaviso(){
    $db =& JFactory::getDBO();
    $funcionario = JRequest::getVar('funcionario','','post');
    $telefono = JRequest::getVar('telefono','','post');
    $interno = JRequest::getVar('interno','','post');
    $id = JRequest::getVar('id','','post');
    $query = 'UPDATE #__erp_facturacion_datos_fm ';
    $query .= 'SET `funcionario`= "'.$funcionario.',`telefono`= "'.$telefono.',`int`= "'.$interno.'" WHERE id= "'.$id.'"';
    $db->setQuery($query);
	$db->query();
}

function getEstadodeCuentas(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $desde = JRequest::getVar('desde',JRequest::getVar('desde','','get'),'post');
    $hasta = JRequest::getVar('hasta',JRequest::getVar('hasta','','get'),'post');
    $where = '';
    if($desde != ''){
        $where .= ' AND f_pago >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where .= ' AND f_pago <= "'.fecha2($hasta).'"';
    }
    $query = 'SELECT d.pagado, d.id_cuota, d.f_pago, d.detalle, d.anio, d.referencia AS ref, d.tipo, p.monto AS ingreso, pd.monto AS debito
    FROM #__erp_aportes_deuda AS d
    LEFT JOIN #__erp_aportes_pagos AS p ON d.id_cuota = p.id_cuota
    LEFT JOIN #__erp_aportes_pagos_deuda AS pd ON d.id_portes_pagos_deuda = pd.id
    WHERE d.id_cliente = "'.$id.'" '.$where.'
    GROUP BY id_cuota';
    /*echo $query;*/
    $db->setQuery($query);
	$cuentas = $db->loadObjectList();
    return $cuentas;
}
function getEstadoDeuda(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $desde = JRequest::getVar('desde',JRequest::getVar('desde','','get'),'post');
    $hasta = JRequest::getVar('hasta',JRequest::getVar('hasta','','get'),'post');
    $where = '';
    if($desde != ''){
        $where .= ' AND fecha_pago >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where .= ' AND fecha_pago <= "'.fecha2($hasta).'"';
    }
    $query = 'SELECT * FROM #__erp_aportes_pagos_deuda WHERE id_cliente = "'.$id.'" '.$where.'';
    
    
    //echo $query;
    $db->setQuery($query);
	$mon = $db->loadObjectList();
    return $mon;
}

function getEstadoD(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $desde = JRequest::getVar('desde',JRequest::getVar('desde','','get'),'post');
    $hasta = JRequest::getVar('hasta',JRequest::getVar('hasta','','get'),'post');
    $where = '';
    if($desde != ''){
        $where .= ' AND f_pago >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where .= ' AND f_pago <= "'.fecha2($hasta).'"';
    }
    $query = 'SELECT * FROM #__erp_aportes_deuda WHERE id_cliente = "'.$id.'" '.$where.' AND pagado = 0';
    
    
   
    $db->setQuery($query);
	$mon = $db->loadObjectList();
    return $mon;
}
function getEstadoCancelado(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id');
    $desde = JRequest::getVar('desde',JRequest::getVar('desde','','get'),'post');
    $hasta = JRequest::getVar('hasta',JRequest::getVar('hasta','','get'),'post');
    $where = '';
    if($desde != ''){
        $where .= ' AND fecha >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where .= ' AND fecha <= "'.fecha2($hasta).'"';
    }
    $query = 'SELECT * FROM #__erp_aportes_pagos WHERE id_cliente = "'.$id.'" '.$where.'';
    
    
    //echo $query;
    $db->setQuery($query);
	$cancelado = $db->loadObjectList();
    return $cancelado;
}
?>