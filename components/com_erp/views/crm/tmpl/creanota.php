<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
if($_POST){
    $id = JRequest::getVar('id','','post');
    newCRMNota();
}
?>
<script>
    location.href = "index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>";
</script>
<? }else{vistaBloqueada();}?>