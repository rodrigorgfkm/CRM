<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
deleteProducto();?>
<script>
location.href="index.php?option=com_erp&view=productos&Itemid=802";
</script>
<? }else{vistaBloqueada();}?>