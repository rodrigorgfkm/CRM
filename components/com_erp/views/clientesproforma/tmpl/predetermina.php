<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Clientes Proforma')){?>
<?
changePlantilla(3);?>
<script>
location.href="index.php?option=com_erp&view=clientesproforma&layout=plantilla";
</script>
<? }else{ vistaBloqueada(); }?>