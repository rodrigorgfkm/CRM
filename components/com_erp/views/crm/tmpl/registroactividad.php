<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Actividad')){
if($_POST){
    $id = JRequest::getVar('id_empresa','','post');
    newCRMActividad();
}
?>
<script>
    location.href = "index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>";
</script>
<? }else{vistaBloqueada();}?> 