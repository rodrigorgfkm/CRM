<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
    deleteTipoSociedad();    
?>
<script>
   location.href = "index.php?option=com_erp&view=tiposdesociedad";
</script>
<? }else{
    vistaBloqueada();
}?>