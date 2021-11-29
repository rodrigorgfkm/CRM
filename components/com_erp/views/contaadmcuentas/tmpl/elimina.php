<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Elimina')){
	deleteCNTcuenta();
	?>
	<script>
	location.href = 'index.php?option=com_erp&view=contaadmcuentas';
	</script>
<? }else{
vistaBloqueada();
}?>