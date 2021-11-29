<?
// Prospectos

function changeProspectoEstado(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$razon = JRequest::getVar('motivo', '', 'post');
    echo $estado;
	if($estado == 1)
		$cliente = 1;
		else
		$cliente = 0;
	
	$query = 'UPDATE #__erp_crm_negocio SET estado = "'.$estado.'", razon = "'.$razon.'", fecha_final = NOW(), activo = "0" WHERE id_prospecto = "'.$id.'" AND activo = "1"';
	$db->setQuery($query);  
	$db->query();
	/*echo '</br>';
    echo $query;*/
	$query = 'UPDATE #__erp_crm_prospecto SET cliente = "'.$cliente.'", estado = "'.$estado.'", fecha_cierre = NOW() WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	/*echo '</br>';
    echo $query;*/
	$query = 'UPDATE #__erp_crm_etapa SET activo = "0" WHERE id_prospecto = "'.$id.'"';
   /* echo '</br>';
    echo $query;*/
	$db->setQuery($query);  
	$db->query();
	return $id;
    newAccion('Cambio de estado al prospecto CRM '.$cliente);

	}
function changeProspectoE(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_prospecto = JRequest::getVar('id_prospecto', '', 'post');
	$etapa = JRequest::getVar('etapa', '', 'post');
	
	$query = 'UPDATE #__erp_crm_etapa SET activo = "0" WHERE id_prospecto = "'.$id_prospecto.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_crm_etapa(`id_usuario`, `id_prospecto`, `etapa`, `fecha`, `activo`) VALUES(';
	$query.= '"'.$user->get('id').'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$etapa.'"';
	$query.= ', NOW()';
	$query.= ', "1"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();    
	}
function changeProspectoA(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$id_asignado = JRequest::getVar('id_asignado', '', 'post');
	
	$query = 'UPDATE #__erp_crm_prospecto SET id_asignado = "'.$id_asignado.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function newCRMProspecto(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	//echo JRequest::getVar('asignada', '', 'post').'<br>';
	$id_usuario = $user->get('id');
	$id_segmento = JRequest::getVar('id_segmento', '', 'post');
	$id_asignado = JRequest::getVar('asignada', '', 'post');
	$id_origen = JRequest::getVar('id_neg', '', 'post');
	$origen = JRequest::getVar('origen', '', 'post');
	$empresa = JRequest::getVar('org', '', 'post');
	$fono_empresa = JRequest::getVar('tel_org', '', 'post');
	$contacto_nombre = JRequest::getVar('nombre', '', 'post');
	$contacto_apellido = JRequest::getVar('apellido', '', 'post');
	$telefono = JRequest::getVar('tel_c', '', 'post');
	$celular = JRequest::getVar('cel_c', '', 'post');
	$direccion = JRequest::getVar('dir_org', '', 'post');
	$monto = JRequest::getVar('valor_negocio', '', 'post');
	$fecha_cierre = fecha2(JRequest::getVar('fecha', '', 'post'));
	$email = JRequest::getVar('email', '', 'post');
	
	if($origen == 'c'){
		$id_prospecto = $id_origen;
		}else{
		
		$query = 'SELECT id FROM #__erp_crm_prospecto WHERE id_origen = "'.$id_origen.'" AND origen = "a"';
		$db->setQuery($query);
		$id_prospecto = $db->loadResult();
		if($id_prospecto == ''){
			
            $query = 'INSERT INTO #__erp_crm_prospecto(
			`id_usuario`, `id_segmento`, `id_origen`, `id_asignado`, `origen`, `empresa`, `fono_empresa`, `direccion`, 
			 `fecha_registro`
			) VALUES(';			
			$query.= '"'.$id_usuario.'"';
			$query.= ', "'.$id_segmento.'"';
			$query.= ', "'.$id_origen.'"';
			$query.= ', "'.$id_asignado.'"';
			$query.= ', "'.$origen.'"';
			$query.= ', "'.$empresa.'"';
			$query.= ', "'.$fono_empresa.'"';
			
			$query.= ', "'.$direccion.'"';
			$query.= ', NOW()';
			$query.= ')';
			//echo $query;
			$db->setQuery($query);  
			$db->query();
			
			$query = 'SELECT LAST_INSERT_ID()';
			$db->setQuery($query);
			$id_prospecto = $db->loadResult();
            
            //insertando nuevos contactos de CRM
            $query = 'INSERT INTO #__erp_crm_contacto_prospecto(
            `id_prospecto`, `nombre`, `apellido`, `telefono`, `celular`, `correo`, `cargo` 
            ) VALUES';
            $ccontact = JRequest::getVar('c_contact','','post');
            $c=0;
            while($ccontact>=$c){
                if($c>0){
                    $query.=',';
                }
                $query.= '( "'.$id_prospecto.'"';
                $query.= ', "'.JRequest::getVar('nombre_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('apellido_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('tel_c_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('cel_c_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('email_'.$c, '', 'post').'"';                
                $query.= ', "'.JRequest::getVar('cargo_'.$c, '', 'post').'"';                
                $c++;
                $query.= ')';
            }
            //echo $query;
            $db->setQuery($query);  
            $db->query();
			}
		}
	
	$query = 'UPDATE #__erp_crm_negocio SET activo = "0" WHERE id_prospecto = "'.$id_prospecto.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_crm_negocio(`id_prospecto`, `id_usuario`, `id_asignado`, `monto`, `fecha_registro`, `fecha_cierre`, `activo`) VALUES(';
	$query.= '"'.$id_prospecto.'"';
	$query.= ', "'.$id_usuario.'"';
	$query.= ', "'.$id_asignado.'"';
	$query.= ', "'.$monto.'"';
	$query.= ', NOW()';
	$query.= ', "'.$fecha_cierre.'"';
	$query.= ', "1"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);
	$id_negocio = $db->loadResult();
	
	$etapa = JRequest::getVar('etapa', '', 'post');
	
	$query = 'INSERT INTO #__erp_crm_etapa(`id_usuario`, `id_prospecto`, `id_negocio`, `etapa`, `fecha`, `activo`) VALUES(';
	$query.= '"'.$id_asignado.'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$id_negocio.'"';
	$query.= ', "'.$etapa.'"';
	$query.= ', NOW()';
	$query.= ', "1"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	//echo count($_POST['interes']);
	for($i=0; $i<count($_POST['interes']); $i++){
		$query = 'INSERT INTO #__erp_crm_interes(`id_prospecto`, `id_interes`, `id_negocio`) VALUES("'.$id_prospecto.'", "'.$_POST['interes'][$i].'", "'.$id_negocio.'")';
		$db->setQuery($query);  
		$db->query();
		}
	
	return $id_prospecto;
    newAccion('Creo Prospecto CRM '.$empresa);
	}
function getCRMContactosProspecto($id){
    $db =& JFactory::getDBO();
    $query = 'SELECT *';
    $query .= ' FROM #__erp_crm_contacto_prospecto';
    $query .= ' WHERE id_prospecto = "'.$id.'"';
    $db->setQuery($query);  
	$contactos = $db->loadObjectList();
    return $contactos;
}
function deleteCRMContactoProspecto($id){
    $db =& JFactory::getDBO();
    $query = 'DELETE FROM #__erp_crm_contacto_prospecto WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
}
function editCRMProspecto(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	//echo JRequest::getVar('valor_negocio', '', 'post').'<br>';
	//echo JRequest::getVar('fecha', '', 'post').'<br>';
	
	$id = JRequest::getVar('id', '', 'post');
	$id_segmento = JRequest::getVar('id_segmento', '', 'post');
	$id_asignado = JRequest::getVar('asignada', '', 'post');
	$empresa = JRequest::getVar('org', '', 'post');
	$fono_empresa = JRequest::getVar('tel_org', '', 'post');	
	$direccion = JRequest::getVar('dir_org', '', 'post');
	$monto = JRequest::getVar('valor_negocio', '', 'post');
	$fecha_cierre = fecha2(JRequest::getVar('fecha', '', 'post'));
	
	$query = 'UPDATE #__erp_crm_prospecto SET ';
	$query.= '`empresa` = "'.$empresa.'"';
	$query.= ', `id_segmento` = "'.$id_segmento.'"';
	$query.= ', `fono_empresa` = "'.$fono_empresa.'"';
	$query.= ', `direccion` = "'.$direccion.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    
    //actualizando contacto CRM
    $ccontact = JRequest::getVar('c_contact','','post');
    $c=0;
    while($ccontact>=$c){
        if(JRequest::getVar('id_contacto_'.$c, '', 'post')!=0){
            $query = 'UPDATE #__erp_crm_contacto_prospecto SET ';
            $query.= ' `nombre` = "'.JRequest::getVar('nombre_'.$c, '', 'post').'"';
            $query.= ', `apellido` = "'.JRequest::getVar('apellido_'.$c, '', 'post').'"';
            $query.= ', `celular` = "'.JRequest::getVar('tel_c_'.$c, '', 'post').'"';
            $query.= ', `telefono` = "'.JRequest::getVar('cel_c_'.$c, '', 'post').'"';
            $query.= ', `correo` = "'.JRequest::getVar('email_'.$c, '', 'post').'"';
            $query.= ', `cargo` = "'.JRequest::getVar('cargo_'.$c, '', 'post').'"';
            $query.= ' WHERE id = "'.JRequest::getVar('id_contacto_'.$c, '', 'post').'"';
            $db->setQuery($query);  
            $db->query();            
        }else{
            $query = 'INSERT INTO #__erp_crm_contacto_prospecto(
            `id_prospecto`, `nombre`, `apellido`, `telefono`, `celular`, `correo`, `cargo` 
            ) VALUES';
                $query.= '( "'.$id.'"';
                $query.= ', "'.JRequest::getVar('nombre_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('apellido_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('tel_c_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('cel_c_'.$c, '', 'post').'"';
                $query.= ', "'.JRequest::getVar('email_'.$c, '', 'post').'"';                
                $query.= ', "'.JRequest::getVar('cargo_'.$c, '', 'post').'"';                
                $query.= ')';
            //echo $query;
            $db->setQuery($query);  
            $db->query();
        }
        $c++;
    }
	
	$query = 'UPDATE #__erp_crm_negocio SET ';
	$query.= '`id_asignado` = "'.$id_asignado.'"';
	$query.= ', `monto` = "'.$monto.'"';
	$query.= ', `fecha_cierre` = "'.$fecha_cierre.'"';
	$query.= ' WHERE id_prospecto = "'.$id.'" AND activo = "1"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT id FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id.'" AND activo = "1"';
	$db->setQuery($query);
	$id_negocio = $db->loadResult();
	
	$query = 'DELETE FROM #__erp_crm_interes WHERE id_negocio = "'.$id_negocio.'"';
	$db->setQuery($query);  
	$db->query();
	
	for($i=0; $i<count($_POST['interes']); $i++){
		$query = 'INSERT INTO #__erp_crm_interes(`id_prospecto`, `id_interes`, `id_negocio`) VALUES("'.$id.'", "'.$_POST['interes'][$i].'", "'.$id_negocio.'")';
		$db->setQuery($query);  
		$db->query();
		}
	}
function getCRMAsociados(){
	$db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	
	$antiguedad = $session->get('antiguedad');
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
	
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
	 
	$query = 'SELECT c.*, cat.categoria, cat.sigla AS categoria_sigla, i.id AS id_info, i.id_categoria, i.empresa, e.color
	FROM #__erp_clientes AS c 
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON i.id_cliente = rce.id_cliente 
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	LEFT JOIN #__erp_crm_prospecto AS p ON c.id = p.id_origen
	LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto
	WHERE i.activo = "1" AND c.valido = "1" AND (n.estado = "1" OR n.estado = "2" OR p.id_origen IS NULL) '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function getCRMProspectos($etapa = '', $e = 0, $id_usuario = 0, $segmento = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$where = '';
	if($etapa != '')
		$where.= ' AND e.etapa = "'.$etapa.'"';
	if(JRequest::getVar('tmpl')!='component'){
        $activo = ' e.activo = "1"';
    }else{
        $activo = ' 1';
    }
	switch($e){
		case '1':
		$join = 'LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto';
		$where.= ' AND (n.estado = "1" OR n.estado = "2")';
		break;
		case '2':
		$select = ', n.monto AS nmonto, n.id_asignado, n.estado AS nestado, n.fecha_registro AS nfecha_registro, n.fecha_cierre AS nfecha_cierre';
		$join = 'LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto';
		$where.= ' AND n.estado = "0"';
		break;
		}
	
	if($id_usuario != 0){
		$where.= ' AND p.id_asignado = "'.$id_usuario.'"';        
    }
	if(!validaAcceso('CRM Administrador')){
		$where.= ' AND p.id_asignado = "'.$user->get('id').'"';
    }
	if($segmento!=0){
        $where.= ' AND p.id_segmento = "'.$segmento.'"';
    }
	$query = 'SELECT p.*, e.etapa, et.etapa AS nombre_etapa, u.name '.$select.'
	FROM #__erp_crm_prospecto AS p
	LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
	LEFT JOIN #__erp_crm_etapas AS et ON e.etapa = et.id
	LEFT JOIN #__users AS u ON p.id_asignado = u.id
	'.$join.'
	WHERE '.$activo.$where.'
	GROUP BY p.id
	ORDER BY p.id DESC';
    //echo $query;
	$db->setQuery($query);  
	$prospectos = $db->loadObjectList();
	return $prospectos;
    echo $prospectos;
	}
function getCRMProspectosPaginacion($etapa = '', $e = 0, $id_usuario = 0, $segmento = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$where = '';
	if($etapa != '')
		$where.= ' AND e.etapa = "'.$etapa.'"';
	
	switch($e){
		case '1':
		$join = 'LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto';
		$where.= ' AND (n.estado = "1" OR n.estado = "2") AND n.activo = "1"';
		break;
		case '2':
		$select = ', n.monto AS nmonto, n.id_asignado, n.estado AS nestado, n.fecha_registro AS nfecha_registro, n.fecha_cierre AS nfecha_cierre';
		$join = 'LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto';
		$where.= ' AND n.estado = "0" AND n.activo = "1"';
		break;
		}
	
	if($id_usuario != 0){
		$where.= ' AND p.id_asignado = "'.$id_usuario.'"';        
    }
	if(!validaAcceso('CRM Administrador')){
		$where.= ' AND p.id_asignado = "'.$user->get('id').'"';
    }
	if($segmento!=0){
        $where.= ' AND p.id_segmento = "'.$segmento.'"';
    }
    
    $cant= 10;
	
    
	$query = 'SELECT p.*, e.etapa, et.etapa AS nombre_etapa, u.name '.$select.'
	FROM #__erp_crm_prospecto AS p
	LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
	LEFT JOIN #__erp_crm_etapas AS et ON e.etapa = et.id
	LEFT JOIN #__users AS u ON p.id_asignado = u.id
	'.$join.'
	WHERE e.activo = "1" '.$where.'
	GROUP BY p.id
	ORDER BY p.id DESC';
    //echo $query;
	$db->setQuery($query);  
	$prospectos = $db->loadResult();
	
	echo $prospectos;
	$paginas = $prospectos / $cant;
    
	if(($prospectos % $cant) != 0)
		$paginas = ceil($paginas);
    echo $paginas;
	return $paginas;
    
	}
function getCRMProspectosInactivos($estado){
    $db =& JFactory::getDBO();
    $user =& JFactory::getUser();
    if($estado==1){
        $negocio = 'WHERE estado = "1"';
    }elseif($estado==2){
        $negocio = 'WHERE estado = "2"';
    }
    $where = '';
    if(!validaAcceso('CRM Administrador')){
		$where.= ' AND id_asignado = "'.$user->get('id').'"';
    }
    $query = 'SELECT id, empresa FROM #__erp_crm_prospecto ';
    $query .= $negocio.$where.' ORDER BY fecha_registro';
    //echo $query;
    $db->setQuery($query);  
	$prospectos = $db->loadObjectList();
    return $prospectos;
}
    
function getCRMProspectoActividad($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT a.*, u.name 
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__users AS u ON a.id_asignado = u.id
 	WHERE a.id_prospecto = "'.$id.'" 
	ORDER BY a.fecha_registro 
	LIMIT 1';
	$db->setQuery($query);  
	$actividad = $db->loadObject();
	return $actividad;
	}
function getCRMcantactividades($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(a.id)
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__erp_crm_negocio AS n ON a.id_negocio = n.id
	WHERE a.id_prospecto = "'.$id.'" AND n.activo = "1" AND a.atencion = "0"
	GROUP BY a.id_prospecto';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function getCRMcantactividadesPend($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT a.tipo, a.titulo, a.fecha
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__erp_crm_negocio AS n ON a.id_negocio = n.id
	WHERE a.id_prospecto = "'.$id.'" AND n.activo = "1" AND a.atencion = "0" AND a.activo = "1"';
	$db->setQuery($query);  
	$act = $db->loadObjectList();
	return $act;
	}
	
function getCRMProspectoActpendiente($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT a.*, u.name 
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__users AS u ON a.id_asignado = u.id
 	WHERE a.id_prospecto = "'.$id.'" 
	ORDER BY a.fecha_registro 
	LIMIT 1';
	$db->setQuery($query);  
	$actividad = $db->loadObject();
	return $actividad;
	}
	
function getCRMProspecto($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT COUNT(id) FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant == 0){
		$query = 'SELECT p.id, p.id_segmento, p.id_usuario, p.id_origen, p.id_asignado, p.origen, p.empresa, p.fono_empresa, p.contacto_nombre, p.contacto_apellido, p.telefono, p.celular, p.direccion, p.email, e.etapa, u.name, e.estado, e.id_negocio
		FROM #__erp_crm_prospecto AS p
		LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
		LEFT JOIN #__users AS u ON p.id_asignado = u.id
		WHERE p.id = "'.$id.'" AND e.activo = "1';
		}else{
		$query = 'SELECT p.id, p.id_segmento, p.id_usuario, p.id_origen, p.id_asignado, p.origen, p.empresa, p.fono_empresa, p.contacto_nombre, p.contacto_apellido, p.telefono, p.celular, p.direccion, p.email, e.etapa, u.name, n.id AS id_negocio, n.monto, n.fecha_registro, n.fecha_cierre, n.estado
		FROM #__erp_crm_prospecto AS p
		LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
		LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto
		LEFT JOIN #__users AS u ON p.id_asignado = u.id
		WHERE p.id = "'.$id.'" AND e.activo = "1" AND n.activo = "1"';	
		}
	//echo $query;
	$db->setQuery($query);  
	$prospecto = $db->loadObject();
	return $prospecto;
	}
function getCRMProspectoInactivo($id = 0){
    $db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT COUNT(id) FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant == 0){
		$query = 'SELECT p.id, p.id_segmento, p.id_usuario, p.id_origen, p.id_asignado, p.origen, p.empresa, p.fono_empresa, p.contacto_nombre, p.contacto_apellido, p.telefono, p.celular, p.direccion, p.email, e.etapa, u.name, e.estado, e.id_negocio
		FROM #__erp_crm_prospecto AS p
		LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
		LEFT JOIN #__users AS u ON p.id_asignado = u.id
		WHERE p.id = "'.$id.'"';
		}else{
		$query = 'SELECT p.id, p.id_segmento, p.id_usuario, p.id_origen, p.id_asignado, p.origen, p.empresa, p.fono_empresa, p.contacto_nombre, p.contacto_apellido, p.telefono, p.celular, p.direccion, p.email, e.etapa, u.name, n.id AS id_negocio, n.monto, n.fecha_registro, n.fecha_cierre, p.estado
		FROM #__erp_crm_prospecto AS p
		LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
		LEFT JOIN #__erp_crm_negocio AS n ON p.id = n.id_prospecto
		LEFT JOIN #__users AS u ON p.id_asignado = u.id
		WHERE p.id = "'.$id.'"';	
		}
	
	$db->setQuery($query);  
	$prospecto = $db->loadObject();
	return $prospecto;
}
function getCRMProspectoInt($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT p.* 
	FROM #__erp_crm_interes AS i
	LEFT JOIN #__erp_producto_items AS p ON i.id_interes = p.id 
	LEFT JOIN #__erp_crm_negocio AS n ON i.id_negocio = n.id
	WHERE i.id_prospecto = "'.$id.'" AND n.activo = "1"';
	$db->setQuery($query);  
	$prospecto = $db->loadObjectList();
	return $prospecto;
	}
function getCRMnegocios(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id.'" ORDER BY fecha_registro DESC';
	$db->setQuery($query);  
	$neg = $db->loadObjectList();
	return $neg;
	}
function getCRMProspectoInteres($id_interes, $id_prospecto){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(i.id_prospecto)
	FROM #__erp_crm_interes AS i
	LEFT JOIN #__erp_crm_negocio AS n ON i.id_negocio = n.id
	WHERE i.id_prospecto = "'.$id_prospecto.'" AND n.activo = "1" AND i.id_interes = "'.$id_interes.'"';
	$db->setQuery($query);  
	$int = $db->loadResult();
	return $int;
	}
function newCRMEtapa(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_prospecto = JRequest::getVar('id', '', 'post');
	$etapa = JRequest::getVar('etapa', '', 'post');
	
	$query = 'INSERT INTO #__erp_crm_etapa(`id_usuario`, `id_prospecto`, `etapa`, `fecha`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$etapa.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creo Etapa CRM ');
	}

// Actividades
function newCRMAtencion(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_prospecto = JRequest::getVar('id_empresa', '', 'post');
	$id_interes = JRequest::getVar('interes', '', 'post');
	$tipo = JRequest::getVar('tipo_actividad_a', '', 'post');
	$titulo = JRequest::getVar('tipo_a', '', 'post');
	$comentario = filtroCadena(JRequest::getVar('nota_a', '', 'post','STRING',JREQUEST_ALLOWHTML));
	
	$query = 'SELECT id FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id_prospecto.'" AND activo = "1"';
	$db->setQuery($query);  
	$id_negocio = $db->loadResult();
	
	$query = 'INSERT INTO #__erp_crm_actividades(`id_usuario`, `id_prospecto`, `id_interes`, `id_negocio`, `tipo`, `titulo`, `fecha`, `hora`, `comentario`, `fecha_registro`, `atencion`, `activo`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$id_interes.'"';
	$query.= ', "'.$id_negocio.'"';
	$query.= ', "'.$tipo.'"';
	$query.= ', "'.$titulo.'"';
	$query.= ', NOW()';
	$query.= ', NOW()';
	$query.= ', "'.$comentario.'"';
	$query.= ', NOW()';
	$query.= ', "1"';
	$query.= ', "0"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó atención CRM ');
	}
function newCRMActividad(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_asignado = JRequest::getVar('asignada', '', 'post');
	$id_prospecto = JRequest::getVar('id_empresa', '', 'post');
	$id_interes = JRequest::getVar('interes', '', 'post');
	$tipo = JRequest::getVar('tipo_actividad', '', 'post');
	$titulo = JRequest::getVar('tipo', '', 'post');
	$fecha = fecha2(JRequest::getVar('fecha', '', 'post'));
	$hora = JRequest::getVar('hora', '', 'post');
	$duracion = JRequest::getVar('duracion', '', 'post');
	$comentario = filtroCadena(JRequest::getVar('nota', '', 'post','STRING',JREQUEST_ALLOWHTML));
	
	$query = 'SELECT id FROM #__erp_crm_negocio WHERE id_prospecto = "'.$id_prospecto.'" AND activo = "1"';
	$db->setQuery($query);  
	$id_negocio = $db->loadResult();
	
	$query = 'INSERT INTO #__erp_crm_actividades(`id_usuario`, `id_asignado`, `id_prospecto`, `id_interes`, `id_negocio`, `tipo`, `titulo`, `fecha`, `hora`, `duracion`, `comentario`, `fecha_registro`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_asignado.'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$id_interes.'"';
	$query.= ', "'.$id_negocio.'"';
	$query.= ', "'.$tipo.'"';
	$query.= ', "'.$titulo.'"';
	$query.= ', "'.$fecha.'"';
	$query.= ', "'.$hora.'"';
	$query.= ', "'.$duracion.'"';
	$query.= ', "'.$comentario.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creo Prospecto CRM '.$empresa);
	}
function editCRMActividad($id = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$tipo = JRequest::getVar('tipo_actividad', '', 'post');
	$titulo = JRequest::getVar('tipo', '', 'post');
	$fecha = fecha2(JRequest::getVar('fecha', '', 'post'));
	$hora = JRequest::getVar('hora', '', 'post');
	$duracion = JRequest::getVar('duracion', '', 'post');
	$comentario = filtroCadena(JRequest::getVar('nota', '', 'post','STRING',JREQUEST_ALLOWHTML));
	$id_interes = JRequest::getVar('interes', '', 'post');
	$id_asignado = JRequest::getVar('id_asignado', '', 'post');
	
	
	$query = 'UPDATE #__erp_crm_actividades SET ';
	$query.= '`tipo` = "'.$tipo.'"';
	$query.= ', `titulo` = "'.$titulo.'"';
	$query.= ', `id_interes` = "'.$id_interes.'"';
	$query.= ', `id_asignado` = "'.$id_asignado.'"';
	$query.= ', `fecha` = "'.$fecha.'"';
	$query.= ', `hora` = "'.$hora.'"';
	$query.= ', `duracion` = "'.$duracion.'"';
	$query.= ', `comentario` = "'.$comentario.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó Actividad CRM');
	}
function getCRMResponactividad($id_asignado = 0){
		$db =& JFactory::getDBO();
		$where = '1';
		if($id_asignado != 0)
			$where.= ' AND id_asignado = "'.$id_asignado.'"';
		
		$query = 'SELECT p.*, u.name AS nombre
		FROM #__erp_crm_prospecto AS p
		LEFT JOIN #__users AS u ON u.id = p.id_asignado
		WHERE '.$where.' ';
		//    echo $query;
		$db->setQuery($query);  
		$prospectos = $db->loadObjectList();
		return $prospectos;
		
}
function getCRMActividades($activo = 0, $id = 0, $tipo = '', $id_asignado = 0, $id_negocio = 0){
	$db =& JFactory::getDBO();
	
	$where = '1';
	
	if($id == 0)
		$id = JRequest::getVar('id', 0, 'get'); // ID del prospecto
	
	if($id != 0)
		$where.= ' AND a.id_prospecto = "'.$id.'"';
	
	if($activo == 0)
		$where.= ' AND a.activo = "0" ';
		else
		$where.= ' AND a.activo = "1" ';
	
	if($tipo != '')
		$where.= ' AND a.tipo = "'.$tipo.'"';
		
	if($id_asignado != 0)
		$where.= ' AND a.id_asignado = "'.$id_asignado.'"';
		
	if($id_negocio != 0){
		$where.= ' AND a.id_negocio = "'.$id_negocio.'"';
		}else{
		$join  = 'LEFT JOIN #__erp_crm_negocio AS n ON a.id_negocio = n.id';
		$where.= ' AND n.activo = "1"';
		}
	
	$query = 'SELECT a.*, usu.name AS usuario, asu.name AS asignado, p.empresa 
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__users AS usu ON a.id_usuario = usu.id
	LEFT JOIN #__users AS asu ON a.id_asignado = asu.id
	LEFT JOIN #__erp_crm_prospecto AS p ON a.id_prospecto = p.id
	'.$join.'
	WHERE '.$where.'
	ORDER BY a.fecha DESC';
	//echo $query;
	$db->setQuery($query);  
	$prospectos = $db->loadObjectList();
	return $prospectos;
	}
function getCRMActividad($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT a.*, usu.name AS usuario, asu.name AS asignado 
	FROM #__erp_crm_actividades AS a
	LEFT JOIN #__users AS usu ON a.id_usuario = usu.id
	LEFT JOIN #__users AS asu ON a.id_asignado = asu.id
	WHERE a.id = "'.$id.'"';
	$db->setQuery($query);  
	$prospecto = $db->loadObject();
	return $prospecto;
	}
function closeCRMActividad(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$id_usuario = $user->get('id');
	$comentario = JRequest::getVar('comentario', '', 'post');
	
	$query = 'UPDATE #__erp_crm_actividades SET ';
	$query.= 'id_cerrada = "'.$id_usuario.'"';
	$query.= ', fecha_cierre = NOW()';
	$query.= ', comentario_cierre = "'.$comentario.'"';
	$query.= ', activo = "0"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	}
function deleteCRMActividad($id = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'DELETE FROM #__erp_crm_actividades WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró Actividad CRM ');
	}


// Notas
function newCRMNota(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_prospecto = JRequest::getVar('id', '', 'post');
	$nota = filtroCadena(JRequest::getVar('nota', '', 'post','STRING',JREQUEST_ALLOWHTML));
	
	$query = 'INSERT INTO #__erp_crm_notas(`id_usuario`, `id_prospecto`, `nota`, `fecha`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_prospecto.'"';
	$query.= ', "'.$nota.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    $p = getCRMProspecto($id_prospecto);
    newAccion('Creó Nota para prospecto CRM '.$p->empresa);
	}
function getCRMNotas($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_crm_notas WHERE id_prospecto = "'.$id.'" ORDER BY fecha DESC';
	$db->setQuery($query);  
	$notas = $db->loadObjectList();
	return $notas;
	}
function getCRMNota(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_crm_notas WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$nota = $db->loadObject();
	return $nota;
	}
// Etapas
function getCRMEtapasCant(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_crm_etapas WHERE publicado = "1"';
	$db->setQuery($query);  
	$etapas = $db->loadResult();
	return $etapas;
	}
function getCRMEtapas($estado=''){
	$db =& JFactory::getDBO();
	if($estado == 1){
        $publicado= '';
    }else{
        $publicado = 'WHERE publicado = "1"';
    }
	$query = 'SELECT * FROM #__erp_crm_etapas '.$publicado.' ORDER BY orden';
    //echo $query;
	$db->setQuery($query);  
	$etapas = $db->loadObjectList();
	return $etapas;
	}
function getCRMEtapa($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_crm_etapas WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$etapa = $db->loadObject();
	return $etapa;
	}
function newCRMEtapas(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$etapa = JRequest::getVar('etapa', '', 'post');
	$orden = JRequest::getVar('orden', '', 'post');
	$color = JRequest::getVar('color', '', 'post');
	$icono = JRequest::getVar('icono', '', 'post');
	
	$query = 'INSERT INTO #__erp_crm_etapas(`etapa`, `orden`, `icono`, `color`) VALUES(';
	$query.= '"'.$etapa.'"';
	$query.= ', "'.$orden.'"';
	$query.= ', "'.$icono.'"';
	$query.= ', "'.$color.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Etapa CRM '.$etapa);
	}
function editCRMEtapas(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'get');
	$etapa = JRequest::getVar('etapa', '', 'post');
	$orden = JRequest::getVar('orden', '', 'post');
	$color = JRequest::getVar('color', '', 'post');
	$icono = JRequest::getVar('icono', '', 'post');
	
	$query = 'UPDATE #__erp_crm_etapas SET ';
	$query.= '`etapa` = "'.$etapa.'"';
	$query.= ', `orden` = "'.$orden.'"';
	$query.= ', `icono` = "'.$icono.'"';
	$query.= ', `color` = "'.$color.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Etapa CRM '.$etapa);
	}
function enableCRMEtapas(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'post');
	$p = JRequest::getVar('publicado', '', 'post');
	
	$query = 'UPDATE #__erp_crm_etapas SET ';
	$query.= '`publicado` = "'.$p.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query(); 
    newAccion('Deshabilitó Etapa CRM ');
}
function deleteCRMEtapas(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'DELETE FROM #__erp_crm_etapas WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró Etapa CRM ');
	}
function getCRMEtapasAct($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_crm_etapa WHERE etapa = "'.$id.'" AND activo = "1"';
    //echo $query;
	$db->setQuery($query);  
	$etapas = $db->loadResult();
	return $etapas;
	}
	
// Reporte por vendedor
function getCRMvendedores(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT u.id, u.name 
	FROM #__erp_crm_prospecto AS p
	LEFT JOIN #__users AS u ON p.id_asignado = u.id
	WHERE p.id_asignado != "0"
	GROUP BY p.id_asignado';
	
	$db->setQuery($query);  
	$vendedores = $db->loadObjectList();
	return $vendedores;
	}
function getCRMvendedorEmp($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_crm_prospecto WHERE p.id_asignado = "'.$id.'"';
	
	$db->setQuery($query);  
	$emps = $db->loadObjectList();
	return $emps;
	}
 // Estadisticas Fecha
//function getCRMfechaDia($mes = '', $anio = '', $id=''){
function getCRMfechaDia($inicio = '', $fin = '', $id=''){
	$db =& JFactory::getDBO();
	
	/*$dia_ini = 1;
	if($mes == '')
		$mes = date('m');
	if($anio == '')
		$anio = date('Y');
	if($mes < date('m'))
		$dia_fin = 31;
		else
		$dia_fin = date('d');*/
    if($inicio == ''){
		$desde = date('Y-m').'-01';
    }else{
        $desde = fecha2($inicio);
    }
	if($fin == ''){
        $hasta = date('Y-m-d');
    }else{
        $hasta = fecha2($fin);
    }
	if($id != '')
        $usuario = "id_usuario = '".$id."' AND";
        else
        $usuario = " ";
    
	$fecha_ini = $desde;
	$fecha_fin = $hasta;
	
	$etapas = '';
	foreach(getCRMEtapas() as $etapa){
        //echo $etapa->publicado;
		if($etapa->publicado == 1){
			$etapas.= 'SUM( IF( etapa =  "'.$etapa->id.'", 1, 0 ) ) AS etapa_'.$etapa->id.', ';            
        }
    }
	
	$query = 'SELECT 
	'.$etapas.' 
	fecha
	FROM #__erp_crm_etapa
	WHERE '.$usuario.' activo =  "1"
	AND fecha >=  "'.$fecha_ini.'"
	AND fecha <=  "'.$fecha_fin.'"
	GROUP BY fecha';
    //echo $query;
	$db->setQuery($query);  
	$stats = $db->loadAssocList();
	return $stats;
	}
// Estadisticas de Perdidos y Ganados
function getCRMestadoFinal($estado ,$inicio='', $fin='', $id=''){
    $db =& JFactory::getDBO();
    /*$dia_ini = 1;
	if($mes == '')
		$mes = date('m');
    if($anio == '')
		$anio = date('Y');
    if($mes < date('m'))
		$dia_fin = 31;
		else
		$dia_fin = date('d');*/
    if($inicio == ''){
		$desde = date('Y-m').'-01';
    }else{
        $desde = fecha2($inicio);
    }
	if($fin == ''){
        $hasta = date('Y-m-d');
    }else{
        $hasta = fecha2($fin);
    }
    
    if($id != '')
        $usuario = "id_usuario = '".$id."' AND";
        else
        $usuario = " ";
	//$dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    
    $fecha_ini = $desde;
	$fecha_fin = $hasta;
	//SUM( IF( estado =  "'.$estado.'", 1, 0 ) ) AS cant_estado,  		
	$query = 'SELECT 
	SUM( IF( estado = "'.$estado.'", 1, 0 ) ) AS cant_estado,
	fecha_cierre
	FROM #__erp_crm_prospecto
	WHERE '.$usuario.' fecha_cierre
    BETWEEN "'.$fecha_ini.'" AND "'.$fecha_fin.'"
	GROUP BY fecha_cierre';
    //echo $query;
	$db->setQuery($query);
	$stats = $db->loadObjectList();
	return $stats;
	}
//obtener la fecha mas antigua y de ahi sacar el año
function getCRMfechaAntigua(){
    $db =& JFactory::getDBO();
    $query = 'SELECT MIN(fecha_registro) AS primera_fecha FROM #__erp_crm_prospecto';
    $db->setQuery($query);  
	$sql = $db->loadResult();
	return $sql;   
    }
	
// Segmentos
function newCRMsegmento(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$segmento = JRequest::getVar('segmento', '', 'post');
	
	$query = 'INSERT INTO #__erp_crm_segmento(`id_usuario`, `segmento`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$segmento.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Nuevo Segmento CRM '.$segmento);
	}
function editCRMsegmento(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$segmento = JRequest::getVar('segmento', '', 'post');
	
	$query = 'UPDATE #__erp_crm_segmento SET ';
	$query.= '`segmento` = "'.$segmento.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('editó Segmento CRM '.$segmento);
	}
function getCRMsegmentos(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_crm_segmento WHERE eliminado = "0" ORDER BY segmento';
	$db->setQuery($query);  
	$segmentos = $db->loadObjectList();
	return $segmentos;
	}
function getCRMsegmento($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_crm_segmento WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$segmentos = $db->loadObject();
	return $segmentos;
	}

function deleteCRMsegmento(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$segmento = JRequest::getVar('segmento', '', 'post');
	
	$query = 'UPDATE #__erp_crm_segmento SET ';
	$query.= '`eliminado` = "1"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró Segmento CRM ');
	}
?>