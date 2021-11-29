<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Actividad')){
    $id = JRequest::getVar('id','','post');
    deleteCRMContactoProspecto($id);
?>
<? }else{vistaBloqueada();}?> 