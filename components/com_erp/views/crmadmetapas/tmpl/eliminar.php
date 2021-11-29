<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Etapas')){
    $id = jRequest::getVar('id','','get');
    if(getCRMEtapasAct($id)!=0){
        print "<h3 class='alert alert-danger'>Usted no Puede eliminar este estado ya que tiene Prospectos en él</h3>";
    }elseif(getCRMEtapasAct($id)==0){
        deleteCRMEtapas();
        print "<script>location.href = 'index.php?option=com_erp&view=crmadmetapas';</script>";
    }
?>
<? }else{vistaBloqueada();}?>