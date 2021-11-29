<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
publishedCategoria();?>
<script>
location.href="index.php?option=com_erp&view=productosadmcategorias&Itemid=802";
</script>
<? }else{vistaBloqueada(); }?>