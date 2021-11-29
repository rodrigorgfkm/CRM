<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
comprobante_elimina()
?>
<script>
location.href = 'index.php?option=com_erp&view=contacomprobantes';
</script>
<? }else{ vistaBloaqueada();}?>