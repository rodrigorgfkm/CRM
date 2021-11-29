<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Registro')){
deleteTipoComprobante();
?>
<script>
location.href="index.php?option=com_erp&view=contatipos";
</script>
<? }else{ vistaBloaqueada();}?>