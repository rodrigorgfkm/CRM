<?php defined('_JEXEC') or die;
if(validaAcceso('Gestion clientes estados')){
    deleteClienteEstado();
?>
<script>
   location.href = "index.php?option=com_erp&view=clientesadmestados";
</script>
<? }else{
    vistaBloqueada();
}?>