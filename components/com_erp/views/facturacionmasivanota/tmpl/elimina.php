<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<?
deletetextoNotaD();
?>
<script>
location.href="index.php?option=com_erp&view=facturacionmasivanota";
</script>
<? }else{vistaBloqueada(); }?>