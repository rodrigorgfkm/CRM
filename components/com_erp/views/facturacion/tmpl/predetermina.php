<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Facturas')){
changePlantilla(3);?>
<script>
location.href="index.php?option=com_erp&view=facturacion&layout=plantilla";
</script>
<? }else{vistaBloqueada();}?>