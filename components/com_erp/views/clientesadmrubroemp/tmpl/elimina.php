<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
    deleteRubro();
?>
<script>
   location.href = "index.php?option=com_erp&view=clientesadmrubroemp";
</script>
<? }else{
    vistaBloqueada();
}?>