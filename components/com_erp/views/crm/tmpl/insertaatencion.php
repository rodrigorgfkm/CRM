<?
    $id = JRequest::getVar('id_empresa','','post');
    newCRMAtencion();    
    if(JRequest::getVar('tipo','','post')!=""){
        newCRMActividad();        
    }
?>
<script>
    location.href = "index.php?option=com_erp&view=crm&layout=empresa&id=<?=$id?>";
</script>