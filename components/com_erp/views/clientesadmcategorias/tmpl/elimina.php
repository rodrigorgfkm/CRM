<?php defined('_JEXEC') or die;
if(validaAcceso('Crea Categoria Clientes')){
deleteClientesCat();
?>
<script>
location.href="index.php?option=com_erp&view=clientesadmcategorias";
</script>
<? }else{
    vistaBloqueada();
}?>