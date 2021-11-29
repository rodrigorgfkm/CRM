<?php defined('_JEXEC') or die;
 if(validaAcceso('Crear factura')){
    if($_POST){
        $id = JRequest::getVar('id','','post');
        consFactura();
    }
?>
<script>
    location.href = "index.php?option=com_erp&view=facturacion";
</script>

<? }else{vistaBloqueada();}?>