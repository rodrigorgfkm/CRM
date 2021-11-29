<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
deleteCategoria();
?>
<script>
location.href="index.php?option=com_apetitapp&view=categorias&Itemid=802";
</script>
<? }else{vistaBloqueada();}?>