<?php 
defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$session =& JFactory::getSession();
	
	$token = newFacturaMasiva();
	$session->set('token', $token);
?>
<script>
    location.href = 'index.php?option=com_erp&view=facturacionmasiva&layout=generacodigo&tmpl=component';
</script>
<? }else{
    vistaBloqueada();
}    
?>