<?php defined('_JEXEC') or die;
if(validaAcceso('Elimina Cargo Clientes')){
	deleteCargo();
?>
<script>
location.href="index.php?option=com_erp&view=clientescargo";
</script>
<? }else{
    vistaBloqueada();
}?>