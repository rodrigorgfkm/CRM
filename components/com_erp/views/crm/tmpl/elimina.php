<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('CRM Registro')){
	$session = JFactory::getSession();
	
	//suspendeCliente();
	
	if(JRequest::getVar('b', '', 'get') == 0){
		$session->set( 'msg', 'Se retiró correctamente la suspensión del asociado');
		$session->set( 'msg_titulo', 'ÉXITO');
		$session->set( 'msg_tipo', 'alert-success');
		$session->set( 'msg_icono', 'fa fa-check');
		}else{
		$session->set( 'msg', 'El asociado fue suspendido');
		$session->set( 'msg_titulo', 'ÉXITO');
		$session->set( 'msg_tipo', 'alert-success');
		$session->set( 'msg_icono', 'fa fa-check');
		}
	
	$msg_url = 'location.href = "index.php?option=com_erp&view=crm&layout=empresa"';?>
	<script>
    <?=$msg_url?>
    </script>
	<?
	}else{
    vistaBloqueada();
}?>