<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
    deleteTipoSociedad();    
?>
<script>
   location.href = "index.php?option=com_erp&view=clientesadmsociedad";
</script>
<? }else{
    vistaBloqueada();
}?>