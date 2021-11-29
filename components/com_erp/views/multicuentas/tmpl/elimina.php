<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Elimina Base')){
	deleteCNTcuentaMAIN();
	?>
	<script>
	location.href = 'index.php?option=com_erp&view=multicuentas';
	</script>
<? }else{
vistaBloqueada();
}?>