<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<?
if(verifyFactura(JRequest::getVar('id', '', 'get')) == '')
	deleteLlave();
	else{
	$msg = 'alert("La llave no puede ser eliminada")';
	}
?>
<script>
<?=$msg?>;
location.href="index.php?option=com_erp&view=facturacion&layout=llaves";
</script>
<? }else{vistaBloqueada();}?>