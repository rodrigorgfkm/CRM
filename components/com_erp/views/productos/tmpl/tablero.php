<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
muestraProducto();?>
<script>
location.href="index.php?option=com_erp&view=productos&Itemid=802";
</script>
<? }else{
    vistaBloqueada();
}?>