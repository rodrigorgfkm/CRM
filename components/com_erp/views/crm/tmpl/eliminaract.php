<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Actividad')){
    if($_POST){
        $id = JRequest::getVar('ide_empresa','','post');
        $id_actividad = JRequest::getVar('id_activ','','post');
        deleteCRMActividad($id_actividad);
    }
?>
<script>
   location.href = "index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>";
</script>
<? }else{vistaBloqueada();}?> 