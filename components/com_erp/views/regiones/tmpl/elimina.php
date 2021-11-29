<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración POS')){?>
<?
deletePais();
?>
<script>
location.href="index.php?option=com_erp&view=regiones";
</script>
<? }else{vistaBloqueada(); }?>