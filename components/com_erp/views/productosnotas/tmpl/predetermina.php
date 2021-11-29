<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega')){?>
<?
changePlantilla(12);?>
<script>
location.href="index.php?option=com_erp&view=productosnotas&layout=plantilla";
</script>
<? }else{vistaBloqueada();}?>