<?php defined('_JEXEC') or die;
if(validaAcceso('Gestion clientes actividades')){
    deleteClienteActividad();
?>
<script>
   location.href = "index.php?option=com_erp&view=clientesadmactividades";
</script>
<? }else{
    vistaBloqueada();
}?>