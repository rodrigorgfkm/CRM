<?php defined('_JEXEC') or die;
if($_POST){
    disableLBcuenta();   
}
?>
<script>
    location.href = "index.php?option=com_erp&view=librobancos&layout=mantenimiento";
</script>