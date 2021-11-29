<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
deleteSucursal();
?>
<script>
location.href="index.php?option=com_erp&view=gestionsucursales";
</script>
<? }else{vistaBloqueada();}?>