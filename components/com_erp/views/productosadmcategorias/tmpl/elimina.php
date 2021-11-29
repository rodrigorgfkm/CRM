<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
deleteCategoria();
?>
<script>
location.href="index.php?option=com_erp&view=productosadmcategorias";
</script>
<? }else{vistaBloqueada(); }?>