<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<?
deleteRubro();
?>
<script>
location.href="index.php?option=com_erp&view=facturacionrubro";
</script>
<? }else{vistaBloqueada();}?>