<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
enableUsuarioExt();?>
<script>
location.href="index.php?option=com_erp&view=gestionusuarios&layout=personalexterno";
</script>
<? }else{vistaBloqueada();}?>