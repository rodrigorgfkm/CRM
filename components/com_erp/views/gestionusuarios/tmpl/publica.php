<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
blockusuario();?>
<script>
location.href="index.php?option=com_erp&view=gestionusuarios";
</script>
<? }else{vistaBloqueada();}?>