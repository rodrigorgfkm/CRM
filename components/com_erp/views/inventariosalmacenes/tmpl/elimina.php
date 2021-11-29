<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
deleteTerminal();
?>
<script>
location.href="index.php?option=com_erp&view=posterminal";
</script>
<? }else{vistaBloqueada();} ?>