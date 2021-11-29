<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración POS')){?>
<?
deleteTipoFactura();
?>
<script>
location.href="index.php?option=com_erp&view=facturacionadmtipo";
</script>
<? }else{vistaBloqueada();}?>