<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
blockusuario();?>
<script>
location.href="index.php?option=com_erp&view=multiusuarios";
</script>
<? }else{vistaBloqueada();}?>