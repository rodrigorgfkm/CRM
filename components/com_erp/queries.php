<?php

// Acciones
function newAccion($detalle){
	$db =& JFactory::getDBO(); 
	$user =& JFactory::getUser();
	
	$query = 'INSERT INTO #__erp_logs(`id_usuario`, `fecha`, `hora`, `detalle`) VALUES(';
	$query.= '"'.$user->get('id').'"';
	$query.= ', NOW()';
	$query.= ', NOW()';
	$query.= ', "'.filtroCadena2($detalle).'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	}

// Extensiones
function getExtensiones(){
	$db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	
	if($session->get('ide') != 1)
		$where = 'WHERE id_empresa = "0"';
		else
		$where = 'WHERE 1';
	 
	$query = 'SELECT * FROM #__erp_extensiones '.$where.' ORDER BY id';
	$db->setQuery($query);  
	$extensiones = $db->loadObjectList();
	return $extensiones;
	}
function getExtensionesAccesos($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_gruposacceso WHERE id_extension = "'.$id.'"';
	$db->setQuery($query);  
	$accesos = $db->loadObjectList();
	return $accesos;
	}
function getExtensionesGrupos($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_grupos WHERE id_extension = "'.$id.'"';
	$db->setQuery($query);  
	$accesos = $db->loadObjectList();
	return $accesos;
	}
function verAxs($id_grupo, $id_acceso){
	$db =& JFactory::getDBO();  
	$query = 'SELECT COUNT(id_grupo) FROM #__erp_rel_grupos_acceso WHERE id_grupo = "'.$id_grupo.'" AND id_acceso = "'.$id_acceso.'"';
	$db->setQuery($query);
	$accesos = $db->loadResult();
	if($accesos > 0)
		return true;
		else
		return false;
	}
function checkGrupo($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT COUNT(id_grupo) AS cant FROM #__erp_rel_usuario_grupo WHERE id_grupo = "'.$id.'" AND id_usuario = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	if($cant != 0)
		return true;
		else
		return false;
	}
function reviewGruposSistema($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT COUNT(id_usuario) AS cant FROM #__erp_rel_usuario_grupo WHERE id_grupo = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function getGruposSistema(){
	$db =& JFactory::getDBO();  
	$session = JFactory::getSession();
	
	$id = JRequest::getVar('id', '', 'post');
	if($id != '')
		$where = ' AND g.id_extension = "'.$id.'"';
	
	$query = 'SELECT g.*, e.extension 
	FROM #__erp_grupos AS g 
	LEFT JOIN #__erp_extensiones AS e ON g.id_extension = e.id
	WHERE e.habilitado = 1 AND g.id_empresa = "'.$session->get('ide').'" '.$where.'
	ORDER BY e.extension, g.grupo';
	$db->setQuery($query);  
	$accesos = $db->loadObjectList();
	return $accesos;
	}
function getGrupoSistema($id = 0){
	$db =& JFactory::getDBO();  
	
	if($id == 0)
		$id =JRequest::getVar('id', '', 'get') ;
	
	$query = 'SELECT * FROM #__erp_grupos WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$grupo = $db->loadObject();
	return $grupo;
	}
function newGrupo(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'INSERT INTO #__erp_grupos(`id_empresa`, `id_extension`, `grupo`, `descripcion`) VALUES(';
	$query.= '"'.$session->get('ide').'"';
	$query.= ', "'.JRequest::getVar('id_extension', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('grupo', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('descripcion', '', 'post').'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT id FROM #__erp_grupos ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	foreach($_POST['accesos'] as $id_acceso){
		$query = 'INSERT INTO #__erp_rel_grupos_acceso(`id_grupo`, `id_acceso`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$id_acceso.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	newAccion('Crea rol "'.JRequest::getVar('grupo', '', 'post').'"');
	}
function editGrupo(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$grupo = JRequest::getVar('grupo', '', 'post');
	
	$query = 'UPDATE #__erp_grupos SET grupo = "'.$grupo.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'DELETE FROM #__erp_rel_grupos_acceso WHERE id_grupo = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	foreach($_POST['accesos'] as $id_acceso){
		$query = 'INSERT INTO #__erp_rel_grupos_acceso(`id_grupo`, `id_acceso`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$id_acceso.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	newAccion('Edita grupo "'.$grupo.'"');
	}
function deleteGrupoSistema(){
	$db =& JFactory::getDBO();  
	$query = 'DELETE FROM #__erp_grupos WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró Grupo del sistema');
	}

// Privilegios
function validaAcceso($seccion){
	$user =& JFactory::getUser();
	$session = JFactory::getSession();
	$acceso = $session->get('acceso');
	
	$db =& JFactory::getDBO();
	$query = 'SELECT group_id FROM #__user_usergroup_map WHERE user_id = "'.$user->get('id').'"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	if(in_array($seccion, $acceso) || in_array('Administrador', $acceso) || $id == 8){
		return true;
    }else{
		return false;
    }
}
function getAcceso($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_gruposacceso WHERE id_extension = "'.$id.'"';
	$db->setQuery($query);  
	$accesos = $db->loadObjectList();
	return $accesos;
	}
function getAccesos(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	$user =& JFactory::getUser();
	
	$query = 'SELECT group_id FROM #__user_usergroup_map WHERE user_id = "'.$user->get('id').'"';
	$db->setQuery($query);  
	$id_grupo = $db->loadResult();
	
	if($id_grupo == 8)
		$query = 'SELECT *, id AS id_grupo FROM #__erp_grupos WHERE 1';
		else
		$query = 'SELECT * FROM #__erp_rel_usuario_grupo WHERE id_usuario = "'.$user->get('id').'"';
		
	$db->setQuery($query);  
	$grupos = $db->loadObjectList();
	$i = 0;
	foreach($grupos as $g){
		$query = 'SELECT a.ruta 
		FROM #__erp_rel_grupos_acceso AS rga 
		LEFT JOIN #__erp_gruposacceso AS a ON rga.id_acceso = a.id 
		WHERE rga.id_grupo = "'.$g->id_grupo.'"';
		$db->setQuery($query);  
		$accesos = $db->loadObjectList();
		foreach($accesos as $a){
			$acceso[$i] = $a->ruta;
			$i++;
			}
		}
	$session->set('acceso',$acceso);
	}
// Empresas
function getMainEmpresas(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_empresa WHERE eliminado = "0" ORDER BY fijo DESC, empresa ASC';
	$db->setQuery($query);  
	$empresas = $db->loadObjectList();
	return $empresas;
	}
function getMainEmpresa($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_empresa WHERE id = "'.$id.'"';
	
	$db->setQuery($query);  
	$empresa = $db->loadObject();
	return $empresa;
	}
function newMainEmpresa(){
	$db =& JFactory::getDBO();
	
	$empresa = JRequest::getVar('empresa', '', 'post');
	$razon = JRequest::getVar('razon', '', 'post');
	$otro = JRequest::getVar('otro', '', 'post');
	$titular = JRequest::getVar('titular', '', 'post');
	$nit = JRequest::getVar('nit', '', 'post');
	$codigo = JRequest::getVar('codigo', '', 'post');
	
	$query = 'INSERT INTO #__erp_empresa(`empresa`, `razon`, `otro`, `titular`, `logo`, `logoimpresion`, `nit`, `codigo`) VALUES(';
	$query.= '"'.$empresa.'"';
	$query.= ', "'.$razon.'"';
	$query.= ', "'.$otro.'"';
	$query.= ', "'.$titular.'"';
	$query.= ', "'.$logo.'"';
	$query.= ', "'.$logoimpresion.'"';
	$query.= ', "'.$nit.'"';
	$query.= ', "'.$codigo.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea empresa "'.$empresa.'"');
	}
function editMainEmpresa(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$empresa = JRequest::getVar('empresa', '', 'post');
	$razon = JRequest::getVar('razon', '', 'post');
	$otro = JRequest::getVar('otro', '', 'post');
	$titular = JRequest::getVar('titular', '', 'post');
	$nit = JRequest::getVar('nit', '', 'post');
	
	$query = 'UPDATE #__erp_empresa SET ';
	$query.= '`empresa` = "'.$empresa.'"';
	$query.= ', `razon` = "'.$razon.'"';
	$query.= ', `otro` = "'.$otro.'"';
	$query.= ', `titular` = "'.$titular.'"';
	$query.= ', `logo` = "'.$logo.'"';
	$query.= ', `logoimpresion` = "'.$logoimpresion.'"';
	$query.= ', `nit` = "'.$nit.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Edita empresa "'.$empresa.'"');
	}
function deleteMainEmpresa(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_empresa SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// Supeorusuarios
function getSUsuarios(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT u.*, r.group_id
	FROM #__users AS u 
	LEFT JOIN #__user_usergroup_map AS r ON u.id = r.user_id
	LEFT JOIN #__erp_usuarios AS su ON su.id_usuario = u.id
	WHERE su.su = "1"
	ORDER BY r.group_id, u.name';
	$db->setQuery($query);  
	$usuarios = $db->loadObjectList();
	return $usuarios;
	}
function editSUsuario(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$name	= JRequest::getVar('name', '', 'post');
	$user	= JRequest::getVar('user', '', 'post');
	$pass1	= JRequest::getVar('pass1', '', 'post');
	$pass2	= JRequest::getVar('pass2', '', 'post');
	$email	= JRequest::getVar('email', '', 'post');
	
	if($pass1 == $pass2){
		$query = 'SELECT COUNT(id) FROM #__users WHERE email = "'.$email.'" AND id != "'.$id.'"';
		$db->setQuery($query);  
		$cant = $db->loadResult();
		if($cant == 0){
			$query = 'SELECT COUNT(id) FROM #__users WHERE username = "'.$user.'" AND id != "'.$id.'"';
			$db->setQuery($query);  
			$cant = $db->loadResult();
			if($cant == 0){
				
				$query = 'UPDATE #__users SET ';
				$query.= '`name` = "'.$name.'"';
				$query.= ',`username` = "'.$user.'"';
				$query.= ',`email` = "'.$email.'"';
				if($pass1 != '')
					$query.= ', `password` = "'.md5($pass1).'"';
				$query.= ' WHERE id = "'.$id.'"'; 
				$db->setQuery($query);  
				$db->query();
				
				$ruta = 'media/com_erp/usuarios/';
				$image_foto = '';
				if($_FILES['foto']['name'] != ''){
					$ext = explode('.',$_FILES['foto']['name']);
					$image_foto = date('U').'.'.array_pop($ext);
					copy($_FILES['foto']['tmp_name'], $ruta.$image_foto);
					creaImagenMini($ruta.$image_foto,300,300);
				}
				
				$query = 'UPDATE #__erp_usuarios SET ';
				$query.= '`cargo` = "'.$cargo.'"';
				$query.= ', `foto` = "'.$image_foto.'"';
				$query.= ' WHERE `id_usuario` = "'.$id.'"';
				$db->setQuery($query);  
				$db->query();
				
				newAccion('Edita datos de usuario "'.$name.'"');
				
				return 1;
				}else
				return 2;
			}else
			return 3;	
		}else
		return 4;
	}

// Usuarios
function checkUsuarioSuc($id_usuario, $id_sucursal){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id_usuario) FROM #__erp_rel_usuario_sucursal WHERE id_usuario = "'.$id_usuario.'" AND id_sucursal = "'.$id_sucursal.'"';
	$db->setQuery($query);  
	$sucursales = $db->loadResult();
	
	if($sucursales > 0)
		$val = 1;
		else
		$val = 0;
	
	return $val;
	}
function getUsuarioSucursal($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT s.*, rus.predeterminado
	FROM #__erp_rel_usuario_sucursal AS rus
	LEFT JOIN #__erp_sucursales AS s ON rus.id_sucursal = s.id
	WHERE rus.id_usuario = "'.$id.'"';
	$db->setQuery($query);  
	$sucursales = $db->loadObjectList();
	return $sucursales;
	}
function getUsuario($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();  
	$query = 'SELECT u.*, ue.id_cliente, ue.su, ue.cargo, ue.foto, r.group_id 
	FROM #__users AS u 
	LEFT JOIN #__erp_usuarios AS ue ON u.id = ue.id_usuario 
	LEFT JOIN #__user_usergroup_map AS r ON u.id = r.user_id
	WHERE u.id = "'.$id.'"';
	$db->setQuery($query);  
	$usuario = $db->loadObject();
	return $usuario;
	}
function getUsuarios($t = ''){
	$db =& JFactory::getDBO();  
	$session = JFactory::getSession();
	
	if($t != ''){
		switch($t){
			case 'c':
			$rol = 'Cobrador';
			break;
			case 'm':
			$rol = 'Mensajero';
			break;
			case 'a':
			$rol = 'Ataché';
			break;
			}
		$query = 'SELECT id FROM #__erp_grupos WHERE grupo = "'.$rol.'" AND id_empresa = "'.$session->get('ide').'"';
		$db->setQuery($query);  
		$id_grupo = $db->loadResult();
		
		$join = 'LEFT JOIN #__erp_rel_usuario_grupo AS rug ON u.id = rug.id_usuario';
		$where = 'AND rug.id_grupo = "'.$id_grupo.'"';
		}
	
	$query = 'SELECT u.*, r.group_id
	FROM #__users AS u 
	LEFT JOIN #__user_usergroup_map AS r ON u.id = r.user_id
	LEFT JOIN #__erp_rel_usuario_empresa AS rue ON u.id = rue.id_usuario
	'.$join.'
	WHERE u.block = "0" AND rue.id_empresa = "'.$session->get('ide').'" '.$where.'
	ORDER BY r.group_id, u.name';
	$db->setQuery($query);  
	$usuarios = $db->loadObjectList();
	return $usuarios;
	}
function relUsuarioSucursal($id = 0){
	$db =& JFactory::getDBO();
	
	$sucursal = JRequest::getVar('sucursales', '', 'post');
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'DELETE FROM #__erp_rel_usuario_sucursal WHERE id_usuario = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	foreach($sucursal as $suc){
		$query = 'INSERT INTO #__erp_rel_usuario_sucursal(`id_usuario`, `id_sucursal`) VALUES("'.$id.'", "'.$suc.'")';
		$db->setQuery($query);  
		$db->query();
		}
	}
function getGrupoPerExt(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT id FROM #__erp_grupos WHERE (grupo = "Mensajero" OR grupo = "Cobrador" OR grupo = "Ataché") AND id_empresa = "'.$session->get('ide').'"';
	$db->setQuery($query);  
	$grupo = $db->loadObjectList();
	return $grupo;
	}
function getUsuariosext($t = '', $habilitado=''){
	$db =& JFactory::getDBO();
	
	if($t != '')
		$where = ' AND tipo = "'.$t.'"';
    if($habilitado != '')
		$where = 'AND habilitado = "1"';
	
	$query = 'SELECT * FROM #__erp_clientes_mca WHERE eliminado = "0" '.$where;
	$db->setQuery($query);  
	$grupo = $db->loadObjectList();
	return $grupo;
	}
function enableUsuarioExt(){
    $db =& JFactory::getDBO();
	$estado = JRequest::getVar('estado','','get');
    $id = JRequest::getVar('id','','get');
	$query = 'UPDATE #__erp_clientes_mca SET habilitado = "'.$estado.'"  WHERE id = "'.$id.'"';
	$db->setQuery($query);  
    $db->query();
    $query = 'SELECT nombre FROM #__erp_clientes_mca WHERE id = "'.$id.'"';
    $db->setQuery($query);  
	$us = $db->loadResult();
    newAccion('Habilitó A: '.$us.' como Usuario Externo');
}
function getUsuarioext($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_clientes_mca WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$grupo = $db->loadObject();
	return $grupo;
	}
function newUsuarioext($nombre = '', $tipo = '', $id = 0){
	$db =& JFactory::getDBO();
	
	if($nombre == '')
		$nombre = JRequest::getVar('name', '', 'post');
	if($tipo == '')
		$tipo = JRequest::getVar('cargo', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_mca(`id_usuario`, `nombre`, `tipo`) VALUES(';
	$query.= '"'.$id.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$tipo.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creo Nuevo Usuario Externo');
	}
function editUsuarioext(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$nombre = JRequest::getVar('name', '', 'post');
	$tipo = JRequest::getVar('cargo', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_mca SET ';
	$query.= '`nombre` = "'.$nombre.'"';
	$query.= ', `tipo` = "'.$tipo.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó datos de: '.$nombre.' de Usuario Externo');
	}
function deleteUsuarioext(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'post');
	$query = 'SELECT nombre FROM #__erp_clientes_mca WHERE id = "'.$id.'"';
    $db->setQuery($query);  
	$us = $db->loadResult();
    newAccion('Borró a : '.$us.' como Usuario Externo');
    
	$query = 'UPDATE #__erp_clientes_mca SET ';
	$query.= '`eliminado` = "1"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	}
	
function newUsuario(){
	$config = new JConfig();
	$session = JFactory::getSession();
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	$id_empresa	= $session->get('ide');
	$name		= JRequest::getVar('name', '', 'post');
	$user		= JRequest::getVar('user', '', 'post');
	$pass1		= JRequest::getVar('pass1', '', 'post');
	$pass2		= JRequest::getVar('pass2', '', 'post');
	$email		= JRequest::getVar('email', '', 'post');
	$admin		= JRequest::getVar('admin', '', 'post');
	$cargo		= JRequest::getVar('cargo', '', 'post');
	
	if($pass1 == $pass2){
		$query = 'SELECT id FROM #__users WHERE email = "'.$email.'"';
		$db->setQuery($query);  
		$id = $db->loadResult();
		if($id == 0){
			$query = 'SELECT id FROM #__users WHERE username = "'.$user.'"';
			$db->setQuery($query);  
			$id = $db->loadResult();
			if($id == 0){
				$query = 'INSERT INTO #__users(`name`, `username`, `email`, `password`, `registerDate`) VALUES(';
				$query.= '"'.$name.'"';
				$query.= ', "'.$user.'"';
				$query.= ', "'.$email.'"';
				$query.= ', "'.md5($pass1).'"';
				$query.= ', NOW()';
				$query.= ')'; 
				$db->setQuery($query);  
				$db->query();
				
				$query = 'SELECT id FROM #__users WHERE 1 ORDER BY id DESC LIMIT 1';
				$db->setQuery($query);  
				$id = $db->loadResult();
				
				$ruta = 'media/com_erp/usuarios/';
				$image_foto = '';
				if($_FILES['foto']['name'] != ''){
					$ext = explode('.',$_FILES['foto']['name']);
					$image_foto = date('U').'.'.array_pop($ext);
					copy($_FILES['foto']['tmp_name'], $ruta.$image_foto);
					creaImagenMini($ruta.$image_foto,300,300);
				}
				
				$query = 'INSERT INTO #__erp_rel_usuario_empresa(`id_usuario`, `id_empresa`) VALUES(';
				$query.= '"'.$id.'"';
				$query.= ', "'.$id_empresa.'"';
				$query.= ')';
				$db->setQuery($query);  
				$db->query();
				
				$query = 'INSERT INTO #__erp_usuarios(`id_usuario`, `cargo`, `foto`) VALUES(';
				$query.= '"'.$id.'"';
				$query.= ', "'.$cargo.'"';
				$query.= ', "'.$image_foto.'"';
				$query.= ')';
				$db->setQuery($query);  
				$db->query();
				
				$query = 'INSERT INTO #__user_usergroup_map(`user_id`, `group_id`) VALUES(';
				$query.= '"'.$id.'"';
				if($admin == 1)
					$query.= ', "8"';
					else
					$query.= ', "2"';
				$query.= ')';
				$db->setQuery($query);  
				$db->query();
				
				$gr_n = 0;
				foreach(getGrupoPerExt() as $gr){
					$gr_ext[$gr_n] = $gr->id;
					$gr_n++;
					}
				
				foreach(getExtensiones() as $ext){
				  if($ext->grupos == 1 && $ext->habilitado == 1 && JRequest::getVar('ext_'.$ext->cod, '', 'post') != ''){
					  $id_grupo = JRequest::getVar('ext_'.$ext->cod, '', 'post');
					  
					  $query = 'INSERT INTO #__erp_rel_usuario_grupo(`id_usuario`, `id_grupo`) VALUES(';
					  $query.= '"'.$id.'"';
					  $query.= ', "'.$id_grupo.'"';
					  $query.= ')';
					  $db->setQuery($query);
					  $db->query();
					  
					  if (in_array($id_grupo, $gr_ext)) {
						  $grupo = getGrupoSistema($id_grupo);
						  $tipo = substr(strtolower($grupo->grupo[0]));
						  newUsuarioext($name, $tipo, $id);
					  	  }
					  }
				  }
				
				$mail = '<h3>Hola, '.$name.'</h3>';
				$mail.= '<p>Te informamos que fuiste dado de alta en '.$config->sitename.'</p>';
				$mail.= '<p>Para ingresar al sistema ve a la siguiente dirección: '.$_SERVER['HTTP_HOST'].'</p>';
				$mail.= '<p>Tus datos de acceso son:</p>';
				$mail.= '<ul><li><strong>Usuario:</strong> '.$user.'</li>';
				$mail.= '<li><strong>Contraseña:</strong> '.$pass1.'</li></ul>';
				
				$mailer =& JFactory::getMailer();
				$config =& JFactory::getConfig();
				$sender = array(
					$config->get( 'config.mailfrom' ),
					$config->get( 'config.fromname' ));
				$mailer->setSender($sender);
				
				$recipient = $email;
				
				$mailer->addRecipient($recipient);
				$mailer->isHTML(true);
				$mailer->Encoding = 'base64';
				$mailer->setBody($mail);
				$mailer->setSubject('Nueva cuenta de usuario');
				$mailer->setBody($mail);
				$send =& $mailer->Send();
				
				newAccion('Crea cuenta de usuario para "'.$name.'"');
				
				return 1;
				}else
				return 2;
			}else
			return 3;	
		}else
		return 4;
	}
function editUsuario($id = 0){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$name	= JRequest::getVar('name', '', 'post');
	$user	= JRequest::getVar('user', '', 'post');
	$pass1	= JRequest::getVar('pass1', '', 'post');
	$pass2	= JRequest::getVar('pass2', '', 'post');
	$email	= JRequest::getVar('email', '', 'post');
	$admin	= JRequest::getVar('admin', '', 'post');
	$cargo	= JRequest::getVar('cargo', '', 'post');
	$id_suc = JRequest::getVar('id_sucursal', '', 'post');
	
	if($pass1 == $pass2){
		$query = 'SELECT COUNT(id) FROM #__users WHERE email = "'.$email.'" AND id != "'.$id.'"';
		$db->setQuery($query);  
		$cant = $db->loadResult();
		if($cant == 0){
			$query = 'SELECT COUNT(id) FROM #__users WHERE username = "'.$user.'" AND id != "'.$id.'"';
			$db->setQuery($query);  
			$cant = $db->loadResult();
			if($cant == 0){
				
				$query = 'UPDATE #__users SET ';
				$query.= '`name` = "'.$name.'"';
				$query.= ',`username` = "'.$user.'"';
				$query.= ',`email` = "'.$email.'"';
				if($pass1 != '')
					$query.= ', `password` = "'.md5($pass1).'"';
				$query.= ' WHERE id = "'.$id.'"'; 
				$db->setQuery($query);  
				$db->query();
				
				$ruta = 'media/com_erp/usuarios/';
				$image_foto = '';
				if($_FILES['foto']['name'] != ''){
					$ext = explode('.',$_FILES['foto']['name']);
					$image_foto = date('U').'.'.array_pop($ext);
					copy($_FILES['foto']['tmp_name'], $ruta.$image_foto);
				}
				
				$query = 'UPDATE #__erp_usuarios SET ';
				$query.= '`cargo` = "'.$cargo.'"';
				$query.= ', `foto` = "'.$image_foto.'"';
				$query.= ' WHERE `id_usuario` = "'.$id.'"';
				$db->setQuery($query);  
				$db->query();
				
				if($perfil == 0){
					/*$query = 'UPDATE #__erp_rel_usuario_sucursal SET ';
					$query.= '`id_sucursal` = "'.$id_suc.'"';
					$query.= ' WHERE id_usuario = "'.JRequest::getVar('id', '', 'get').'"'; 
					$db->setQuery($query);  
					$db->query();*/
					
					$query = 'UPDATE #__user_usergroup_map SET ';
					if($admin == 1)
						$query.= '`group_id` = "8"';
						else
						$query.= '`group_id` = "2"';
					$query.= ' WHERE user_id = "'.JRequest::getVar('id', '', 'get').'"'; 
					$db->setQuery($query);  
					$db->query();
	
					foreach(getExtensiones() as $ext){
					  if($ext->grupos == 1 && $ext->habilitado == 1 && JRequest::getVar('ext_'.$ext->cod, '', 'post') != ''){
                          //echo JRequest::getVar('ext_'.$ext->cod, '', 'post').' HOLA <br>';
						  $query = 'SELECT id_grupo FROM #__erp_rel_usuario_grupo WHERE id_usuario = "'.JRequest::getVar('id', '', 'get').'" AND id_grupo = "'.JRequest::getVar('ext_'.$ext->cod, '', 'post').'"';
						  $db->setQuery($query);  
						  $idgrupo = $db->loadResult();
                          /*echo $query;
                          echo '</br>';*/                          
                            $cantidad = 0;
                            foreach (getExtensionesGrupos($ext->id) as $acceso){
                                if(checkGrupo($acceso->id)){
                                    $cantidad = 1;
                                    $idgrupo = $acceso->id;
                                }
                            }
						  if($idgrupo == '' and $cantidad == 0){
							$query = 'INSERT INTO #__erp_rel_usuario_grupo(`id_usuario`, `id_grupo`) VALUES(';
							$query.= '"'.JRequest::getVar('id', '', 'get').'"';
							$query.= ', "'.JRequest::getVar('ext_'.$ext->cod, '', 'post').'"';
							$query.= ')';
						  }else{
							$query = 'UPDATE #__erp_rel_usuario_grupo SET ';
							$query.= '`id_grupo` = "'.JRequest::getVar('ext_'.$ext->cod, '', 'post').'"';
							$query.= ' WHERE `id_usuario` = "'.JRequest::getVar('id', '', 'get').'" AND `id_grupo` = "'.$idgrupo.'"';
						  }
						  $db->setQuery($query);  
						  $db->query();
						  }
					  }	
					}
				
				newAccion('Edita datos del usuario "'.$name.'"');
				
				return 1;
				}else
				return 2;
			}else
			return 3;	
		}else
		return 4;
	}	
function blockusuario(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('estado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__users SET block = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    
    $query = 'SELECT name FROM #__users WHERE = "'.JRequest::getVar('id', '', 'get').'"';
    $db->setQuery($query);  
	$name = $db->loadResult();
    newAccion('Bloqueó a usuario "'.$name.'"');
	}
// Ubicacion
function getPaises(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_ubicacion_pais ORDER BY pais ASC';
	$db->setQuery($query);  
	$paises = $db->loadObjectList();
	return $paises;
	}
function getPais(){
	$db =& JFactory::getDBO();  
	
	$id = JRequest::getVar('id', '1', 'get');
	
	$query = 'SELECT * FROM #__erp_ubicacion_pais WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$paises = $db->loadObject();
	return $paises;
	}
function deletePais(){
	$db =& JFactory::getDBO();  
	$query = 'DELETE FROM #__erp_ubicacion_pais WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function newPais(){
	$db =& JFactory::getDBO();
	$nombre = JRequest::getVar('nombre', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$docid = JRequest::getVar('docid', '', 'post');
	$impuesto = JRequest::getVar('impuesto', '', 'post');
	$incluye = JRequest::getVar('incluye', '', 'post');
	$divpolitica = JRequest::getVar('divpolitica', '', 'post');
	$moneda = JRequest::getVar('moneda', '', 'post');
	$decimal = JRequest::getVar('moneda_decimal', '', 'post');
	
	$query = 'INSERT INTO #__erp_ubicacion_pais(`pais`, `sigla`, `docid`, `impuesto`, `impuesto_incluye`, `divpolitica`, `moneda`, `moneda_decimal`, `activo`) VALUES(';
	$query.= '"'.$nombre.'"';
	$query.= ', "'.$sigla.'"';
	$query.= ', "'.$docid.'"';
	$query.= ', "'.$impuesto.'"';
	$query.= ', "'.$incluye.'"';
	$query.= ', "'.$divpolitica.'"';
	$query.= ', "'.$moneda.'"';
	$query.= ', "'.$decimal.'"';
	$query.= ', "1"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó País '.$nombre);
	}
function editPais(){
	$db =& JFactory::getDBO();
	$nombre = JRequest::getVar('nombre', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$docid = JRequest::getVar('docid', '', 'post');
	$impuesto = JRequest::getVar('impuesto', '', 'post');
	$incluye = JRequest::getVar('incluye', '', 'post');

	$divpolitica = JRequest::getVar('divpolitica', '', 'post');
	$moneda = JRequest::getVar('moneda', '', 'post');
	$decimal = JRequest::getVar('moneda_decimal', '', 'post');
	
	$query = 'UPDATE #__erp_ubicacion_pais SET ';
	$query.= '`pais` = "'.$nombre.'"';
	$query.= ', `sigla` = "'.$sigla.'"';
	$query.= ', `docid` = "'.$docid.'"';
	$query.= ', `impuesto` = "'.$impuesto.'"';
	$query.= ', `impuesto_incluye` = "'.$incluye.'"';
	$query.= ', `divpolitica` = "'.$divpolitica.'"';
	$query.= ', `moneda` = "'.$moneda.'"';
	$query.= ', `moneda_decimal` = "'.$decimal.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó País '.$nombre);
	}
function getEstados($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_ubicacion_estado WHERE id_pais = "'.$id.'" ORDER BY estado ASC';
	$db->setQuery($query);  
	$estados = $db->loadObjectList();
	return $estados;
	}
function getEstado(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_ubicacion_estado WHERE id = "'.JRequest::getVar('id_estado', '', 'get').'"';
	$db->setQuery($query);  
	$estado = $db->loadObject();
	return $estado;
	}
function deleteEstado(){
	$db =& JFactory::getDBO();  
	$query = 'DELETE FROM #__erp_ubicacion_estado WHERE id = "'.JRequest::getVar('id_estado', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Borró Estado');
	}
function newEstado(){
	$db =& JFactory::getDBO();
	$nombre = JRequest::getVar('nombre', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$id_pais = JRequest::getVar('id', '', 'get');
	
	$query = 'INSERT INTO #__erp_ubicacion_estado(`id_pais`, `estado`, `sigla`) VALUES(';
	$query.= '"'.$id_pais.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$sigla.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creó Estado '.$nombre);
	}
function editEstado(){
	$db =& JFactory::getDBO();
	$nombre = JRequest::getVar('nombre', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$id_pais = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_ubicacion_estado SET ';
	$query.= '`estado` = "'.$nombre.'"';
	$query.= ', `sigla` = "'.$sigla.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id_estado', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó Estado '.$nombre);
	}

// Empresa
function getEmpresa(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT e.id, e.empresa, e.razon, e.logo, e.comercial, e.logoimpresion, e.otro, e.titular, e.id_pais, e.nit, p.impuesto, p.docid AS nombre_docidentidad, p.impuesto_incluye, p.divpolitica, p.moneda, .p.moneda_decimal 
	FROM #__erp_configuracion AS e 
	LEFT JOIN #__erp_ubicacion_pais AS p ON e.id_pais = p.id ';
	$db->setQuery($query);  
	$empresa = $db->loadObject();
	return $empresa;
	}

function editEmpresa(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$empresa	= JRequest::getVar('empresa', '', 'post');
	$razon		= JRequest::getVar('razon', '', 'post');
	$nit		= JRequest::getVar('nit', '', 'post');
	$id_pais	= JRequest::getVar('id_pais', '', 'post');
	$otro		= JRequest::getVar('otro', '', 'post');
	$comercial	= JRequest::getVar('comercial', '', 'post');
	$titular	= JRequest::getVar('titular', '', 'post');
	$add		= '';
	$token 		= date('U');
	if($_FILES['logo']['name'] != ''){
		$ext = explode('.',$_FILES['logo']['name']);
		$image = $token.'.'.array_pop($ext);
		copy($_FILES['logo']['tmp_name'], 'media/com_erp/'.$image);
		creaImagen('media/com_erp/'.$image,350,150);
		$add.= ',`logo` = "'.$image.'"';
		}
	if($_FILES['logoimpresion']['name'] != ''){
		$ext = explode('.',$_FILES['logoimpresion']['name']);
		$image = $token.'_impresion.'.array_pop($ext);
		copy($_FILES['logoimpresion']['tmp_name'], 'media/com_erp/'.$image);
		creaImagen('media/com_erp/'.$image,350,150);
		$add.= ',`logoimpresion` = "'.$image.'"';
		}
	
	$query = 'UPDATE #__erp_configuracion SET ';
	$query.= '`empresa` = "'.$empresa.'"';
	$query.= ',`id_pais` = "'.$id_pais.'"';
	$query.= ',`nit` = "'.$nit.'"';
	$query.= ',`razon` = "'.$razon.'"';
	$query.= ',`comercial` = "'.$comercial.'"';
	$query.= ',`otro` = "'.$otro.'"';
	$query.= ',`titular` = "'.$titular.'"';
	$query.= $add;
	$query.= ' WHERE id = "1"';
	$db->setQuery($query);  
	$db->query();
	
	newAccion('Edita empresa "'.$empresa.'"');
	}

// Rubros
function getRubros($id = 0){
	$db =& JFactory::getDBO();
	if($id > 1)
		$query = 'SELECT r.* FROM #__erp_rubro AS r LEFT JOIN #__erp_rel_tipo_actividad AS rta ON r.id = rta.id_rubro WHERE rta.id_factura = "'.$id.'"';
		else
		$query = 'SELECT * FROM #__erp_rubro';
		
	$db->setQuery($query);  
	$rubros = $db->loadObjectList();
	return $rubros;
    
}	
function getRubrosInfo($id_cliente){
    $db =& JFactory::getDBO();
	$query = 'SELECT r.* FROM #__erp_rubro r, cgn_erp_clientes_rubros cr WHERE r.id = cr.id_rubro AND cr.id_cliente = "'.$id_cliente.'"';
	$db->setQuery($query);  
	$rubros = $db->loadObjectList();
	return $rubros;
}
function getClienteRubro($id_cliente, $rubro){
    $db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_rubros AS c JOIN #__erp_rubro AS r ON  c.id_rubro = r.id WHERE c.id_cliente = "'.$id_cliente.'" AND r.id="'.$rubro.'"';
	$db->setQuery($query);  
	$rubros = $db->loadObject();
	return $rubros;
}

function getRubro($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_rubro WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$rubro = $db->loadObject();
	return $rubro;
	}
function deleteRubro(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_rubro WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function newRubro(){
	$db =& JFactory::getDBO();
	$query = 'INSERT INTO #__erp_rubro(`rubro`) VALUES("'.JRequest::getVar('rubro', '', 'post').'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crear rubro "'.JRequest::getVar('rubro', '', 'post').'"');
	}
function editRubro(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_rubro SET `rubro` = "'.JRequest::getVar('rubro', '', 'post').'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}

// Categorías Clientes
function getClientesCats(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_categoria WHERE eliminado = "0" ORDER BY id';
	$db->setQuery($query);  
	$cat = $db->loadObjectList();
	return $cat;
	}
function getClientesCat($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_categoria WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$cat = $db->loadObject();
	return $cat;
	}
function newClientesCat(){
	$db =& JFactory::getDBO();
	
	$categoria = JRequest::getVar('categoria', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_categoria(`categoria`, `sigla`) VALUES("'.$categoria.'", "'.$sigla.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crear categoría de asociados "'.$categoria.'"');
	}
function editClientesCat(){
	$db =& JFactory::getDBO();
	
	$categoria = JRequest::getVar('categoria', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_categoria SET `categoria` = "'.$categoria.'", `sigla` = "'.$sigla.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteClientesCat(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_categoria SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function checkClientesCat($id){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE id_categoria = "'.$id.'"';
	$db->setQuery($query);  
	$cat = $db->loadResult();
	return $cat;
	}

// Tipos de Sociedad
function getTiposSociedad(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_sociedad WHERE eliminado = "0" ORDER BY tipo';
	$db->setQuery($query);  
	$cat = $db->loadObjectList();
	return $cat;
	}
function getTipoSociedad($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_sociedad WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$cat = $db->loadObject();
	return $cat;
	}
function newTipoSociedad(){
	$db =& JFactory::getDBO();
	
	$tipo = JRequest::getVar('tipo', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_sociedad(`tipo`, `sigla`) VALUES("'.$tipo.'", "'.$sigla.'")';
	$db->setQuery($query);
	$db->query();
	newAccion('Crear tipo de sociedad "'.$tipo.'"');
	}
function editTipoSociedad(){
	$db =& JFactory::getDBO();
	
	$tipo = JRequest::getVar('tipo', '', 'post');
	$sigla = JRequest::getVar('sigla', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_sociedad SET `tipo` = "'.$tipo.'", `sigla` = "'.$sigla.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó tipo de sociedad "'.$tipo.'"');
	}
function deleteTipoSociedad(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_sociedad SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Eliminó tipo de sociedad "'.$tipo.'"');
	}

// Cargos
function getClientesCargos(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_cargo WHERE eliminado = "0" ORDER BY cargo';
	$db->setQuery($query);  
	$cat = $db->loadObjectList();
	return $cat;
	}
function getClientesCargo($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_clientes_cargo WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$cat = $db->loadObject();
	return $cat;
	}
function newClientesCargo(){
	$db =& JFactory::getDBO();
	
	$cargo = JRequest::getVar('cargo', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_cargo(`cargo`) VALUES("'.$cargo.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Creó cargo "'.$cargo.'"');
	}
function editClientesCargo(){
	$db =& JFactory::getDBO();
	
	$cargo = JRequest::getVar('cargo', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_cargo SET `cargo` = "'.$cargo.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó Cargo "'.$cargo.'"');
	}
function deleteClientesCargo(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_cargo SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Eliminó cargo');
	}

// Clientes
function addClienteNotapago(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$id_cliente		= JRequest::getVar('id_cliente', '', 'post');
	$monto			= JRequest::getVar('monto', '', 'post') * (-1);
	$detalle		= JRequest::getVar('detalle', '', 'post');
	$nombre			= JRequest::getVar('nombre', '', 'post');
	$docid_cliente	= JRequest::getVar('docid_cliente', '', 'post');
	$docid_receptor	= JRequest::getVar('docid_receptor', '', 'post');
	$acuenta		= JRequest::getVar('acuenta', '', 'post');
	$saldo			= JRequest::getVar('saldo', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_cuenta(`id_cliente`, `id_usuario`, `monto`, `detalle`, `fecha`) VALUES(';
	$query.= '"'.$id_cliente.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.$monto.'"';
	$query.= ', "'.$detalle.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT id FROM #__erp_clientes_cuenta ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id_cuenta = $db->loadResult();
	
	$query = 'INSERT INTO #__erp_clientes_recibo(`id_cuenta`, `nombre`, `acuenta`, `saldo`, `docid_cliente`, `docid_receptor`) VALUES(';
	$query.= '"'.$id_cuenta.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$acuenta.'"';
	$query.= ', "'.$saldo.'"';
	$query.= ', "'.$docid_cliente.'"';
	$query.= ', "'.$docid_receptor.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	newAccion('Creo Nota de Recibo');
	return $id_cuenta;
	}
function addClienteNotacredito(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$id_cliente	= JRequest::getVar('id_cliente', '', 'post');
	$monto		= JRequest::getVar('monto', '', 'post');
	$detalle	= JRequest::getVar('detalle', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_cuenta(`id_cliente`, `id_usuario`, `monto`, `detalle`, `fecha`) VALUES(';
	$query.= '"'.$id_cliente.'"';
	$query.= ', "'.$user->get('id').'"';
	$query.= ', "'.$monto.'"';
	$query.= ', "'.$detalle.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Creo Nota de Credito');
	}
function getClienteCuenta(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT c.*, u.name AS usuario 
	FROM #__erp_clientes_cuenta AS c 
	LEFT JOIN #__users AS u ON c.id_usuario = u.id 
	WHERE id_cliente = "'.JRequest::getVar('id', '', 'get').'"
	ORDER BY fecha ASC';
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;
	}
function getClienteHistorial(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT i.id, i.id_usuario, i.fecha, u.name 
	FROM #__erp_clientes_info AS i
	LEFT JOIN #__users AS u ON i.id_usuario = u.id
	WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);  
	$cuentas = $db->loadObjectList();
	return $cuentas;
	}
function getClientes($valido,$estado=0){
	$db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	$pag  = JRequest::getVar('p', '1', 'get');
   
    $cant= 20;
    $page = $pag - 1;
	$limit = ' LIMIT '.(($page) * $cant).','.$cant;
	$mes = $session->get('mes');
	$anio = $session->get('anio');
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
	$id_cobrador = $session->get('id_cobrador');
	
	$id_mensajero = $session->get('id_mensajero');
	$id_tipo = $session->get('id_tipo');
	$id_estado = $session->get('id_estado');
	$id_actividad = $session->get('id_actividad');
	$marcados = $session->get('marcados');
	$razon = $session->get('razon');
	$razon_ae = $session->get('razon_ae');
	$id_categoriam = $session->get('id_categoriam');
    $registro_ca = $session->get('registro_ca');
	$id_categoria_ca = $session->get('id_categoria_ca');	
	$where = '';
	if(!empty($asociado) || !empty($razon) || !empty($razon_ae) || !empty($registro) || !empty($id_categoria) || !empty($anio) || !empty($id_cobrador) || !empty($marcados) || !empty($registro_ca) || !empty($id_categoria_ca)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($id_cobrador != '')
			$where.= ' AND i.id_usuario_cobrador = "'.$id_cobrador.'"';
		//Clientes Antiguos
		if($anio != ''){
			if($mes != ''){
				$anio.= '-'.$mes;
            }
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
        }        
        //clientes aportes
        if($registro_ca != '')
			$where.= ' AND c.registro = "'.$registro_ca.'"';
        if($id_categoria_ca != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria_ca.'"';
        if($razon != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon.'%"';
		}
        //F masiva
        if($marcados != ''){
			$where.= ' AND c.masiva = "'.$marcados.'"';			
		}
        if($razon_ae != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon_ae.'%"';
		}        
		if($id_categoriam != '')
			$where.= ' AND i.id_categoria = "'.$id_categoriam.'"';
        
		if($id_mensajero != '')
			$where.= ' AND i.id_usuario_mensajero = "'.$id_mensajero.'"';
		if($id_tipo != '')
			$where.= ' AND c.id_tiposociedad = "'.$id_tipo.'"';
		if($id_estado != '')
			$where.= ' AND rce.id_estado = "'.$id_estado.'"';
		if($id_actividad != '')
			$where.= ' AND EXISTS (SELECT FROM cgn_erp_clientes_actividades WHERE id_info = 1)';
		}
	 
	if($valido == 1)
		$where.= ' AND c.valido = "1"';
		else
		$where.= ' AND c.valido = "0"';
    
    if($estado == 1)
		$where.= ' AND rce.id_estado = "1"';
	 
	$query = 'SELECT 
	c.*, 
	cat.categoria, cat.sigla AS categoria_sigla, 
	s.tipo AS sociedad, s.sigla AS sociedad_sigla, 
	i.id AS id_info, i.id_categoria, i.id_usuario_cobrador, i.id_usuario_mensajero, i.capital, i.matr_recsa, i.resol_recsa, i.testimonio, i.poder, i.detalle, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.zona, i.ciudad, i.activo, 
	e.color, 
	rce.id_estado
	FROM #__erp_clientes AS c 
	LEFT JOIN #__erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	WHERE i.activo = "1" AND rce.activo = "1" '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC'.$limit;
	//echo $query;
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function listClientes($valido,$estado=0){
    $db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	$pag  = JRequest::getVar('p', '1', 'get');
   
    $cant= 20;
    $page = $pag - 1;
	$limit = ' LIMIT '.(($page) * $cant).','.$cant;
	$mes = $session->get('mes');
	$anio = $session->get('anio');
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
	$id_cobrador = $session->get('id_cobrador');
	
	$id_mensajero = $session->get('id_mensajero');
	$id_tipo = $session->get('id_tipo');
	$id_estado = $session->get('id_estado');
	$id_actividad = $session->get('id_actividad');
	$marcados = $session->get('marcados');
	$razon = $session->get('razon');
	$razon_ae = $session->get('razon_ae');
	$id_categoriam = $session->get('id_categoriam');
    $registro_ca = $session->get('registro_ca');
	$id_categoria_ca = $session->get('id_categoria_ca');	
	$where = '';
	if(!empty($asociado) || !empty($razon) || !empty($razon_ae) || !empty($registro) || !empty($id_categoria) || !empty($anio) || !empty($id_cobrador) || !empty($marcados) || !empty($registro_ca) || !empty($id_categoria_ca)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($id_cobrador != '')
			$where.= ' AND i.id_usuario_cobrador = "'.$id_cobrador.'"';
		//Clientes Antiguos
		if($anio != ''){
			if($mes != ''){
				$anio.= '-'.$mes;
            }
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
        }        
        //clientes aportes
        if($registro_ca != '')
			$where.= ' AND c.registro = "'.$registro_ca.'"';
        if($id_categoria_ca != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria_ca.'"';
        if($razon != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon.'%"';
		}
        //F masiva
        if($marcados != ''){
			$where.= ' AND c.masiva = "'.$marcados.'"';			
		}
        if($razon_ae != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon_ae.'%"';
		}        
		if($id_categoriam != '')
			$where.= ' AND i.id_categoria = "'.$id_categoriam.'"';
        
		if($id_mensajero != '')
			$where.= ' AND i.id_usuario_mensajero = "'.$id_mensajero.'"';
		if($id_tipo != '')
			$where.= ' AND c.id_tiposociedad = "'.$id_tipo.'"';
		if($id_estado != '')
			$where.= ' AND rce.id_estado = "'.$id_estado.'"';
		if($id_actividad != '')
			$where.= ' AND EXISTS (SELECT FROM cgn_erp_clientes_actividades WHERE id_info = 1)';
		}
	 
	if($valido == 1)
		$where.= ' AND c.valido = "1"';
		else
		$where.= ' AND c.valido = "0"';
    
    if($estado == 1)
		$where.= ' AND rce.id_estado = "1"';
	 
	$query = 'SELECT COUNT(*)
	FROM #__erp_clientes AS c 
	LEFT JOIN #__erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	WHERE i.activo = "1" AND rce.activo = "1" '.$where;
	$db->setQuery($query);  
	$clientes = $db->loadResult();
	return $clientes;
}
function getClientesPag($valido){ 
	$db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	$pag  = JRequest::getVar('p', '1', 'get');
   
    $cant= 20;
    $page = $pag - 1;
	$limit = ' LIMIT '.(($page) * $cant).','.$cant;
	$mes = $session->get('mes');
	$anio = $session->get('anio');
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
	$id_cobrador = $session->get('id_cobrador');
	
	$id_mensajero = $session->get('id_mensajero');
	$id_tipo = $session->get('id_tipo');
	$id_estado = $session->get('id_estado');
	$id_actividad = $session->get('id_actividad');
	$marcados = $session->get('marcados');
	$razon = $session->get('razon');
	$razon_ae = $session->get('razon_ae');
	$id_categoriam = $session->get('id_categoriam');
    $registro_ca = $session->get('registro_ca');
	$id_categoria_ca = $session->get('id_categoria_ca');	
	$where = '';
	if(!empty($asociado) || !empty($razon) || !empty($razon_ae) || !empty($registro) || !empty($id_categoria) || !empty($anio) || !empty($id_cobrador) || !empty($marcados) || !empty($registro_ca) || !empty($id_categoria_ca)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($id_cobrador != '')
			$where.= ' AND i.id_usuario_cobrador = "'.$id_cobrador.'"';
		//Clientes Antiguos
		if($anio != ''){
			if($mes != ''){
				$anio.= '-'.$mes;
            }
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
        }        
        //clientes aportes
        if($registro_ca != '')
			$where.= ' AND c.registro = "'.$registro_ca.'"';
        if($id_categoria_ca != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria_ca.'"';
        if($razon != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon.'%"';
		}
        //F masiva
        if($marcados != ''){
			$where.= ' AND c.masiva = "'.$marcados.'"';			
		}
        if($razon_ae != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon_ae.'%"';
		}        
		if($id_categoriam != '')
			$where.= ' AND i.id_categoria = "'.$id_categoriam.'"';
        
		if($id_mensajero != '')
			$where.= ' AND i.id_usuario_mensajero = "'.$id_mensajero.'"';
		if($id_tipo != '')
			$where.= ' AND c.id_tiposociedad = "'.$id_tipo.'"';
		if($id_estado != '')
			$where.= ' AND rce.id_estado = "'.$id_estado.'"';
		if($id_actividad != '')
			$where.= ' AND EXISTS (SELECT FROM cgn_erp_clientes_actividades WHERE id_info = 1)';
		}
	 
	if($valido == 1)
		$where.= ' AND c.valido = "1"';
		else
		$where.= ' AND c.valido = "0"';
	 
	$query = 'SELECT 
	c.*, 
	cat.categoria, cat.sigla AS categoria_sigla, 
	s.tipo AS sociedad, s.sigla AS sociedad_sigla, 
	i.id AS id_info, i.id_categoria, i.id_usuario_cobrador, i.id_usuario_mensajero, i.capital, i.matr_recsa, i.resol_recsa, i.testimonio, i.poder, i.detalle, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.zona, i.ciudad, i.activo, 
	e.color, 
	rce.id_estado
	FROM #__erp_clientes AS c 
	LEFT JOIN #__erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	WHERE i.activo = "1" AND rce.activo = "1" '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC';
	//echo $query;
	$db->setQuery($query);  
	$client = $db->loadObjectList();
	return $client;
	}
function getClientesrep($valido){
	$db =& JFactory::getDBO(); 
	$session = JFactory::getSession();
	
	$mes = $session->get('r_mes');
	$anio = $session->get('r_anio');
	$asociado = $session->get('r_asociado');
	$registro = $session->get('r_registro');
	$id_categoria = $session->get('r_id_categoria');
	$id_cobrador = $session->get('r_id_cobrador');
	
	$id_mensajero = $session->get('r_id_mensajero');
	$id_tipo = $session->get('r_id_tipo');
	$id_estado = $session->get('r_id_estado');
	$id_actividad = $session->get('ir_d_actividad');
	$marcados = $session->get('r_marcados');
	$razon = $session->get('r_razon');
	$razon_ae = $session->get('r_razon_ae');
	$id_categoriam = $session->get('r_id_categoriam');
    $registro_ca = $session->get('r_registro_ca');
	$id_categoria_ca = $session->get('r_id_categoria_ca');	
	$where = '';
	if(!empty($asociado) || !empty($razon) || !empty($razon_ae) || !empty($registro) || !empty($id_categoria) || !empty($anio) || !empty($id_cobrador) || !empty($marcados) || !empty($registro_ca) || !empty($id_categoria_ca)){
		if($asociado != '')
			$where.= ' AND i.empresa LIKE "%'.$asociado.'%"';
		if($registro != '')
			$where.= ' AND c.registro = "'.$registro.'"';
		if($id_categoria != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria.'"';
		if($id_cobrador != '')
			$where.= ' AND i.id_usuario_cobrador = "'.$id_cobrador.'"';
		//Clientes Antiguos
		if($anio != ''){
			if($mes != ''){
				$anio.= '-'.$mes;
            }
			$where.= ' AND c.fecha_registro LIKE "'.$anio.'-%"';
        }        
        //clientes aportes
        if($registro_ca != '')
			$where.= ' AND c.registro = "'.$registro_ca.'"';
        if($id_categoria_ca != '')
			$where.= ' AND i.id_categoria = "'.$id_categoria_ca.'"';
        if($razon != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon.'%"';
		}
        //F masiva
        if($marcados != ''){
			$where.= ' AND c.masiva = "'.$marcados.'"';			
		}
        if($razon_ae != ''){
			$where.= ' AND i.empresa LIKE "%'.$razon_ae.'%"';
		}        
		if($id_categoriam != '')
			$where.= ' AND i.id_categoria = "'.$id_categoriam.'"';
        
		if($id_mensajero != '')
			$where.= ' AND i.id_usuario_mensajero = "'.$id_mensajero.'"';
		if($id_tipo != '')
			$where.= ' AND c.id_tiposociedad = "'.$id_tipo.'"';
		if($id_estado != '')
			$where.= ' AND rce.id_estado = "'.$id_estado.'"';
		if($id_actividad != '')
			$where.= ' AND EXISTS (SELECT FROM cgn_erp_clientes_actividades WHERE id_info = 1)';
		}
	 
	if($valido == 1)
		$where.= ' AND c.valido = "1"';
		else
		$where.= ' AND c.valido = "0"';
	 
	$query = 'SELECT 
	c.*, 
	cat.categoria, cat.sigla AS categoria_sigla, 
	s.tipo AS sociedad, s.sigla AS sociedad_sigla, 
	i.id AS id_info, i.id_categoria, i.id_usuario_cobrador, i.id_usuario_mensajero, i.capital, i.matr_recsa, i.resol_recsa, i.testimonio, i.poder, i.detalle, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.zona, i.ciudad, i.activo, 
	e.color, 
	rce.id_estado
	FROM #__erp_clientes AS c 
	LEFT JOIN #__erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	LEFT JOIN #__erp_clientes_categoria AS cat ON i.id_categoria = cat.id
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	LEFT JOIN #__erp_clientes_estado AS e ON rce.id_estado = e.id
	WHERE i.activo = "1" AND rce.activo = "1" '.$where.' 
	GROUP BY c.id 
	ORDER BY i.empresa ASC';
	//echo $query;
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function getClientePoder($id){
	$db =& JFactory::getDBO();  
	
	$query = 'SELECT  `nombre` ,  `apellido` ,  `fecha` ,  `poder` 
	FROM  #__erp_clientes_info
	WHERE id_cliente =  "'.$id.'"
	GROUP BY poder';
	$db->setQuery($query);  
	$poder = $db->loadObjectList();
	return $poder;
	}
function getClientesLista(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT c.registro, c.id_categoria, i.* 
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	WHERE i.activo = "1"
	ORDER BY i.empresa ASC';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function updateClienteMasivo(){
	$db =& JFactory::getDBO();
    $id = JRequest::getVar('id','','post');
    $marca = JRequest::getVar('marca','','post');
    $query = 'UPDATE #__erp_clientes SET masiva = "'.$marca.'" WHERE id = "'.$id.'"';
    //echo $query;
    $db->setQuery($query);  
    $db->query();
}
function getEmpresaCliente(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id_empresa', '', 'post');
	  
	$query = 'SELECT c.*, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.activo 
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	WHERE c.id = "'.$id.'" AND i.activo = "1"
	ORDER BY i.empresa';
	$db->setQuery($query);  
	$empresas = $db->loadObject();
	return $empresas;
	}
function getEmpresasCliente(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT c.*, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.activo 
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	WHERE i.empresa != "" AND i.activo = "1"
	ORDER BY i.empresa';
	$db->setQuery($query);  
	$empresas = $db->loadObjectList();
	return $empresas;
	}
function getClientesEmergente(){
	$cliente = JRequest::getVar('cliente', '', 'post');
	$palabra = explode(' ', $cliente);
	$omite = array('de', 'De', 'la', 'La');
	
	$filtro_e = '';
	foreach($palabra as $p){
		if(!in_array($p, $omite)){
			if($filtro_e != '')
				$or = ' OR';
			$filtro_e.= $or.' c.empresa LIKE "%'.$p.'%"';
			}		
		}
	
	$db =& JFactory::getDBO();
	
	$query = 'SELECT c.*, i.id AS id_info, i.celular, i.correo
	FROM #__erp_crm_prospecto AS c
	LEFT JOIN #__erp_crm_contacto_prospecto AS i ON c.id = i.id_prospecto
		WHERE ('.$filtro_e.') 
	ORDER BY c.empresa';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function getRelClienteEmpresa($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id_empresa) AS cant FROM #__erp_rel_cliente_empresa WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function getClientesEmergentePersonal($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT c.* 
	FROM #__erp_clientes_info AS c 
	LEFT JOIN #__erp_rel_cliente_empresa AS r ON c.id = r.id_cliente 
	WHERE id_empresa = "'.$id.'" AND i.activo = "1"
	ORDER BY nombre, apellido';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function cantRepresentantes($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id_cliente) AS cant FROM #__erp_rel_cliente_empresa WHERE id_empresa = "'.$id.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function getDatoCom($id_cliente, $id_tipo){
	$db =& JFactory::getDBO();
	$query = 'SELECT numero FROM #__erp_clientes_comunicacion WHERE id_cliente = "'.$id_cliente.'" AND id_tipo = "'.$id_tipo.'"';
	$db->setQuery($query);  
	$dato = $db->loadResult();
	return $dato;
	}
function getClientesPSugerido(){
	$nombre = JRequest::getVar('nombre', '', 'post');
	$apellido = JRequest::getVar('apellido', '', 'post');
	$db =& JFactory::getDBO();  
	$query = 'SELECT c.*, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.activo
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	WHERE i.nombre LIKE "%'.$nombre.'%" AND i.apellido LIKE "%'.$apellido.'%" AND i.activo = "1"
	ORDER BY apellido, nombre';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function getClientesESugerido(){
	$empresa = JRequest::getVar('empresa', '', 'post');
	$db =& JFactory::getDBO();  
	$query = 'SELECT c.*, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.activo
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	WHERE i.empresa LIKE "%'.$empresa.'%" AND i.activo = "1"
	ORDER BY i.empresa';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	return $clientes;
	}
function getClienteCelular($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT numero FROM #__erp_clientes_comunicacion WHERE id_cliente = "'.$id.'" AND id_tipo = "2"';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	return $numero;
	}
function getClienteEmail($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT numero FROM #__erp_clientes_comunicacion WHERE id_cliente = "'.$id.'" AND id_tipo = "3"';
	$db->setQuery($query);  
	$numero = $db->loadResult();
	return $numero;
	}
function getClientesCom($id){
	$db =& JFactory::getDBO(); 
	$query = 'SELECT fo.numero AS fono_domicilio, ce.numero AS celular, em.numero AS email 
	FROM cgn_erp_clientes AS c 
	LEFT JOIN cgn_erp_clientes_comunicacion AS fo ON c.id = fo.id_cliente 
	LEFT JOIN cgn_erp_clientes_comunicacion AS ce ON c.id = ce.id_cliente 
	LEFT JOIN cgn_erp_clientes_comunicacion AS em ON c.id = em.id_cliente 
	WHERE fo.id_tipo = "1" AND ce.id_tipo = "2" AND em.id_tipo = "3" AND c.id = "'.$id.'"';
	$db->setQuery($query);  
	$com = $db->loadObject();
	return $com;
	}
function getClientesC($id_cliente, $tipo, $origen = ''){
	$db =& JFactory::getDBO();
	
	if($origen == '')
		$where = 'c.id_cliente = "'.$id_cliente.'" AND t.empresa = "1"';
		else
		$where = 'c.id_personal = "'.$id_cliente.'" AND t.empresa = "0"';
	
	$query = 'SELECT c.* 
	FROM #__erp_clientes_comunicacion AS c
	LEFT JOIN #__erp_clientes_comunicaciontipo AS t ON c.id_tipo = t.id
	WHERE '.$where.' AND t.t = "'.$tipo.'"';
	$db->setQuery($query);  
	$com = $db->loadObjectList();
	return $com;
	}
function getClienteEmpresa(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT e.*, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.activo
	FROM #__erp_clientes as e 
	LEFT JOIN #__erp_clientes_info as i ON e.id = i.id_cliente
	LEFT JOIN #__erp_rel_cliente_empresa AS r ON e.id = r.id_empresa 
	WHERE r.id_cliente = "'.JRequest::getVar('id', '', 'post').'" AND i.activo = "1"
	ORDER BY i.empresa';
	$db->setQuery($query);  
	$empresas = $db->loadObjectList();
	return $empresas;
	}
function getClienteContacto($id_info){
	$db =& JFactory::getDBO();  
	
	$query = 'SELECT valor FROM #__erp_crm_contacto_prospecto WHERE id_prospecto = "'.$id_info.'"';
	$db->setQuery($query);  
	$contacto = $db->loadObjectList();
	return $contacto;
	}
function getCliente($id = 0, $id_info = 0){
	$db =& JFactory::getDBO();  
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	if($id_info == 0)
		$where = 'i.activo = "1"';
		else
		$where = 'i.id = "'.$id_info.'"';
	
	$query = 'SELECT 
	c.*, 
	s.tipo AS sociedad, s.sigla AS sociedad_sigla, 
	i.id AS id_info, i.id_categoria, i.id_usuario_cobrador, i.id_usuario_mensajero, i.id_usuario, i.id_modo_envio, i.capital, i.mat_fundempresa, i.testimonio, i.poder, i.detalle, i.extraviado, i.empresa, i.nit, i.atache, i.nombre, i.apellido, i.direccion, i.ciudad, i.zona, i.casilla, i.fax, i.activo, i.fecha AS fecha_cambio, i.comentario_act, i.tipo_empresa, i.per_permanente, i.per_eventual, i.cargo, i.file_nit, i.file_matricula, i.file_testimonio, i.file_poder, 
	rce.id_estado, rce.motivo AS estado_motivo
	FROM #__erp_clientes AS c
	LEFT JOIN #__erp_clientes_sociedad AS s ON c.id_tiposociedad = s.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	LEFT JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	WHERE c.id = "'.$id.'" AND rce.activo = "1" AND '.$where;
	$db->setQuery($query);  
	$cliente = $db->loadObject();
	return $cliente;
	}
function changeClienteEstado(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	$user =& JFactory::getUser();
	
	$id_cliente = JRequest::getVar('ic', '', 'post');
	$estado = JRequest::getVar('id_estado', '', 'post');
	$motivo = JRequest::getVar('motivo', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_rel_estado(`id_usuario`, `id_cliente`, `id_estado`, `fecha`, `activo`, `motivo`) VALUES(';
	$query.= '"'.$user->get('id').'"';
	$query.= ', "'.$id_cliente.'"';
	$query.= ', "'.$estado.'"';
	$query.= ', NOW()';
	$query.= ', "1"';
	$query.= ', "'.$motivo.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);  
	$id_estado = $db->loadResult();
	
	$query = 'UPDATE #__erp_clientes_rel_estado SET activo = "0" WHERE id != "'.$id_estado.'" and id_cliente = "'.$id_cliente.'"';
	$db->setQuery($query);  
	$db->query();
	
    newHistorialCambios($estado,$motivo,$id_cliente);
	}
function suspendeCliente(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$bloqueado = JRequest::getVar('b', '', 'get');
	
	$query = 'UPDATE #__erp_clientes SET bloqueado = "'.$bloqueado.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	$id_usuario = $user->get('id');
	
	$query = 'INSERT INTO #__erp_clientes_suspension(`id_cliente`, `id_usuario`, `suspendido`, `fecha`) VALUES(';
	$query.= '"'.$id.'"';
	$query.= ', "'.$id_usuario.'"';
	$query.= ', "'.$bloqueado.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
    newAccion('Suspendió Asociado');
	}
function validaCliente(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	
	$id_tipo		= JRequest::getVar('id_tipo', '', 'post');
	$id_usregistro	= $user->get('id');
	$num_reg		= JRequest::getVar('num_reg', '', 'post');
	$libro			= JRequest::getVar('libro', '', 'post');
	$tomo			= JRequest::getVar('tomo', '', 'post');
	$partida		= JRequest::getVar('partida', '', 'post');
	$p_inscripcion	= JRequest::getVar('p_inscripcion', '', 'post');
	$u_inscripcion	= JRequest::getVar('u_inscripcion', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE registro = "'.$num_reg.'" AND registro != ""';
	$db->setQuery($query);
	$count = $db->loadResult();
	
	if($count == 0){
	
		$ruta = 'media/com_erp/archivos/'.$id_cliente.'/';
		if(!file_exists ($ruta)){
			if(!mkdir($ruta, 0777, true))
				$session->set('error', 'No se pudo crear el directorio para el asociado '.$empresa);	
			}
	
		$query = 'UPDATE #__erp_clientes SET ';
		$query.= '`id_tiposociedad` = "'.$id_tipo.'"';
		$query.= ', `registro` = "'.$num_reg.'"';
		$query.= ', `libro` = "'.$libro.'"';
		$query.= ', `tomo` = "'.$tomo.'"';
		$query.= ', `part` = "'.$partida.'"';
		$query.= ', `fecha_inscripcion` = "'.fecha2($p_inscripcion).'"';
		$query.= ', `fecha_uinscripcion` = "'.fecha2($u_inscripcion).'"';
		$query.= ', `valido` = "1"';
		$query.= ' WHERE id = "'.$id_cliente.'"';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'SELECT id, file_nit, file_matricula, file_testimonio, file_poder 
		FROM #__erp_clientes_info 
		WHERE id_cliente = "'.$id_cliente.'" AND activo = "1"';
		$db->setQuery($query);
		$info_ant = $db->loadObject();
		
		$query = 'UPDATE #__erp_clientes_info SET activo = "0" WHERE id_cliente = "'.$id_cliente.'"';
		$db->setQuery($query);  
		$db->query();
		
		$id_categoria	= JRequest::getVar('id_categoria', '', 'post');
		$id_estado		= JRequest::getVar('id_estado', '', 'post');
		$id_cobrador	= JRequest::getVar('id_cobrador', '', 'post');
		$id_mensajero	= JRequest::getVar('id_mensajero', '', 'post');
		
		$empresa		= filtroCadena2(JRequest::getVar('empresa', '', 'post'));
		$nit			= JRequest::getVar('nit', '', 'post');
		$atache			= JRequest::getVar('atache', '', 'post');
		$direccion		= filtroCadena2(JRequest::getVar('direccion', '', 'post'));
		
		$ciudad			= JRequest::getVar('ciudad', '', 'post');
		$zona			= JRequest::getVar('zona', '', 'post');
		$capital		= JRequest::getVar('capital', '', 'post');
		
		$mat_fundem		= JRequest::getVar('mat_fundem', '', 'post');
		$testimonio		= JRequest::getVar('testimonio', '', 'post');
		$casilla		= JRequest::getVar('casilla', '', 'post');
		$fax			= JRequest::getVar('fax', '', 'post');
		$detalle		= filtroCadena2(JRequest::getVar('detalle', '', 'post'));
		
		$nombre			= JRequest::getVar('nombre', '', 'post');
		$apellido		= JRequest::getVar('apellido', '', 'post');
		$poder			= JRequest::getVar('poder', '', 'post');
		$comentario_act	= JRequest::getVar('comentario_act', '', 'post');
		
		$cargo		= JRequest::getVar('cargo', '', 'post');
		
		$ruta_tmp = 'media/com_erp/tmp/';
		
		$file_nit = $info_ant->file_nit;
		if($session->get('nit') != ''){
			$ext = explode('.', $session->get('nit'));
			$extension = array_pop($ext);
			
			$file_nit = $id_cliente.'_nit_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('nit'), $ruta.$file_nit);
			
			$session->clear('nit');
			unlink($ruta_tmp.$session->get('nit'));
			}
		
		$file_matricula = $info_ant->file_matricula;
		if($session->get('matricula') != ''){
			$ext = explode('.', $session->get('matricula'));
			$extension = array_pop($ext);
			
			$file_matricula = $id_cliente.'_matricula_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('matricula'), $ruta.$file_matricula);
			
			$session->clear('matricula');
			unlink($ruta_tmp.$session->get('matricula'));
			}
			
		$file_poder = $info_ant->file_poder;
		if($session->get('poder') != ''){
			$ext = explode('.', $session->get('poder'));
			$extension = array_pop($ext);
			
			$file_poder = $id_cliente.'_poder_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('poder'), $ruta.$file_poder);
			
			$session->clear('poder');
			unlink($ruta_tmp.$session->get('poder'));
			}
		
		$query = 'INSERT INTO #__erp_clientes_info(
		`id_categoria`, `id_usuario_cobrador`, `id_usuario_mensajero`, `id_cliente`, 
		`id_usuario`, `empresa`, `nit`, `atache`, `direccion`, 
		`ciudad`, `zona`, `activo`, `fecha`, `capital`, 
		`mat_fundempresa`, `testimonio`, `casilla`, `fax`, `detalle`,
		`nombre`, `apellido`, `poder`, `comentario_act`, `cargo`, 
		`file_nit`, `file_matricula`, `file_poder`
		) VALUES(';
		$query.= '"'.$id_categoria.'"';
		$query.= ', "'.$id_cobrador.'"';
		$query.= ', "'.$id_mensajero.'"';
		$query.= ', "'.$id_cliente.'"';
		
		$query.= ', "'.$id_usregistro.'"';
		$query.= ', "'.$empresa.'"';
		$query.= ', "'.$nit.'"';
		$query.= ', "'.$atache.'"';
		$query.= ', "'.$direccion.'"';
		
		$query.= ', "'.$ciudad.'"';
		$query.= ', "'.$zona.'"';
		$query.= ', "1"';
		$query.= ', NOW()';
		$query.= ', "'.$capital.'"';
		
		$query.= ', "'.$mat_fundem.'"';
		$query.= ', "'.$testimonio.'"';
		$query.= ', "'.$casilla.'"';
		$query.= ', "'.$fax.'"';
		$query.= ', "'.$detalle.'"';
		
		$query.= ', "'.$nombre.'"';
		$query.= ', "'.$apellido.'"';
		$query.= ', "'.$poder.'"';
		$query.= ', "'.$comentario_act.'"';	
		$query.= ', "'.$cargo.'"';	
			
		$query.= ', "'.$file_nit.'"';
		$query.= ', "'.$file_matricula.'"';
		$query.= ', "'.$file_poder.'"';
		
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'SELECT LAST_INSERT_ID()';
		$db->setQuery($query);  
		$id_info = $db->loadResult();
		
		newClienteInfo($id_cliente, $id_info, $info_ant->id);
        
		$rubros = JRequest::getVar('rubros', '', 'post');
		foreach($rubros as $rubro){
			$query = 'INSERT INTO cgn_erp_clientes_rubros(id_cliente, id_rubro) VALUES("'.$id_cliente.'", "'.$rubro.'")';
			$db->setQuery($query);  
			$db->query();
        }
		$valido = 1;
		}else{
		$valido = 0;
		}
	return $valido;
    newAccion('Validó Nuevo Asociado: '.$empresa);
	}
function newCliente(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$id_tipo		= JRequest::getVar('id_tipo', '', 'post');
	$id_usregistro	= $user->get('id');
	$num_reg		= JRequest::getVar('num_reg', '', 'post');
	$libro			= JRequest::getVar('libro', '', 'post');
	$tomo			= JRequest::getVar('tomo', '', 'post');
	$partida		= JRequest::getVar('partida', '', 'post');
	$p_inscripcion	= JRequest::getVar('p_inscripcion', '', 'post');
	$u_inscripcion	= JRequest::getVar('u_inscripcion', '', 'post');
	if($num_reg != '')
		$valido = 1;
		else
		$valido = 0;
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE registro = "'.$num_reg.'" AND registro != ""';
	$db->setQuery($query);
	$count = $db->loadResult();
	
	if($count == 0){
	
		$query = 'INSERT INTO #__erp_clientes(`id_tiposociedad`, `registro`, `libro`, `tomo`, `part`, `id_usuario_registro`, `fecha_registro`, `fecha_inscripcion`, `fecha_uinscripcion`, `valido`) VALUES(';
		$query.= '"'.$id_tipo.'"';
		$query.= ', "'.$num_reg.'"';
		$query.= ', "'.$libro.'"';
		$query.= ', "'.$tomo.'"';
		$query.= ', "'.$partida.'"';
		$query.= ', "'.$id_usregistro.'"';
		$query.= ', NOW()';
		$query.= ', "'.fecha2($p_inscripcion).'"';
		$query.= ', "'.fecha2($u_inscripcion).'"';
		$query.= ', "'.$valido.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'SELECT LAST_INSERT_ID()';
		$db->setQuery($query);
		$id_cliente = $db->loadResult();
		
		$ruta = 'media/com_erp/archivos/'.$id_cliente.'/';
		if(!mkdir($ruta, 0777, true))
			$session->set('error', 'No se pudo crear el directorio para el asociado '.$empresa);
		
		$id_categoria	= JRequest::getVar('id_categoria', '', 'post');
		$id_estado		= JRequest::getVar('id_estado', '', 'post');
		$id_cobrador	= JRequest::getVar('id_cobrador', '', 'post');
		$id_mensajero	= JRequest::getVar('id_mensajero', '', 'post');
		
		$empresa		= filtroCadena2(JRequest::getVar('empresa', '', 'post'));
		$nit			= JRequest::getVar('nit', '', 'post');
		$atache			= JRequest::getVar('atache', '', 'post');
		$direccion		= filtroCadena2(JRequest::getVar('direccion', '', 'post'));
		
		$ciudad			= JRequest::getVar('ciudad', '', 'post');
		$zona			= JRequest::getVar('zona', '', 'post');
		$capital		= JRequest::getVar('capital', '', 'post');
		
		$mat_fundem		= JRequest::getVar('mat_fundem', '', 'post');
		$testimonio		= JRequest::getVar('testimonio', '', 'post');
		$casilla		= JRequest::getVar('casilla', '', 'post');
		$fax			= JRequest::getVar('fax', '', 'post');
		$detalle		= filtroCadena2(JRequest::getVar('detalle', '', 'post'));
		
		$nombre			= JRequest::getVar('nombre', '', 'post');
		$apellido		= JRequest::getVar('apellido', '', 'post');
		$poder			= JRequest::getVar('poder', '', 'post');
		$comentario_act	= JRequest::getVar('comentario_act', '', 'post');
		$tipo_empresa	= JRequest::getVar('tipo_empresa', '', 'post');
		$per_permanente	= JRequest::getVar('per_permanente', '', 'post');
		$per_eventual	= JRequest::getVar('per_eventual', '', 'post');
		//$estado			= JRequest::getVar('estado', '1', 'post');
		
		$cargo		= JRequest::getVar('cargo', '', 'post');
		
		$ruta_tmp = 'media/com_erp/tmp/';
		$file_nit = '';
		if($session->get('nit') != ''){
			$ext = explode('.', $session->get('nit'));
			$extension = array_pop($ext);
			
			$file_nit = $id_cliente.'_nit_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('nit'), $ruta.$file_nit);
			
			unlink($ruta_tmp.$session->get('nit'));
			$session->clear('nit');
			}
		
		$file_matricula = '';
		if($session->get('matricula') != ''){
			$ext = explode('.', $session->get('matricula'));
			$extension = array_pop($ext);
			
			$file_matricula = $id_cliente.'_matricula_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('matricula'), $ruta.$file_matricula);
			
			unlink($ruta_tmp.$session->get('matricula'));
			$session->clear('matricula');
			}
			
		$file_poder = '';
		if($session->get('poder') != ''){
			$ext = explode('.', $session->get('poder'));
			$extension = array_pop($ext);
			
			$file_poder = $id_cliente.'_poder_'.date('U').'.'.$extension;
			copy($ruta_tmp.$session->get('poder'), $ruta.$file_poder);
			
			unlink($ruta_tmp.$session->get('poder'));
			$session->clear('poder');
			}
		
		$query = 'INSERT INTO #__erp_clientes_info(
		`id_categoria`, `id_usuario_cobrador`, `id_usuario_mensajero`, `id_cliente`, `id_usuario`, 
		`empresa`, `nit`, `atache`, `direccion`, `ciudad`, 
		`zona`, `activo`, `fecha`, `capital`, `mat_fundempresa`, 
		`testimonio`, `casilla`, `fax`, `detalle`, `nombre`, 
		`apellido`, `poder`, `comentario_act`, `tipo_empresa`, `per_permanente`, 
		`per_eventual`, `cargo`, `file_nit`, `file_matricula`, `file_poder`
		) VALUES(';
		$query.= '"'.$id_categoria.'"';
		$query.= ', "'.$id_cobrador.'"';
		$query.= ', "'.$id_mensajero.'"';
		$query.= ', "'.$id_cliente.'"';
		$query.= ', "'.$id_usregistro.'"';
		
		$query.= ', "'.$empresa.'"';
		$query.= ', "'.$nit.'"';
		$query.= ', "'.$atache.'"';
		$query.= ', "'.$direccion.'"';
		$query.= ', "'.$ciudad.'"';
		
		$query.= ', "'.$zona.'"';
		$query.= ', "1"';
		$query.= ', NOW()';
		$query.= ', "'.$capital.'"';
		$query.= ', "'.$mat_fundem.'"';
		
		$query.= ', "'.$testimonio.'"';
		$query.= ', "'.$casilla.'"';
		$query.= ', "'.$fax.'"';
		$query.= ', "'.$detalle.'"';
		$query.= ', "'.$nombre.'"';
		
		$query.= ', "'.$apellido.'"';
		$query.= ', "'.$poder.'"';
		$query.= ', "'.$comentario_act.'"';
		$query.= ', "'.$tipo_empresa.'"';
		$query.= ', "'.$per_permanente.'"';
		
		$query.= ', "'.$per_eventual.'"';
		$query.= ', "'.$cargo.'"';
		$query.= ', "'.$file_nit.'"';
		$query.= ', "'.$file_matricula.'"';
		$query.= ', "'.$file_poder.'"';
		
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		$query = 'SELECT LAST_INSERT_ID()';
		$db->setQuery($query);  
		$id_info = $db->loadResult();
		
		$query = 'INSERT INTO #__erp_clientes_rel_estado(`id_usuario`, `id_cliente`, `id_estado`, `fecha`, `activo`) VALUES(';
		$query.= '"'.$id_cliente.'"';
		$query.= ', "'.$id_cliente.'"';
		$query.= ', "1"';
		$query.= ', NOW()';
		$query.= ', "1"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		
		newClienteInfo($id_cliente, $id_info);
			
        
        $rubros = JRequest::getVar('rubros', '', 'post');
		foreach($rubros as $rubro){
			$query = 'INSERT INTO cgn_erp_clientes_rubros(id_cliente, id_rubro) VALUES("'.$id_cliente.'", "'.$rubro.'")';
			$db->setQuery($query);  
			$db->query();
			}
		$valido = 1;
		
		newAccion('Registro de nuevo asociado "'.$empresa.'"');
		}else{
		$valido = 0;
		}
	return $valido;
	}
function newClienteInfo($id_cliente, $id_info, $id_info_ant = 0){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$empresa		= filtroCadena2(JRequest::getVar('empresa', '', 'post'));
	$nit			= JRequest::getVar('nit', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes_nit WHERE nit = "'.$nit.'" AND id_cliente = "'.$id_cliente.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	if($cant == 0){
        $query = 'UPDATE #__erp_clientes_nit SET principal = "0" WHERE  id_cliente = "'.$id_cliente.'"';
        $db->setQuery($query);  
		$db->query();
		$query = 'INSERT INTO #__erp_clientes_nit(`id_cliente`, `etiqueta`, `nombre`, `nit`, `principal`) VALUES(';
		$query.= '"'.$id_cliente.'"';
		$query.= ', "'.$empresa.'"';
		$query.= ', "'.$empresa.'"';
		$query.= ', "'.$nit.'"';
		$query.= ', "1"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	$testimonios = $session->get('testimonios');
	/*echo '<pre>';
	print_r($testimonios);
	echo '</pre>';*/
	$cont_doc = 0;
	$ruta = 'media/com_erp/archivos/'.$id_cliente.'/';
	$ruta_tmp = 'media/com_erp/tmp/';
	/*echo $ruta.'<br>';
	echo $ruta_temp.'<br>';*/
	foreach($testimonios as $test){
		$ext = explode('.', $test);
		$extension = array_pop($ext);
		
		$file_testimonio = $id_cliente.'_testimonio_'.date('U').'_'.rand().'.'.$extension;
		copy($ruta_tmp.$test, $ruta.$file_testimonio);
		
		/*echo $test.'<br>';
		echo $file_testimonio.'<br>';*/
		
		$query = 'INSERT INTO #__erp_clientes_documentos(`id_info`, `nombre`, `tipo`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "'.$file_testimonio.'"';
		$query.= ', "t"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		unlink($ruta_tmp.$test);
		$session->clear('testimonios');
		}
	
	if(count($testimonios) == 0){
		$query = 'SELECT * FROM #__erp_clientes_documentos WHERE id_info = "'.$id_info_ant.'" AND tipo = "t"';
		$db->setQuery($query);  
		$con = $db->loadObjectList();
		foreach($con as $c){
			$query = 'INSERT INTO #__erp_clientes_documentos(`id_info`, `nombre`, `tipo`) VALUES(';
			$query.= '"'.$id_info.'"';
			$query.= ', "'.$c->nombre.'"';
			$query.= ', "'.$c->tipo.'"';
			$query.= ')';
			$db->setQuery($query);  
			$db->query();
			}
		}
	
	$session->clear('testimonios');
	
	$cont = JRequest::getVar('correoe', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "e"';
		$query.= ', "'.$val.'"';
		$query.= ', "e"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
		
	$cont = JRequest::getVar('telefono', '', 'post');
    $exten = JRequest::getVar('extension','','post');
    $contad = 0;
	foreach($cont as $val){        
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "t"';
		$query.= ', "'.$val.'|'.$exten[$contad].'"';
		$query.= ', "e"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
        $contad++;
		}
		
	$cont = JRequest::getVar('econtact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "e"';
		$query.= ', "'.$val.'"';
		$query.= ', "c"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
		
	$cont = JRequest::getVar('telfcontact', '', 'post');
    $exten = JRequest::getVar('extensionc','','post');
    $contad = 0;
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "t"';
		$query.= ', "'.$val.'|'.$exten[$contad].'"';
		$query.= ', "c"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
		
	$cont = JRequest::getVar('celcontact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "c"';
		$query.= ', "'.$val.'"';
		$query.= ', "c"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	$cont = JRequest::getVar('actividad', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_actividades(`id_info`, `id_actividad`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "'.$val.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		//echo $query;
		}
	
	$suc = JRequest::getVar('sucursal', '', 'post');
	foreach($suc as $s){
		$query = 'INSERT INTO #__erp_clientes_sucursales(`id_info`, `id_departamento`) VALUES(';
		$query.= '"'.$id_info.'"';
		$query.= ', "'.$s.'"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		//echo $query;
		}
	}
function verificaClienteEmpresa(){
	$db =& JFactory::getDBO();
	$query = 'SELECT id_empresa FROM #__erp_rel_cliente_empresa WHERE id_cliente = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$id = $db->loadresult();
	return $id;
	}
function editCliente(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	
	$query = 'SELECT `id`, `file_nit`, `file_matricula`, `file_testimonio`, `file_poder` FROM #__erp_clientes_info WHERE id_cliente = "'.$id_cliente.'" AND activo = "1"';
	$db->setQuery($query);
	$info_ant = $db->loadObject();
	
	$ruta = 'media/com_erp/archivos/'.$id_cliente.'/';
	if(!file_exists ($ruta)){
		if(!mkdir($ruta, 0777, true))
			$session->set('error', 'No se pudo crear el directorio para el asociado '.$empresa);	
		}
	
	$query = 'UPDATE #__erp_clientes_info SET activo = "0" WHERE id_cliente = "'.$id_cliente.'"';
	$db->setQuery($query);  
	$db->query();
	
	$id_categoria	= JRequest::getVar('id_categoria', '', 'post');
	$id_estado		= JRequest::getVar('id_estado', '', 'post');
	$id_cobrador	= JRequest::getVar('id_cobrador', '', 'post');
	$id_mensajero	= JRequest::getVar('id_mensajero', '', 'post');
	
	$empresa		= filtroCadena2(JRequest::getVar('empresa', '', 'post'));
	$nit			= JRequest::getVar('nit', '', 'post');
	$atache			= JRequest::getVar('atache', '', 'post');
	$direccion		= filtroCadena2(JRequest::getVar('direccion', '', 'post'));
	
	$ciudad			= JRequest::getVar('ciudad', '', 'post');
	$zona			= JRequest::getVar('zona', '', 'post');
	$capital		= JRequest::getVar('capital', '', 'post');
	
	$mat_fundem		= JRequest::getVar('mat_fundem', '', 'post');
	$testimonio		= JRequest::getVar('testimonio', '', 'post');
	$casilla		= JRequest::getVar('casilla', '', 'post');
	$fax			= JRequest::getVar('fax', '', 'post');
	$detalle		= filtroCadena2(JRequest::getVar('detalle', '', 'post'));
	
	$nombre			= JRequest::getVar('nombre', '', 'post');
	$apellido		= JRequest::getVar('apellido', '', 'post');
	$poder			= JRequest::getVar('poder', '', 'post');
	$comentario_act	= JRequest::getVar('comentario_act', '', 'post');
	$tipo_empresa	= JRequest::getVar('tipo_empresa', '', 'post');
	$per_permanente	= JRequest::getVar('per_permanente', '', 'post');
	$per_eventual	= JRequest::getVar('per_eventual', '', 'post');
	$estado			= JRequest::getVar('estado', '', 'post');
	$motivo			= JRequest::getVar('motivo', '', 'post');
	
	$cargo		= JRequest::getVar('cargo', '', 'post');
		
	$ruta_tmp = 'media/com_erp/tmp/';
	
	$file_nit = $info_ant->file_nit;
	if($session->get('nit') != ''){
		$ext = explode('.', $session->get('nit'));
		$extension = array_pop($ext);
		
		$file_nit = $id_cliente.'_nit_'.date('U').'.'.$extension;
		copy($ruta_tmp.$session->get('nit'), $ruta.$file_nit);
		
		$session->clear('nit');
		unlink($ruta_tmp.$session->get('nit'));
		}
	
	$file_matricula = $info_ant->file_matricula;
	if($session->get('matricula') != ''){
		$ext = explode('.', $session->get('matricula'));
		$extension = array_pop($ext);
		
		$file_matricula = $id_cliente.'_matricula_'.date('U').'.'.$extension;
		copy($ruta_tmp.$session->get('matricula'), $ruta.$file_matricula);
		
		$session->clear('matricula');
		unlink($ruta_tmp.$session->get('matricula'));
		}
		
	$file_poder = $info_ant->file_poder;
	if($session->get('poder') != ''){
		$ext = explode('.', $session->get('poder'));
		$extension = array_pop($ext);
		
		$file_poder = $id_cliente.'_poder_'.date('U').'.'.$extension;
		copy($ruta_tmp.$session->get('poder'), $ruta.$file_poder);
		
		$session->clear('poder');
		unlink($ruta_tmp.$session->get('poder'));
		}
	
	$query = 'INSERT INTO #__erp_clientes_info(
	`id_categoria`, `id_usuario_cobrador`, `id_usuario_mensajero`, `id_cliente`, 
	`id_usuario`, `empresa`, `nit`, `atache`, `direccion`, 
	`ciudad`, `zona`, `activo`, `fecha`, `capital`, 
	`mat_fundempresa`, `testimonio`, `casilla`, `fax`, `detalle`,
	`nombre`, `apellido`, `poder`, `comentario_act`, `tipo_empresa`, 
	`per_permanente`, `per_eventual`, `cargo`, 
	`file_nit`, `file_matricula`, `file_poder`
	) VALUES(';
	$query.= '"'.$id_categoria.'"';
	//$query.= ', "'.$id_estado.'"';
	$query.= ', "'.$id_cobrador.'"';
	$query.= ', "'.$id_mensajero.'"';
	$query.= ', "'.$id_cliente.'"';
	
	$query.= ', "'.$user->id.'"';//', "'.$id_usregistro.'"';
	$query.= ', "'.$empresa.'"';
	$query.= ', "'.$nit.'"';
	$query.= ', "'.$atache.'"';
	$query.= ', "'.$direccion.'"';
	
	$query.= ', "'.$ciudad.'"';
	$query.= ', "'.$zona.'"';
	$query.= ', "1"';
	$query.= ', NOW()';
	$query.= ', "'.$capital.'"';
	
	$query.= ', "'.$mat_fundem.'"';
	$query.= ', "'.$testimonio.'"';
	$query.= ', "'.$casilla.'"';
	$query.= ', "'.$fax.'"';
	$query.= ', "'.$detalle.'"';
	
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$apellido.'"';
	$query.= ', "'.$poder.'"';
	$query.= ', "'.$comentario_act.'"';
	$query.= ', "'.$tipo_empresa.'"';
	
	$query.= ', "'.$per_permanente.'"';
	$query.= ', "'.$per_eventual.'"';
	//$query.= ', "'.$estado.'"';
	//$query.= ', "'.$motivo.'"';
	$query.= ', "'.$cargo.'"';
	
	$query.= ', "'.$file_nit.'"';
	$query.= ', "'.$file_matricula.'"';
	$query.= ', "'.$file_poder.'"';
	
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);  
	$id_info = $db->loadResult();
	
    $query = 'DELETE FROM #__erp_clientes_rubros WHERE id_cliente= "'.$id_cliente.'"';
    $db->setQuery($query);  
    $db->query();

    $rubros = JRequest::getVar('rubros', '', 'post');
    foreach($rubros as $rubro){
        $query = 'INSERT INTO #__erp_clientes_rubros(id_cliente, id_rubro) VALUES("'.$id_cliente.'", "'.$rubro.'")';
        $db->setQuery($query);  
        $db->query();
    }
	newClienteInfo($id_cliente, $id_info, $info_ant->id);
	}
function getClienteDocs($id, $t = 't'){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_clientes_documentos WHERE id_info = "'.$id.'"';
	$db->setQuery($query);  
	$docs = $db->loadObjectList();
	
	return $docs;
	}
function deleteCliente(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_clientes SET eliminado = "1" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function publicaCliente(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('estado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__erp_clientes SET bloqueado = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function destacaCliente(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('estado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__erp_clientes SET destacado = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function getClienteAct($id_info, $id_actividad){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes_actividades WHERE id_info = "'.$id_info.'" AND id_actividad = "'.$id_actividad.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant > 0)
		$val = 1;
		else
		$val = 0;
	
	return $val;
	}
function getClienteSucursales($id_info, $id_departamento){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes_sucursales WHERE id_info = "'.$id_info.'" AND id_departamento = "'.$id_departamento.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant > 0)
		$val = 1;
		else
		$val = 0;
	
	return $val;
	}

// Productos
function getProductos($id_categoria = 0, $destacado = ''){
	$where = '';
	if($id_categoria != 0)
		$where.= ' AND i.category_id = "'.$id_categoria.'"';
	if($destacado != '' && $destacado != 0){
		if($destacado == 2)
			$destacado = 0;
		$where.= ' AND i.destacado = "'.$destacado.'"';
		}
		
	$db =& JFactory::getDBO();  
	$query = 'SELECT i.*, p.price, c.name AS category, u.unidad, SUM(cant.cantidad) AS cantidad 
	FROM #__erp_producto_items AS i 
	LEFt JOIN #__erp_producto_precio AS p ON i.id = p.id_producto 
	LEFT JOIN #__erp_producto_categories AS c ON i.category_id = c.id 
	LEFT JOIN #__erp_producto_unidades AS u ON i.id_unidad = u.id 
	LEFT JOIN #__erp_producto_cantidad AS cant ON i.id = cant.id_producto 
	WHERE i.fijo = "0" '.$where.'
	GROUP BY i.id
	ORDER BY i.category_id ASC, i.orden ASC';
	$db->setQuery($query);  
	$productos = $db->loadObjectList();
	return $productos;
	}
function getProductosCodigo(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT i.*, p.price, c.name AS category, u.unidad, SUM(cant.cantidad) AS cantidad 
	FROM #__erp_producto_items AS i 
	LEFt JOIN #__erp_producto_precio AS p ON i.id = p.id_producto 
	LEFT JOIN #__erp_producto_categories AS c ON i.category_id = c.id 
	LEFT JOIN #__erp_producto_unidades AS u ON i.id_unidad = u.id 
	LEFT JOIN #__erp_producto_cantidad AS cant ON i.id = cant.id_producto 
	WHERE 1 AND i.published = "1" AND i.codigo LIKE "%'.JRequest::getVar('codigo', '', 'post').'%" 
	GROUP BY i.id
	ORDER BY i.category_id';
	$db->setQuery($query);  
	$productos = $db->loadObjectList();
    /*echo $query;*/
	return $productos;
   
	}
function getProducto($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();  
	$query = 'SELECT i.*, p.price, c.name AS category 
	FROM #__erp_producto_items AS i 
	LEFt JOIN #__erp_producto_precio AS p ON i.id = p.id_producto 
	LEFT JOIN #__erp_producto_categories AS c ON i.category_id = c.id 
	WHERE 1 AND i.id = "'.$id.'"';
	$db->setQuery($query);  
	$plato = $db->loadObject();
	return $plato;
	}
function getProductoPrecios($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_producto_precio WHERE id_producto = "'.$id.'"';
	$db->setQuery($query);  
	$precios = $db->loadObjectList();
	return $precios;
	}
function newProducto(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$empresa		= getEmpresa();
	$codigo			= JRequest::getVar('codigo', '', 'post');
	$name			= JRequest::getVar('name', '', 'post');
	$descripcion	= JRequest::getVar('descripcion', '', 'post');
	$alias			= alias(JRequest::getVar('name', '', 'post'));
	$category_id	= JRequest::getVar('category_id', '', 'post');
	$id_unidad		= JRequest::getVar('id_unidad', '', 'post');
	$cantidad		= JRequest::getVar('cantidad', '', 'post');
	$id_ctacontable	= JRequest::getVar('cuenta_debe_id', '', 'post');
	$id_auxiliar	= JRequest::getVar('cuenta_aux_id', '', 'post');
	
	if(!empty($_FILES['imagen']['name'])){
		$ext = explode('.',$_FILES['imagen']['name']);
		$origen = 'media/com_erp/productos/thumbs/tmp_'.$alias.'.'.strtolower($ext[1]);
		copy($_FILES['imagen']['tmp_name'],$origen);
		list($ancho, $alto, $tipo, $atributos) = getimagesize($origen);
		if($ancho >= 300 && $alto >= 300){
			
			creaImagenMini($origen,90,90);
			
			$origen = 'media/com_erp/productos/tmp_'.$alias.'.'.($ext[1]);
			copy($_FILES['imagen']['tmp_name'],$origen);
			creaImagenMini($origen,300,300);
			$query_img_field.= ', `image`';
			$query_img_value.= ', "'.$alias.'.jpg"';
			}
			else
			echo 'La imagen adjuntada debe ser mayor a 300px de ancho por 300px de alto';
		}
	$query = 'INSERT INTO #__erp_producto_items(`category_id`, `id_ctacontable`, `id_auxiliar`, `codigo`, `id_unidad`, `name`, `alias`, `description`'.$query_img_field.') VALUES(';
	$query.= '"'.$category_id.'"';
	$query.= ', "'.$id_ctacontable.'"';
	$query.= ', "'.$id_auxiliar.'"';
	$query.= ', "'.strtoupper($codigo).'"';
	$query.= ', "'.$id_unidad.'"';
	$query.= ', "'.ucfirst($name).'"';
	$query.= ', "'.$alias.'"';
	$query.= ', "'.$descripcion.'"';
	$query.= $query_img_value;
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT id FROM #__erp_producto_items ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	$precio	= JRequest::getVar('precio_base', '', 'post');
	$nombre	= JRequest::getVar('p_descripcion', '', 'post');
	
	for($i=0; $i<count($precio); $i++){
		$query = 'INSERT INTO #__erp_producto_precio(id_producto, nombre, price) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$nombre[$i].'"';
		$query.= ', "'.$precio[$i].'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();	
		}
	
	newAccion('Crea nuevo producto "'.$name.'"');
	}
function addProducto(){
	$user =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$cantidad		= JRequest::getVar('cantidad', '', 'post');
	
	$query = 'INSERT INTO #__erp_producto_cantidad(`id_usuario`, `id_producto`, `cantidad`, `fecha`) VALUES(';
	$query.= '"'.$user->get('id').'"';
	$query.= ', "'.JRequest::getVar('id', '', 'get').'"';
	$query.= ', "'.$cantidad.'"';
	$query.= ', NOW()';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	}
function editProducto(){
	$db =& JFactory::getDBO();
	$empresa		= getEmpresa();
	$id				= JRequest::getVar('id', '', 'get');
	$name			= JRequest::getVar('name', '', 'post');
	$id_origen		= $empresa->id_pais;
	$codigo			= JRequest::getVar('codigo', '', 'post');
	$price			= JRequest::getVar('precio_base', '', 'post');
	$descripcion	= JRequest::getVar('descripcion', '', 'post');
	$category_id	= JRequest::getVar('category_id', '', 'post');
	$id_unidad		= JRequest::getVar('id_unidad', '', 'post');
	$alias			= alias($name);
	$id_ctacontable	= JRequest::getVar('cuenta_debe_id', '', 'post');
	$id_ctaaux		= JRequest::getVar('cuenta_aux_id', '', 'post');
	
	if(!empty($_FILES['imagen']['name'])){
		$ext = explode('.',$_FILES['imagen']['name']);
		$origen = 'media/com_erp/productos/thumbs/tmp_'.$alias.'.'.strtolower($ext[1]);
		copy($_FILES['imagen']['tmp_name'],$origen);
		list($ancho, $alto, $tipo, $atributos) = getimagesize($origen);
		if($ancho >= 300 && $alto >= 300){
			@unlink('media/com_erp/productos/thumbs/'.$alias.'.'.$ext[1]);
			creaImagenMini($origen,90,90);
			
			$origen = 'media/com_erp/productos/tmp_'.$alias.'.'.strtolower($ext[1]);
			@unlink('media/com_erp/productos/'.$alias.'.'.$ext[1]);
			copy($_FILES['imagen']['tmp_name'],$origen);
			creaImagenMini($origen,200,200);
			$query_img.= ', `image` = "'.$alias.'.jpg"';
			}
			else
			echo 'La imagen adjuntada debe ser mayor a 300px de ancho por 300px de alto';
		}
	$query = 'UPDATE #__erp_producto_items SET ';
	$query.= '`category_id` = "'.$category_id.'"';
	$query.= ', `id_unidad` = "'.$id_unidad.'"';
	$query.= ', `codigo` = "'.$codigo.'"';
	$query.= ', `id_ctacontable` = "'.$id_ctacontable.'"';
	$query.= ', `id_auxiliar` = "'.$id_ctaaux.'"';
	$query.= ', `name` = "'.$name.'"';
	$query.= ', `description` = "'.$descripcion.'"';
	$query.= $query_img;
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	$precio	= JRequest::getVar('precio_base', '', 'post');
	$nombre	= JRequest::getVar('p_descripcion', '', 'post');
	
	$query = 'DELETE FROM #__erp_producto_precio WHERE id_producto = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	
	for($i=0; $i<count($precio); $i++){
		$query = 'INSERT INTO #__erp_producto_precio(id_producto, nombre, price) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$nombre[$i].'"';
		$query.= ', "'.$precio[$i].'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();	
		}
	}
function deleteProducto(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_producto_items WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'DELETE FROM #__erp_producto_precio WHERE id_producto = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function publicaProducto(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('estado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__erp_producto_items SET published = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Cambió Estado del Producto');
	}
function destacaProducto(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('destacado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__erp_producto_items SET destacado = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function ordenaProducto(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_producto_items ORDER BY id ASC';
	$db->setQuery($query);  
	$items = $db->loadObjectList();
	
	foreach($items as $item){
		$query = 'UPDATE #__erp_producto_items SET orden = "'.JRequest::getVar('orden_'.$item->id, '', 'post').'" WHERE id = "'.$item->id.'"';
		$db->setQuery($query);  
		$db->query();
		}
	}

// Unidades
function getUnidades(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_producto_unidades WHERE 1';
	$db->setQuery($query);  
	$unidades = $db->loadObjectList();
	return $unidades;
	}
function getUnidad($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_producto_unidades WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$unidad = $db->loadObject();
	return $unidad;
	}
function newUnidad(){
	$db =& JFactory::getDBO();
	$unidad = JRequest::getVar('unidad', '', 'post');
	$simbolo = JRequest::getVar('simbolo', '', 'post');
	$query = 'INSERT INTO #__erp_producto_unidades(`unidad`, `simbolo`) VALUES(';
	$query.= '"'.$unidad.'"';
	$query.= ', "'.$simbolo.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	newAccion('Crea unidad "'.$unidad.'"');
	}
function editUnidad(){
	$db =& JFactory::getDBO();
	$unidad = JRequest::getVar('unidad', '', 'post');
	$simbolo = JRequest::getVar('simbolo', '', 'post');
	$query = 'UPDATE #__erp_producto_unidades SET ';
	$query.= '`unidad` = "'.$unidad.'"';
	$query.= ', `simbolo` = "'.$simbolo.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function deleteUnidad(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_producto_unidades WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó unidad "'.$unidad.'"');
	}

// Categoría de Productos
function getCategorias(){
	$db =& JFactory::getDBO();
	$query = 'SELECT c.*, p.name AS padre 
	FROM #__erp_producto_categories AS c 
	LEFT JOIN #__erp_producto_categories AS p ON c.parent_id = p.id 
	WHERE c.fijo = "0" ORDER BY parent_id, orden, name';
	$db->setQuery($query);  
	$categorias = $db->loadObjectList();
	return $categorias;
	}
function getCategoria($id = 0){
	$db =& JFactory::getDBO();
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT c.*, p.name AS padre 
	FROM #__erp_producto_categories AS c 
	LEFT JOIN #__erp_producto_categories AS p ON c.parent_id = p.id
	WHERE c.id = "'.$id.'"';
	$db->setQuery($query);  
	$category = $db->loadObject();
	return $category;
	}
function newCategorias(){
	$db =& JFactory::getDBO();
	$parent 	= JRequest::getVar('category_id', '', 'post');
	$name 		= JRequest::getVar('name', '', 'post');
	$alias 		= alias(JRequest::getVar('name', '', 'post'));
	$tipo 		= JRequest::getVar('tipo', '', 'post');
	$adicional 	= JRequest::getVar('adicional', '', 'post');
	
	$query = 'INSERT INTO #__erp_producto_categories(`parent_id`, `name`, `alias`, `tipo`, `adicional`) VALUES(';
	$query.= '"'.$parent.'"';
	$query.= ', "'.$name.'"';
	$query.= ', "'.$alias.'"';
	$query.= ', "'.$tipo.'"';
	$query.= ', "'.$adicional.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	newAccion('Crea nueva categoría de producto "'.$name.'"');
	}
function publishedCategoria(){
	$db =& JFactory::getDBO();
	if(JRequest::getVar('estado', '', 'get') == 1)
		$v = 0;
		else
		$v = 1;
	
	$query.= 'UPDATE #__erp_producto_categories SET published = "'.$v.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Cambió estado del Producto');
	}
function editCategoria(){
	$db =& JFactory::getDBO();
	$parent = JRequest::getVar('category_id', '', 'post');
	$name = JRequest::getVar('name', '', 'post');
	$alias = JRequest::getVar('alias', '', 'post');
	$tipo = JRequest::getVar('tipo', '', 'post');
	$adicional = alias(JRequest::getVar('adicional', '', 'post'));
	
	$query = 'UPDATE #__erp_producto_categories SET ';
	$query.= '`name` = "'.$name.'"';
	$query.= ', `parent_id` = "'.$parent.'"';
	$query.= ', `alias` = "'.$alias.'"';
	$query.= ', `tipo` = "'.$tipo.'"';
	$query.= ', `adicional` = "'.$adicional.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó categoría de producto "'.$name.'"');
	}
function printCategorias($id, $tipo, $nivel, $valor=0){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_producto_categories WHERE fijo = "0" AND parent_id = "'.$id.'" ORDER BY orden';
	$db->setQuery($query);  
	$categories = $db->loadObjectList();
	
	$fuente = 25;
	$indent = '';
	if($nivel > 0){
		$indent = '|';
		for($i=0; $i<$nivel; $i++){
			$indent.= '-';	
			$fuente-= 7;
			}
		$indent.= '&rarr; ';
		$display = ' style="display:none"';
		}
	
	if($tipo != 'option')
		echo '<div class="accordion-group" id="child_'.$id.'" '.$display.'>';
	foreach($categories as $cat){
		if($tipo == 'option'){
			if($cat->id == $valor)
				$selected = 'selected';
				else
				$selected = '';
			echo '<option value="'.$cat->id.'" '.$selected.'>'.$indent.$cat->name;'</option>';
			if(haschildCategorias($cat->id))
				printCategorias($cat->id, $tipo, ($nivel + 1), $valor);
			}else{
			echo '<div id="cat'.$cat->id.'" class="categoria" style="margin-bottom:4px"><h2><a href="#" id="link_'.$cat->id.'" style="padding:10px; display:block; font-size:'.$fuente.'px" onclick="cargaMenu(this.id); abre(this.id)" class="btn">'.$cat->name.'</a></h2>';
			if(haschildCategorias($cat->id))
				printCategorias($cat->id, $tipo, ($nivel + 1), $valor);
			echo '</div>';
			}
		}
	if($tipo != 'option')
		echo '</div>';
	}
function deleteCategoria(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_producto_categories WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
	}
function haschildCategorias($id){
	$db =& JFactory::getDBO();  
	$query = 'SELECT COUNT(id) AS cantidad FROM #__erp_producto_categories WHERE parent_id = "'.$id.'"';
	$db->setQuery($query);  
	$categories = $db->loadResult();
	if($categories > 0)
		return true;
		else
		return false;
	}
function ordenaCategoria(){
	$db =& JFactory::getDBO();  
	$query = 'SELECT * FROM #__erp_producto_categories ORDER BY id ASC';
	$db->setQuery($query);  
	$categories = $db->loadObjectList();
	
	foreach($categories as $cat){
		$query = 'UPDATE #__erp_producto_categories SET orden = "'.JRequest::getVar('orden_'.$cat->id, '', 'post').'" WHERE id = "'.$cat->id.'"';
		$db->setQuery($query);  
		$db->query();
		}
	}
//

// Sucursales
function getSucursales(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT * FROM #__erp_sucursales WHERE id_empresa = "'.$session->get('ide').'" ORDER BY departamento, nombre';
	$db->setQuery($query);  
	$sucursales = $db->loadObjectList();
	return $sucursales;
	}
function getSucursal($id = 0){
	$db =& JFactory::getDBO();
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$query = 'SELECT * FROM #__erp_sucursales WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$sucursal = $db->loadObject();
	return $sucursal;
	}
function getSucursalUsuario($id = 0){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	if($id == 0){
		if(JRequest::getVar('id', '', 'get') != '')
			$id = JRequest::getVar('id', '', 'get');
			else
			$id = $user->get('id');
		}
	$query = 'SELECT s.* 
	FROM #__erp_sucursales AS s 
	LEFT JOIN #__erp_rel_usuario_sucursal AS r ON s.id = r.id_sucursal 
	WHERE r.id_usuario = "'.$id.'"';
	$db->setQuery($query);  
	$sucursal = $db->loadObject();
	return $sucursal;
	}
function getIdSucursalUsuario(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	$query = 'SELECT id_sucursal FROM #__erp_rel_usuario_sucursal WHERE id_usuario = "'.$user->get('id').'"';
	$db->setQuery($query);  
	$id_sucursal = $db->loadResult();
	return $id_sucursal;
	}

function newSucursal(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$id_empresa 	= $session->get('ide');
	$departamento	= JRequest::getVar('departamento', '', 'post');
	$nombre			= JRequest::getVar('nombre', '', 'post');
	$codigo			= JRequest::getVar('codigo', '', 'post');
	$direccion		= JRequest::getVar('direccion', '', 'post');
	$telefono		= JRequest::getVar('telefono', '', 'post');
	
	$query = 'INSERT INTO #__erp_sucursales(`id_empresa`, `departamento`, `nombre`, `codigo`, `direccion`, `telefono`) VALUES(';
	$query.= '"'.$id_empresa.'"';
	$query.= ', "'.$departamento.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$codigo.'"';
	$query.= ', "'.$direccion.'"';
	$query.= ', "'.$telefono.'"';
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 1, 550, 50, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 2, 560, 75, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 3, 235, 145, 11, 280, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 4, 570, 145, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 5, 250, 175, 11, 250, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 6, 55, 205, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 7, 90, 205, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 8, 130, 205, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 9, 50, 255, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 10, 50, 230, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 11, 148, 230, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 12, 147, 255, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 13, 70, 285, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 14, 60, 330, 11, 102, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 15, 220, 350, 11, 350, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 16, 290, 370, 11, 200, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 17, 327, 396, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 18, 195, 220, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 19, 255, 220, 11, 317, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 20, 585, 220, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 21, 595, 325, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 23, 50, 201, 11, 0, 1)';
	$db->setQuery($query);  
	$db->query();
	
	
	
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 24, 190, 415, 10, 390, 1)';
	$db->setQuery($query);  
	$db->query();
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 25, 593, 385, 11, 100, 1)';
	$db->setQuery($query);  
	$db->query();			
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 27, 535, 95, 11, 150, 1)';
	$db->setQuery($query);  
	$db->query();			
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 29, 360, 110, 10, 330, 1)';
	$db->setQuery($query);  
	$db->query();			
	
	$query = 'INSERT INTO #__erp_facturacion_impreso_posicion (id_sucursal, id_campo, pos_x, pos_y, tam_fuente, ancho, visible) VALUES';
	$query .= '('.$id.', 30, 180, 20, 10, 130, 1)';
	$db->setQuery($query);  
	$db->query();			
	
	newAccion('Crea nueva sucursal "'.$nombre.'"');
	}
function editSucursal(){
	$db =& JFactory::getDBO();
	$departamento	= JRequest::getVar('departamento', '', 'post');
	$nombre			= JRequest::getVar('nombre', '', 'post');
	$codigo			= JRequest::getVar('codigo', '', 'post');
	$direccion		= JRequest::getVar('direccion', '', 'post');
	$telefono		= JRequest::getVar('telefono', '', 'post');
	$query = 'UPDATE #__erp_sucursales SET ';
	$query.= '`departamento` = "'.$departamento.'"';
	$query.= ',`nombre` = "'.$nombre.'"';
	$query.= ',`codigo` = "'.$codigo.'"';
	$query.= ',`direccion` = "'.$direccion.'"';
	$query.= ',`telefono` = "'.$telefono.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$db->query();
    newAccion('Editó Sucursal "'.$name.'"');
	}
function deleteSucursal(){
	$db =& JFactory::getDBO();
    $query = 'SELECT nombre FROM #__erp_sucursales WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
    $db->setQuery($query);  
	$nombre = $db->loadResult();
    newAccion('Borró Sucursal '.$nombre);
    
	$query = 'DELETE FROM #__erp_sucursales WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}

// Proformas
function newProforma(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	$nombre = JRequest::getVar('cliente', '', 'post');
	$id_empresa = JRequest::getVar('id_empresa', '', 'post');
	$fono = JRequest::getVar('fono', '', 'post');
	$celular = JRequest::getVar('celular', '', 'post');
	$email = JRequest::getVar('email', '', 'post');
	$validez = JRequest::getVar('validez', '', 'post').' '.JRequest::getVar('validez_tipo', '', 'post');
	$entrega = JRequest::getVar('entrega', '', 'post').' '.JRequest::getVar('entrega_tipo', '', 'post');
	$nota = JRequest::getVar('nota', '', 'post');
	
	$query = 'INSERT INTO #__erp_proforma_cabecera(`id_usuario`, `id_cliente`, `nombre`, `fono`, `celular`, `email`, `id_empresa`, `fecha`, `hora`, `validez`, `entrega`, `nota`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_cliente.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$fono.'"';
	$query.= ', "'.$celular.'"';
	$query.= ', "'.$email.'"';
	$query.= ', "'.$id_empresa.'"';
	$query.= ', NOW()';
	$query.= ', NOW()';
	$query.= ', "'.$validez.'"';
	$query.= ', "'.$entrega.'"';
	$query.= ', "'.$nota.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT id FROM #__erp_proforma_cabecera ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	$total = 0;
	for($i=0; $i<count($_POST['cantidad']); $i++){
		$query = 'INSERT INTO #__erp_proforma_detalle(`id_proforma`, `codigo`, `cantidad`, `detalle`, `precio`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$_POST['codigo'][$i].'"';
		$query.= ', "'.$_POST['cantidad'][$i].'"';
		$query.= ', "'.$_POST['detalle'][$i].'"';
		$query.= ', "'.$_POST['precio'][$i].'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		$total+= $_POST['precio'][$i] * $_POST['cantidad'][$i];
		}
		
	$query = 'UPDATE #__erp_proforma_cabecera SET total = "'.$total.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Genera proforma');
	
	return $id;
	}
function editProforma(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	$nombre = JRequest::getVar('cliente', '', 'post');
	$id_empresa = JRequest::getVar('id_empresa', '', 'post');
	$fono = JRequest::getVar('fono', '', 'post');
	$celular = JRequest::getVar('celular', '', 'post');
	$email = JRequest::getVar('email', '', 'post');
	$validez = JRequest::getVar('validez', '', 'post').' '.JRequest::getVar('validez_tipo', '', 'post');
	$entrega = JRequest::getVar('entrega', '', 'post').' '.JRequest::getVar('entrega_tipo', '', 'post');
	$nota = JRequest::getVar('nota', '', 'post');
	
	$query = 'UPDATE #__erp_proforma_cabecera SET ';
	$query.= '`id_usuario` = "'.$id_usuario.'"';
	$query.= ', `id_cliente` = "'.$id_cliente.'"';
	$query.= ', `nombre` = "'.$nombre.'"';
	$query.= ', `fono` = "'.$fono.'"';
	$query.= ', `celular` = "'.$celular.'"';
	$query.= ', `email` = "'.$email.'"';
	$query.= ', `id_empresa` = "'.$id_empresa.'"';
	$query.= ', `validez` = "'.$validez.'"';
	$query.= ', `entrega` = "'.$entrega.'"';
	$query.= ', `nota` = "'.$nota.'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	
	$query = 'DELETE FROM #__erp_proforma_detalle WHERE id_proforma = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	$id = JRequest::getVar('id', '', 'get');
	
	$total = 0;
	for($i=0; $i<count($_POST['cantidad']); $i++){
		$query = 'INSERT INTO #__erp_proforma_detalle(`id_proforma`, `codigo`, `cantidad`, `detalle`, `precio`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$_POST['codigo'][$i].'"';
		$query.= ', "'.$_POST['cantidad'][$i].'"';
		$query.= ', "'.$_POST['detalle'][$i].'"';
		$query.= ', "'.$_POST['precio'][$i].'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		$total+= $_POST['precio'][$i] * $_POST['cantidad'][$i];
		}
		
	$query = 'UPDATE #__erp_proforma_cabecera SET total = "'.$total.'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Editó proforma');    
	}
function getProformas(){
	$db =& JFactory::getDBO();
	$where = '';
	if(JRequest::getVar('filtro', '', 'post') != ''){
		$where = ' WHERE p.nombre LIKE "%'.JRequest::getVar('filtro', '', 'post').'%" ';
    }
	$query = 'SELECT p.* 
	FROM #__erp_proforma_cabecera AS p'.$where.' 
	ORDER BY p.id DESC';
    //echo $query;
	$db->setQuery($query);  
	$proformas = $db->loadObjectList();
	return $proformas;
	}
function getProforma(){
	$db =& JFactory::getDBO();
	$query = 'SELECT p.*, p.id AS numero, c.empresa, i.nombre, i.apellido  
	FROM #__erp_proforma_cabecera AS p 
	LEFT JOIN #__erp_crm_prospecto AS c ON p.id_cliente = c.id
	LEFT JOIN #__erp_crm_contacto_prospecto AS i ON c.id = i.id_prospecto
	WHERE p.id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$proforma = $db->loadObject();
	return $proforma;
	}
function getProformaDetalle(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_proforma_detalle WHERE id_proforma = "'.JRequest::getVar('id', '', 'get').'" ORDER BY id';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
	return $detalle;
	}

function newPlantilla($t){
	$db =& JFactory::getDBO();
	
	if($t == 'f')
		$id_extension = 6;
		else
		$id_extension = 3;
	
	$nombre = JRequest::getVar('nombre', '', 'post');
	$plantilla = filtroCadena(JRequest::getVar('plantilla', '', 'post','STRING',JREQUEST_ALLOWHTML));
	
	$query = 'INSERT INTO #__erp_plantilla(`id_extension`, `nombre`, `plantilla`) VALUES(';
	$query.= '"'.$id_extension.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$plantilla.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
    newAccion('Creó Plantilla '.$nombre);    

	}
function getPlantilla($id, $idtmpl){
	$db =& JFactory::getDBO();
	
	if($idtmpl != '')
		$where = 'id = "'.$idtmpl.'"';
		else
		$where = 'id_extension = "'.$id.'" AND predeterminado = 1';
	
	$query = 'SELECT plantilla FROM #__erp_plantilla WHERE '.$where;
	$db->setQuery($query);  
	$plantilla = $db->loadResult();
	return $plantilla;
	}
function getPlantillas($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_plantilla WHERE id_extension = "'.$id.'"';
	$db->setQuery($query);  
	$plantillas = $db->loadObjectList();
	return $plantillas;
	}
function changePlantilla($id){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_plantilla SET predeterminado = "0" WHERE id_extension = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	$query = 'UPDATE #__erp_plantilla SET predeterminado = "1" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
    newAccion('Cambió de plantilla id '.$id);
	}
// Proformas
function newNota(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id_usuario = $user->get('id');
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	$nombre = JRequest::getVar('cliente', '', 'post');
	$id_empresa = JRequest::getVar('id_empresa', '', 'post');
	$fono = JRequest::getVar('fono', '', 'post');
	$celular = JRequest::getVar('celular', '', 'post');
	$email = JRequest::getVar('email', '', 'post');
	$total = JRequest::getVar('total', '', 'post');
	$descuento = JRequest::getVar('descuento', '', 'post');
	
	$query = 'INSERT INTO #__erp_nota_cabecera(`id_usuario`, `id_cliente`, `nombre`, `fono`, `celular`, `email`, `id_empresa`, `fecha`, `hora`, `total`, `descuento`) VALUES(';
	$query.= '"'.$id_usuario.'"';
	$query.= ', "'.$id_cliente.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$fono.'"';
	$query.= ', "'.$celular.'"';
	$query.= ', "'.$email.'"';
	$query.= ', "'.$id_empresa.'"';
	$query.= ', NOW()';
	$query.= ', NOW()';
	$query.= ', "'.$total.'"';
	$query.= ', "'.$descuento.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT id FROM #__erp_nota_cabecera ORDER BY id DESC LIMIT 1';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	for($i=0; $i<count($_POST['cantidad']); $i++){
		$query = 'INSERT INTO #__erp_nota_detalle(`id_nota`, `codigo`, `cantidad`, `detalle`, `precio`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "'.$_POST['codigo'][$i].'"';
		$query.= ', "'.$_POST['cantidad'][$i].'"';
		$query.= ', "'.$_POST['detalle'][$i].'"';
		$query.= ', "'.$_POST['precio'][$i].'"';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
	
	newAccion('Crea nueva Nota de entrega a favor de "'.$nombre.'"');
	
	return $id;
	}
function getNotas(){
	$db =& JFactory::getDBO();
	$where = '';
	if(JRequest::getVar('filtro', '', 'post') != '' )
		$where .= ' AND nombre LIKE "%'.JRequest::getVar('filtro', '', 'post').'%" ';
	
    if(JRequest::getVar('desde', '', 'post') != '' )
		$where .= ' AND fecha >= "'.fecha2(JRequest::getVar('desde', '', 'post')).'" ';
	
    if(JRequest::getVar('hasta', '', 'post') != '' )
		$where .= ' AND fecha <= "'.fecha2(JRequest::getVar('hasta', '', 'post')).'" ';
    
	$query = 'SELECT * FROM #__erp_nota_cabecera WHERE 1'.$where.' ORDER BY id DESC';
	$db->setQuery($query);  
	$proformas = $db->loadObjectList();
	return $proformas;
	}
function getNota(){
	$db =& JFactory::getDBO();
	$query = 'SELECT p.*, p.id AS numero, i.empresa, i.nit, i.nombre, i.apellido 
	FROM #__erp_nota_cabecera AS p 
	LEFT JOIN #__erp_clientes AS c ON p.id_cliente = c.id
	LEFT JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente 
	WHERE p.id = "'.JRequest::getVar('id', '', 'get').'" AND i.activo = "1"';
    //echo $query;
	$db->setQuery($query);  
	$proforma = $db->loadObject();
	return $proforma;
	}
function getNotaDetalle(){
	$db =& JFactory::getDBO();
	$query = 'SELECT det.*, it.id as id_producto, it.id_ctacontable
    FROM #__erp_nota_detalle as det
    LEFT JOIN #__erp_producto_items as it ON det.codigo = it.codigo
    WHERE det.id_nota = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$detalle = $db->loadObjectList();
    //echo $query;
	return $detalle;
	}
function existeFacturaNota($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT id FROM #__erp_facturacion_cabecera WHERE id_origen = "'.$id.'" AND origen = "Nota" AND estado = "V"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	if($id != '')
		return true;
		else
		return false;
	}
function totalNota($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT SUM(cantidad * precio) AS total FROM #__erp_nota_detalle WHERE id_nota = "'.$id.'"';
	$db->setQuery($query);  
	$total = $db->loadResult();
	return $total;
	}

// NIT
function getNit($id = 0){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_nit WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);  
	$nit = $db->loadObject();
	return $nit;
	}
function editNitEmpresa(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) AS cant FROM #__erp_clientes_nit WHERE id_cliente = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	if($cant > 0){
		$query = 'UPDATE #__erp_clientes_nit SET nit = "'.JRequest::getVar('nit', '', 'post').'" ';
		$query.= 'WHERE id_cliente = "'.JRequest::getVar('id', '', 'get').'"';
		}else{
		$query = 'INSERT INTO #__erp_clientes_nit(`id_cliente`, `etiqueta`, `nombre`, `nit`) VALUES(';
		$query.= '"'.JRequest::getVar('id', '', 'get').'"';
		$query.= ', "'.filtroCadena2(JRequest::getVar('empresa', '', 'post')).'"';
		$query.= ', "'.filtroCadena2(JRequest::getVar('empresa', '', 'post')).'"';
		$query.= ', "'.JRequest::getVar('nit', '', 'post').'"';
		$query.= ')';
		}
	$db->setQuery($query);
	$db->query();
	}
function getNitCliente($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_nit WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);  
	$nit = $db->loadObjectList();
	return $nit;
	}
function getNits($nit){
	$db =& JFactory::getDBO();
	$query = 'SELECT n.*, c.empresa 
	FROM #__erp_clientes_nit AS n 
	LEFT JOIN #__erp_clientes_info AS c USING(id_cliente)
    LEFT JOIN #__erp_clientes_rel_estado AS rel USING(id_cliente)
	WHERE n.nit LIKE "%'.$nit.'%" AND c.activo = "1" AND rel.id_estado = "1"';
	$db->setQuery($query);  
	$nit = $db->loadObjectList();
	return $nit;
	}

// Cnotadores
function countClientes(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countRecibos(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_clientes_recibo WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countProformas(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_proforma_cabecera WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countProductos(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_producto_items WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countNotas(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_nota_cabecera WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countFacturas(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_cabecera WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function countCompras(){
	$db =& JFactory::getDBO();
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_compras WHERE 1';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	return $cant;
	}
function totalProforma($id){
	$db =& JFactory::getDBO();
	$query = 'SELECT SUM(cantidad * precio) AS total FROM #__erp_proforma_detalle WHERE id_proforma = "'.$id.'"';
	$db->setQuery($query);  
	$total = $db->loadResult();
	return $total;
	}

// NIT
function prinNIT(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$id_nit = JRequest::getVar('id_nit', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_nit SET principal = "0" WHERE id_cliente = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	$query = 'UPDATE #__erp_clientes_nit SET principal = "1" WHERE id = "'.$id_nit.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteNIT(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_clientes_nit WHERE id = "'.JRequest::getVar('id_nit', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function newNIT(){
	$db =& JFactory::getDBO();
	$query = 'INSERT INTO #__erp_clientes_nit(`id_cliente`, `etiqueta`, `nombre`, `nit`) VALUES(';
	$query.= '"'.JRequest::getVar('id', '', 'get').'"';
	$query.= ', "'.JRequest::getVar('etiqueta', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('nombre', '', 'post').'"';
	$query.= ', "'.JRequest::getVar('nit', '', 'post').'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Registro nuevo NIT "'.JRequest::getVar('nit', '', 'post').'" para "'.JRequest::getVar('nombre', '', 'post').'"');
	}
function editNIT(){
	$db =& JFactory::getDBO();
	$query = 'UPDATE #__erp_clientes_nit SET ';
	$query.= '`etiqueta` = "'.JRequest::getVar('etiqueta', '', 'post').'"';
	$query.= ', `nombre` = "'.JRequest::getVar('nombre', '', 'post').'"';
	$query.= ', `nit` = "'.JRequest::getVar('nit', '', 'post').'"';
	$query.= ' WHERE id = "'.JRequest::getVar('id_nit', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}
function get_NIT(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_nit WHERE id = "'.JRequest::getVar('id_nit', '', 'get').'"';
	$db->setQuery($query);  
	$nit = $db->loadObject();
	return $nit;
	}
// Recibos

function getRecibos(){
	$db =& JFactory::getDBO();
	$where = '';
	if(JRequest::getVar('filtro', '', 'post') != '')
		$where = ' WHERE r.nombre LIKE "%'.JRequest::getVar('filtro', '', 'post').'%"';
	$query = 'SELECT c.*, r.nombre, r.acuenta, r.saldo, r.docid_cliente, r.docid_receptor 
	FROM #__erp_clientes_cuenta AS c 
	JOIN #__erp_clientes_recibo AS r ON c.id = r.id_cuenta '.$where.'
	ORDER BY c.fecha DESC';
	$db->setQuery($query);  
	$recibos = $db->loadObjectList();
	return $recibos;
	}
function getRecibo(){
	$db =& JFactory::getDBO();
	$query = 'SELECT c.*, r.nombre, r.acuenta, r.saldo, r.docid_cliente, r.docid_receptor  
	FROM #__erp_clientes_cuenta AS c 
	JOIN #__erp_clientes_recibo AS r ON c.id = r.id_cuenta 
	WHERE c.id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);  
	$recibo = $db->loadObject();
	return $recibo;
	}

//
function getDatos(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_cuenta WHERE 1';
	$db->setQuery($query);  
	$recibo = $db->loadObjectList();
	return $recibo;
	}

// Métodos de envío
function getMetodosEnvio(){
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_modoenvio ORDER BY modo_envio';
	$db->setQuery($query);  
	$modo = $db->loadObjectList();
	return $modo;
	}
function getMetodoEnvio($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_modoenvio WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$modo = $db->loadObject();
	return $modo;
	}
function newMetodoEnvio(){
	$db =& JFactory::getDBO();
	
	$modo_envio = JRequest::getVar('modo_envio', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_comunicaciontipo(`modo_envio`) VALUES("'.$modo_envio.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea modo de envío "'.$modo_envio.'"');
	}
function editMetodoEnvio(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$modo_envio = JRequest::getVar('modo_envio', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_comunicaciontipo SET `tipo` = "'.$modo_envio.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteMetodoEnvio(){
	$db =& JFactory::getDBO();
	$query = 'DELETE FROM #__erp_clientes_comunicaciontipo WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	}


// Personal
function getPersonal(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT *
	FROM #__erp_clientes_personal
	WHERE eliminado = "0" AND id_cliente = "'.$id.'" 
	ORDER BY apellido, nombre';
	$db->setQuery($query);  
	$personal = $db->loadObjectList();
	return $personal;
	}
function getPersona($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_personal WHERE id = "'.$id.'"';
	
	$db->setQuery($query);  
	$persona = $db->loadObject();
	return $persona;
	}
function newPersonal(){
	$db =& JFactory::getDBO();
	
	$id_cliente = JRequest::getVar('id_cliente', '', 'post');
	$cargo = JRequest::getVar('cargo', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	$apellido = JRequest::getVar('apellido', '', 'post');
	$id_pais = JRequest::getVar('nacionalidad', '', 'post');
	$observaciones = JRequest::getVar('observaciones', '', 'post');
	$cli = getCliente($id_cliente);
	
	$query = 'INSERT INTO #__erp_clientes_personal(`id_cliente`, `id_pais`, `cargo`, `nombre`, `apellido`, `fecha`, `observaciones`) VALUES(';
	$query.= '"'.$id_cliente.'"';
	$query.= ', "'.$id_pais.'"';
	$query.= ', "'.$cargo.'"';
	$query.= ', "'.$nombre.'"';
	$query.= ', "'.$apellido.'"';
	$query.= ', NOW()';
	$query.= ', "'.$observaciones.'"';
	$query.= ')';
	$db->setQuery($query);
	$db->query();
	
	$query = 'SELECT LAST_INSERT_ID()';
	$db->setQuery($query);
	$id_personal = $db->loadResult();
	
	$cont = JRequest::getVar('celcontact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_personal.'"';
		$query.= ', "c"';
		$query.= ', "'.$val.'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	$cont = JRequest::getVar('telfcontact', '', 'post');
	$ext = JRequest::getVar('extensionc', '', 'post');
    $contad = 0; 
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_personal.'"';
		$query.= ', "t"';
		$query.= ', "'.$val.'|'.$ext[$contad].'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
        $contad++;
		}
	
	$cont = JRequest::getVar('econtact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id_personal.'"';
		$query.= ', "e"';
		$query.= ', "'.$val.'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	newAccion('Crea personal "'.$nombre.' '.$apellido.'" en la empresa "'.$cli->empresa.'"');
	}
function editPersonal(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$cargo = JRequest::getVar('cargo', '', 'post');
	$nombre = JRequest::getVar('nombre', '', 'post');
	$apellido = JRequest::getVar('apellido', '', 'post');
	$id_pais = JRequest::getVar('nacionalidad', '', 'post');
	$observaciones = JRequest::getVar('observaciones', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_personal SET ';
	$query.= '`cargo` = "'.$cargo.'"';
	$query.= ', `nombre` = "'.$nombre.'"';
	$query.= ', `apellido` = "'.$apellido.'"';
	$query.= ', `id_pais` = "'.$id_pais.'"';
	$query.= ', `observaciones` = "'.$observaciones.'"';
	$query.= ' WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	
	$query = 'DELETE FROM #__erp_clientes_contacto WHERE id_info = "'.$id.'" AND seccion = "p"';
	$db->setQuery($query);
	$db->query();
	
	$cont = JRequest::getVar('celcontact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "c"';
		$query.= ', "'.$val.'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	
	$cont = JRequest::getVar('telfcontact', '', 'post');
	$ext = JRequest::getVar('extensionc', '', 'post');
    $contad = 0;
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "t"';
		$query.= ', "'.$val.'|'.$ext[$contad].'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
        $contad++;
    }
	
	$cont = JRequest::getVar('econtact', '', 'post');
	foreach($cont as $val){
		$query = 'INSERT INTO #__erp_clientes_contacto(`id_info`, `tipo`, `valor`, `seccion`) VALUES(';
		$query.= '"'.$id.'"';
		$query.= ', "e"';
		$query.= ', "'.$val.'"';
		$query.= ', "p"';
		$query.= ')';
		$db->setQuery($query);  
		$db->query();
		}
	}
function deletePersonal(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_personal SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// Cargo Personal
function getCargos(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_clientes_cargo WHERE eliminado = "0" ORDER BY cargo';
	$db->setQuery($query);  
	$cargos = $db->loadObjectList();
	return $cargos;
	}
function getCargo($id = 0){
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	$db =& JFactory::getDBO();
	$query = 'SELECT * FROM #__erp_clientes_cargo WHERE id = "'.$id.'"';
	
	$db->setQuery($query);  
	$cargo = $db->loadObject();
	return $cargo;
	}
function newCargo(){
	$db =& JFactory::getDBO();
	
	$cargo = JRequest::getVar('cargo', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_cargo(`cargo`) VALUES("'.$cargo.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea nuevo cargo "'.$cargo.'"');
	}
function editCargo(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$cargo = JRequest::getVar('cargo', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_cargo SET `cargo` = "'.$cargo.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteCargo(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_cargo SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// Estado
function getClienteEstados(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_clientes_estado WHERE eliminado = "0" ORDER BY estado';
	$db->setQuery($query);  
	$estado = $db->loadObjectList();
	return $estado;
	}
function getClienteEstado($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_clientes_estado WHERE id = "'.$id.'"';
	
	$db->setQuery($query);
	$estado = $db->loadObject();
	return $estado;
	}
function newClienteEstado(){
	$db =& JFactory::getDBO();
	
	$estado = JRequest::getVar('estado', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_estado(`estado`) VALUES("'.$estado.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea nuevo estado de cliente "'.$estado.'"');
	}
function editClienteEstado(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$estado = JRequest::getVar('estado', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_estado SET `estado` = "'.$estado.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteClienteEstado(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_estado SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}

// Estado
function getClienteActividades(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_clientes_actividad WHERE eliminado = "0" ORDER BY actividad';
	$db->setQuery($query);  
	$estado = $db->loadObjectList();
	return $estado;
	}
function getClienteActividad($id = 0){
	$db =& JFactory::getDBO();
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_clientes_actividad WHERE id = "'.$id.'"';
	
	$db->setQuery($query);  
	$estado = $db->loadObject();
	return $estado;
	}
function newClienteActividad(){
	$db =& JFactory::getDBO();
	
	$actividad = JRequest::getVar('actividad', '', 'post');
	
	$query = 'INSERT INTO #__erp_clientes_actividad(`actividad`) VALUES("'.$actividad.'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea nueva actividad para asociado "'.$actividad.'"');
	}
function editClienteActividad(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	$actividad = JRequest::getVar('actividad', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_actividad SET `actividad` = "'.$actividad.'" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
function deleteClienteActividad(){
	$db =& JFactory::getDBO();
	
	$id = JRequest::getVar('id', '', 'get');
	
	$query = 'UPDATE #__erp_clientes_actividad SET eliminado = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);
	$db->query();
	}
	
// Estadisticas
function getStatAsociados(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE 1';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatAsociadosAc(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(c.id) 
	FROM #__erp_clientes AS c
	JOIN #__erp_clientes_rel_estado AS rce ON c.id = rce.id_cliente
	WHERE c.registro != "" AND rce.id_estado = "1" AND rce.activo = "1"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatAsociadosNu(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_clientes WHERE registro = "" AND bloqueado = "0"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatProspectos(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_crm_prospecto WHERE estado = "0"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatComprobantes(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_conta_comprobante';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatFacturas(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_facturacion_cabecera WHERE estado = "V"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatProductos(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM #__erp_producto_items';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatUsuarios(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT COUNT(id_usuario) FROM #__erp_rel_usuario_empresa WHERE id_empresa = "'.$session->get('ide').'"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}
function getStatRoles(){
	$db =& JFactory::getDBO();
	$session = JFactory::getSession();
	
	$query = 'SELECT COUNT(id) FROM #__erp_grupos WHERE id_empresa = "'.$session->get('ide').'"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}

function getStatsCRM($t){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(p.id) 
	FROM #__erp_crm_prospecto AS p
	LEFT JOIN #__erp_crm_etapa AS e ON p.id = e.id_prospecto
	WHERE e.activo = "1" AND e.etapa = "'.$t.'"';
	$db->setQuery($query);  
	$num = $db->loadResult();
	return $num;
	}


function validaTXT(){
	$db =& JFactory::getDBO();
	
	$texto = JRequest::getVar('texto', '', 'post');
	
	$query = 'SELECT COUNT(id) FROM #__erp_gruposacceso WHERE ruta = "'.$texto.'"';
	$db->setQuery($query);  
	$cant = $db->loadResult();
	
	if($cant == 0)
		$val = 0;
		else
		$val = 1;
	return $val;
	}
function sucursalPred(){
	$db =& JFactory::getDBO();
	
	$id_usuario = JRequest::getVar('id_usuario', '', 'post');
	$id_sucursal = JRequest::getVar('id_sucursal', '', 'post');
	
	$query = 'UPDATE #__erp_rel_usuario_sucursal SET predeterminado = "0" WHERE id_usuario = "'.$id_usuario.'"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE #__erp_rel_usuario_sucursal SET predeterminado = "1" WHERE id_usuario = "'.$id_usuario.'" AND id_sucursal = "'.$id_sucursal.'"';
	$db->setQuery($query);
	$db->query();
	}
function checksucursalPred(){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = $user->get('id');
	
	$query = 'SELECT id_sucursal FROM #__erp_rel_usuario_sucursal WHERE id_usuario = "'.$id.'" AND predeterminado = "1"';
	$db->setQuery($query);  
	$id = $db->loadResult();
	
	return $id;
	}

// LOGS
function getLogs(){
	$db =& JFactory::getDBO();
	$id_usuario = JRequest::getVar('id_usuario','','post');
	$desde = JRequest::getVar('fecha_ini','','post');
	$hasta = JRequest::getVar('fecha_fin','','post');
	$where = '';
    if($id_usuario !=''){
        $where.= ' AND l.id_usuario = "'.$id_usuario.'"';
    }
    if($desde != ''){
        $where.= ' AND l.fecha >= "'.fecha2($desde).'"';
    }
    if($hasta != ''){
        $where.= ' AND l.fecha <= "'.fecha2($hasta).'"';
    }
    $desde = JRequest::getVar('desde','','get');
	$hasta = JRequest::getVar('hesta','','get');
    
    $query = 'SELECT l.*, u.name
	FROM #__erp_logs AS l
	LEFT JOIN #__users AS u ON l.id_usuario = u.id
    WHERE 1'.$where;
	$db->setQuery($query);  
	$logs = $db->loadObjectList();
    //echo $query;
	return $logs;
}

function getLogsIP($sinpag=1){
	$db =& JFactory::getDBO();
    $desde = JRequest::getVar('desde','','post');
    $hasta = JRequest::getVar('hasta','','post');
    $where = '';
    if($desde!=''){
        $where.= ' AND l.fecha >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where.= ' AND l.fecha <= "'.fecha2($hasta).'"';
    }
	$limit = '';
    if($sinpag==0){
        $cant= 20;
        $pag  = JRequest::getVar('p', '1', 'get');
        $page = $pag - 1;
        $limit = ' LIMIT '.(($page) * $cant).','.$cant;
    }
	$query = 'SELECT l.*, u.name
	FROM #__erp_logs_ip AS l
	LEFT JOIN #__users AS u ON l.id_usuario = u.id 
    WHERE 1 '.$where.'
    ORDER BY l.fecha DESC'.$limit;
    echo $query;
	$db->setQuery($query);  
	$logs = $db->loadObjectList();
	
	return $logs;
	}
function getLogsIP_pag(){
	$db =& JFactory::getDBO();
	$desde = JRequest::getVar('desde','','post');
    $hasta = JRequest::getVar('hasta','','post');
    $where = '';
    if($desde!=''){
        $where.= ' AND l.fecha >= "'.fecha2($desde).'"';
    }
    if($hasta!=''){
        $where.= ' AND l.fecha <= "'.fecha2($hasta).'"';
    }
	$query = 'SELECT COUNT(*)
	FROM #__erp_logs_ip AS l
	LEFT JOIN #__users AS u ON l.id_usuario = u.id
    WHERE 1'.$where;
	$db->setQuery($query);  
	$logs = $db->loadResult();
	
	return $logs;
	}
	
function generaUsuarios(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT i.id_info, i.empresa, c.registro 
	FROM #__erp_clientes_info AS i
	LEFT JOIN #__erp_clientes AS c ON i.id_cliente = c.id
	WHERE i.activo = "1" AND c.registro != ""';
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();
	
	foreach($clientes as $c){
		$query = 'SELECT valor FROM #__erp_clientes_contacto WHERE id_info ';
		
		$query = 'INSERT INTO #__users(`name`, `username`, `email`, `password`, `registerDate`) VALUES(';
		$query.= '"'.$c->empresa.'"';
		$query.= ', "'.$c->registro.'"';
		$query.= ', ""';
		$query.= ', "'.md5($c->registro).'"';
		$query.= ', NOW()';
		$query.= ')';
		$db->setQuery($query);
		$db->query();
		}
	}

//etiquetas
function getEtiqueta(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT * FROM #__erp_clientes_etiquetas WHERE id = "1"';
	$db->setQuery($query);  
	$etiqueta = $db->loadObject();
	
	return $etiqueta;
	}
function editEtiqueta(){
	$db =& JFactory::getDBO();
	
	$posx_nombre = JRequest::getVar('posx_nombre', '', 'post');
	$posy_nombre = JRequest::getVar('posy_nombre', '', 'post');
	$posx_empresa = JRequest::getVar('posx_empresa', '', 'post');
	$posy_empresa = JRequest::getVar('posy_empresa', '', 'post');
	$posx_dir = JRequest::getVar('posx_dir', '', 'post');
	$posy_dir = JRequest::getVar('posy_dir', '', 'post');
	$alto = JRequest::getVar('alto', '', 'post');
	$ancho = JRequest::getVar('ancho', '', 'post');
	$cantidad = JRequest::getVar('cantidad', '', 'post');
	
	$query = 'UPDATE #__erp_clientes_etiquetas SET ';
	$query.= 'posx_nombre = "'.$posx_nombre.'"';
	$query.= ', posy_nombre = "'.$posy_nombre.'"';
	$query.= ', posx_empresa = "'.$posx_empresa.'"';
	$query.= ', posy_empresa = "'.$posy_empresa.'"';
	$query.= ', posx_dir = "'.$posx_dir.'"';
	$query.= ', posy_dir = "'.$posy_dir.'"';
	$query.= ', alto = "'.$alto.'"';
	$query.= ', ancho = "'.$ancho.'"';
	$query.= ', cantidad = "'.$cantidad.'"';
	$query.= ' WHERE id = "1"';
	$db->setQuery($query);
	$db->query();
	}
//
function getClienteFono($id_info){
	$db =& JFactory::getDBO();

	$query = 'SELECT valor FROM cgn_erp_clientes_contacto WHERE id_info = "'.$id_info.'" AND tipo = "t" AND seccion = "e" LIMIT 1';

	$db->setQuery($query);  
	$contacto = $db->loadResult();

	return $contacto;
}
function getClienteDeuda($id_cliente, $cantidad = 0){
	$db =& JFactory::getDBO();
	
	if($cantidad == 0)
		$query = 'SELECT SUM(monto) FROM cgn_erp_aportes_deuda WHERE id_cliente = "'.$id_cliente.'" AND pagado = "0" AND monto > 0';
	else
		$query = 'SELECT COUNT(id) FROM cgn_erp_aportes_deuda WHERE id_cliente = "'.$id_cliente.'" AND pagado = "0" AND monto > 0';
		
	$db->setQuery($query);  
	$deuda = $db->loadResult();
	
	return $deuda;
	}

/// Reportes
function getRepPagosAnticipados(){
	$db =& JFactory::getDBO();
    $empresa = JRequest::getVar('empresa','','post');
	$query = 'SELECT 
		c.registro,
        (
        	SELECT categoria FROM cgn_erp_clientes_categoria WHERE id = i.id_categoria
        ) AS categoria,
        CONCAT(MAX(am.mes), "/", am.anio) AS pago_hasta,
		i.*,
		c.fecha_inscripcion,
		a.monto
	FROM cgn_erp_aportes_mes AS am
	JOIN cgn_erp_clientes_info AS i ON am.id_cliente = i.id_cliente
    JOIN cgn_erp_clientes AS c ON i.id_cliente = c.id
	JOIN cgn_erp_clientes_categoria_aportes AS a ON a.id = i.id_categoria
	WHERE am.anio = YEAR(NOW()) AND am.mes >= MONTH(NOW()) AND i.empresa LIKE "%'.$empresa.'%"
	GROUP BY am.id_cliente';
    //echo $query;
	$db->setQuery($query);  
	$clientes = $db->loadObjectList();

	return $clientes;
}
function getRepNotasDeCargo($id_cobrador, $mes, $anio){
	$db =& JFactory::getDBO();
    
	$query = 'SELECT 
		i.id AS id_info,
		c.registro,
        (
        	SELECT categoria FROM cgn_erp_clientes_categoria WHERE id = i.id_categoria
        ) AS categoria,
        i.empresa,
        CONCAT(i.direccion, ", ", i.zona, " - ", i.ciudad) AS direccion,
        (
        	SELECT monto FROM cgn_erp_clientes_categoria_aportes WHERE id_categoria = i.id_categoria
        ) AS monto_cargo,
		i.id_cliente,
		c.fecha_inscripcion,
		a.monto
	FROM cgn_erp_clientes_info AS i
	JOIN cgn_erp_aportes_mes AS am ON am.id_cliente = i.id_cliente
    JOIN cgn_erp_clientes AS c ON i.id_cliente = c.id
	JOIN cgn_erp_clientes_categoria_aportes AS a ON a.id = i.id_categoria
	JOIN cgn_erp_clientes_rel_estado AS rce ON rce.id_cliente = c.id
	WHERE am.anio = YEAR(NOW()) AND am.mes <= MONTH(NOW()) AND rce.id_estado = 1 AND rce.activo = 1 AND i.id_usuario_cobrador = "'.$id_cobrador.'"
    AND c.masiva = 0
	GROUP BY am.id_cliente';
    //echo $query;
    /*$query = 'SELECT n.*, i.empresa, c.registro, (SELECT monto FROM cgn_erp_clientes_categoria_aportes WHERE id_categoria = i.id_categoria) AS monto_cargo
    FROM cgn_erp_facturacion_notadebito AS n 
    LEFT JOIN cgn_erp_clientes_info AS i ON n.id_cliente = i.id_cliente
    LEFT JOIN cgn_erp_clientes AS c ON i.id_cliente = c.id
    LEFT JOIN cgn_erp_aportes_mes AS am ON am.id_cliente = i.id_cliente
    LEFT JOIN cgn_erp_clientes_categoria_aportes AS a ON a.id = i.id_categoria
    LEFT JOIN cgn_erp_clientes_rel_estado AS rce ON rce.id_cliente = c.id
    LEFT JOIN cgn_erp_clientes_mca AS mca ON mca.id = i.id_usuario_cobrador 
    WHERE i.activo = "1" AND mca.habilitado = "1" AND mca.eliminado = "0" AND mca.id = "'.$id_cobrador.'" AND c.masiva = 0
    AND n.mes = "'.$mes.'" AND n.anio = "'.$anio.'" GROUP BY am.id_cliente';*/
	$db->setQuery($query);
	$clientes = $db->loadObjectList();

	return $clientes;
}
function getRepFacturacionMasiva($id_cobrador){
	$db =& JFactory::getDBO();
	$u = JRequest::getVar('usuario', '', 'post');
    $where = '';
    if($u!=''){
        $where.=' AND i.id_usuario_cobrador = "'.$u.'"';
    }
	$query = 'SELECT 
		c.registro,
		i.empresa,
		CONCAT(i.direccion, ", ", i.zona, " - ", i.ciudad) AS direccion,
		(
			SELECT monto FROM cgn_erp_clientes_categoria_aportes WHERE id = i.id_categoria
		) AS monto,
		1,
		i.id_cliente,
		c.fecha_inscripcion,
		a.monto
	FROM cgn_erp_clientes_info AS i
	JOIN cgn_erp_clientes AS c ON i.id_cliente = c.id
	JOIN cgn_erp_clientes_categoria_aportes AS a ON a.id = i.id_categoria
	WHERE masiva = 1 AND i.id_usuario_cobrador = "'.$id_cobrador.'"'.$where.'';
	
	$db->setQuery($query);
	$clientes = $db->loadObjectList();

	return $clientes;
	}

function getRepCompleto(){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT 
		c.registro,
		i.empresa,
		CONCAT(i.direccion, ", ", i.zona, " - ", i.ciudad) AS direccion,
		(
			SELECT monto FROM cgn_erp_clientes_categoria_aportes WHERE id = i.id_categoria
		) AS monto,
		i.id_cliente,
		c.fecha_inscripcion,
		a.monto
	FROM cgn_erp_clientes_info AS i
	JOIN cgn_erp_clientes AS c ON i.id_cliente = c.id
	JOIN cgn_erp_clientes_categoria_aportes AS a ON a.id = i.id_categoria';
	
	$db->setQuery($query);
	$clientes = $db->loadObjectList();

	return $clientes;
}
function getClientesDeuda($id_cliente, $fecha, $monto){
	$db =& JFactory::getDBO();
	
	$query = 'SELECT COUNT(id) FROM cgn_erp_aportes_mes WHERE id_cliente = "'.$id_cliente.'" GROUP BY anio, mes';
	$db->setQuery($query);
	$cuotas = $db->loadObjectList();
	
	$cantidad = count($cuotas);
	
	$f = explode('-', $fecha);
	
	if($f[0] == date('Y')){
		$cant = date('n') - (int)$f[1];
		}
	elseif($f[0] == (date('Y') - 1)){
		$cant = (13 - (int)$f[0]) + date('n');
		}
	else{
		if((int)$f[0] < 1992){
			$a = 1992;
			$mes_ini = 13 - (int)$f[1];
			}else{
			$a = (int)$f[0];
			$mes_ini = 12;
			}
		$a = (date('Y') - $a) * 12;
		$mes_fin = date('n');
		
		$cant = $mes_ini + $mes_fin + $a;
		}
	
	$monto = ($cant - $cantidad) * $monto;
	
	return $monto;
	}
function getTotalAsociados($id_cat = 0, $masiva = 0, $id_estado = 1){
	$db =& JFactory::getDBO();
	
	$where = '';
	if($id_cat != 0)
		$where.= ' AND i.id_categoria = "'.$id_cat.'"';
	if($masiva != 0)
		$where.= ' AND c.masiva = 1';
	if($id_estado != 0)
		$where.= ' AND e.id_estado = "'.$id_estado.'"';
	
	$query = 'SELECT COUNT(c.id) 
	FROM #__erp_clientes AS c
	JOIN #__erp_clientes_info AS i ON c.id = i.id_cliente
	JOIN #__erp_clientes_rel_estado AS e on c.id = e.id_cliente 
	WHERE 1 '.$where.' AND e.activo = "1" GROUP BY i.id_cliente';
	//echo $query;
	$db->setQuery($query);
	$cant = $db->loadObjectList();
    
	return count($cant);
	}
function gettextoNotasD(){
    $db =& JFactory::getDBO();
    $query = 'SELECT *
	FROM #__erp_nota_debito';
    $db->setQuery($query);
	$listado = $db->loadObjectList();

	return $listado;
}
function gettextoNotaD($id){
    $db =& JFactory::getDBO();    
    $query = 'SELECT *
	FROM #__erp_nota_debito WHERE id = "'.$id.'"';
    $db->setQuery($query);
	$listado = $db->loadObject();

	return $listado;
}
function newtextoNotaD(){
    $db =& JFactory::getDBO();
    $texto = JRequest::getVar('texto','','post');
    $estado = JRequest::getVar('estado','','post');
        
    $query = 'UPDATE #__erp_nota_debito SET estado = "0"'; 
    $db->setQuery($query);  
	$db->query();
    
    $query = 'INSERT INTO #__erp_nota_debito(`texto`, `estado`) VALUES(';
	$query.= '"'.$texto.'"';
	$query.= ', "1"';
	$query.= ')';
    
    //echo $activo.' NONOANSODNASDASNDKNASK';
	$db->setQuery($query);  
	$db->query();
}
function updatetextoNotaD(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id','','post');
    $texto = JRequest::getVar('texto','','post');
    $estado = JRequest::getVar('estado','','post');
    $query = 'UPDATE #__erp_nota_debito SET estado = "0"'; 
    $db->setQuery($query);  
	$db->query();
    $query = 'UPDATE #__erp_nota_debito SET estado = "'.$estado.'", texto = "'.$texto.'"  WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
}
function deletetextoNotaD(){
    $db =& JFactory::getDBO();
    $query = 'DELETE FROM #__erp_nota_debito WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
}
function getTextoDebito(){
    $db =& JFactory::getDBO();    
    $query = 'SELECT texto
	FROM #__erp_nota_debito WHERE estado= "1"';
    $db->setQuery($query);
	$listado = $db->loadResult();

	return $listado;
}

// Unidades de Negocio
function getUnidadesDeNegocio($activos = false){
	$db =& JFactory::getDBO();
	
	$where = '';
	if($activos)
		$where = ' WHERE eliminado = 0';
	
	$query = 'SELECT * FROM #__erp_unidadnegocio'.$where;
		
	$db->setQuery($query);  
	$unidades = $db->loadObjectList();
	return $unidades;
    
}	
function getUnidadDeNegocio($id = 0){
	$db =& JFactory::getDBO();  
	
	if($id == 0)
		$id = JRequest::getVar('id', '', 'get');
	
	$query = 'SELECT * FROM #__erp_unidadnegocio WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$unidad = $db->loadObject();
	
	return $unidad;
	}
function deleteUnidadDeNegocio(){
	$db =& JFactory::getDBO();
	
	$query = 'UPDATE #__erp_unidadnegocio SET eliminado = 1 WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	//echo $query;
	$db->setQuery($query);
	$db->query();
	
	}
function newUnidadDeNegocio(){
	$db =& JFactory::getDBO();
	
	$query = 'INSERT INTO #__erp_unidadnegocio(`unidad_negocio`) VALUES("'.JRequest::getVar('unidad', '', 'post').'")';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Crea Unidad de Negocio "'.JRequest::getVar('unidad', '', 'post').'"');
	}
function editUnidadDeNegocio(){
	$db =& JFactory::getDBO();
	
	$query = 'UPDATE #__erp_unidadnegocio SET `unidad_negocio` = "'.JRequest::getVar('unidad', '', 'post').'" WHERE id = "'.JRequest::getVar('id', '', 'get').'"';
	$db->setQuery($query);
	$db->query();
	
	newAccion('Edita Unidad de Negocio "'.JRequest::getVar('unidad', '', 'post').'"');
	}
function newPDF($nombre, $archivo){
	$db =& JFactory::getDBO();
	$user =& JFactory::getUser();
	
	$id = $user->get('id');
    $id_info = JRequest::getVar('id','','post');    
	$query = 'INSERT INTO #__erp_clientes_documentos (`id_info`, `nombre`, `tipo`, `nombre_archivo`) VALUES(';
	$query .= '"'.$id_info.'"';
	$query .= ', "'.$nombre.'"';
	$query .= ', "filepdf"';
	$query .= ', "'.$archivo.'"';
	$query .= ');';
	$db->setQuery($query);
    $db->query();
	
}
function getPDFs(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id','','get');
	$query = 'SELECT * FROM #__erp_clientes_documentos WHERE id_info = "'.$id.'" AND tipo = "filepdf"';
	$db->setQuery($query);  
	$lista = $db->loadObjectList();
	return $lista;
}
function deletePDF(){
	$db =& JFactory::getDBO();
	$id = JRequest::getVar('id','','post');
	$id_info = JRequest::getVar('id_info','','post');
	$nombre = JRequest::getVar('nombre','','post');
    $folder = 'media/erp/archivos/'.$id_info.'/'.$nombre;
    unlink ($folder);
	$query = 'DELETE FROM #__erp_clientes_documentos WHERE id = "'.$id.'"';
	$db->setQuery($query);
    $db->query();
}
function newHistorialCambios($estado, $motivo, $cliente){
    $user =& JFactory::getUser();
    $db =& JFactory::getDBO();
    $query = 'INSERT INTO #__erp_clientes_cambio_estado(`id_estado`, `id_cliente`, `motivo`, `id_usuario`, `fecha`) VALUES (';
    $query .= '"'.$estado.'"';
    $query .= ', "'.$cliente.'"';
    $query .= ', "'.motivo.'"';
    $query .= ', "'.$user->get('id').'"';
    $query .= ', NOW()';
    $query .= ')';
    $db->setQuery($query);
    $db->query();
}
function getHistorialCambios(){
    $db =& JFactory::getDBO();
    $id = JRequest::getVar('id','','get');
    $query = 'SELECT h.*, e.estado, u.name AS usuario
    FROM #__erp_clientes_cambio_estado AS h
    LEFT JOIN #__erp_clientes_estado AS e ON h.id_estado = e.id
    LEFT JOIN #__users AS u ON h.id_usuario = u.id
    WHERE h.id_cliente = "'.$id.'"';
    //echo $query;
    $db->setQuery($query);
	$historial = $db->loadObjectList();
    return $historial;
}
?>