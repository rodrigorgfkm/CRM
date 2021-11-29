<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
    deleteUnidadDeNegocio();
?>
<script>
   location.href = "index.php?option=com_erp&view=unidadnegocio";
</script>
<? }else{
    vistaBloqueada();
}?>