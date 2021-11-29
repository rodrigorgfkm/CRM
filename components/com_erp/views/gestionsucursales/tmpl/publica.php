<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
publishedCategoria();?>
<script>
location.href="index.php?option=com_erp&view=categorias&Itemid=802";
</script>
<? }else{vistaBloqueada();}?>