<?
if(validaAcceso('CRM Etapas')){
$cantidad = enableCRMEtapas();
$sw=0;
if(JRequest::getVar('publicado','','post')==0){
    $sw = 1;
}elseif(getCRMEtapasAct(JRequest::getVar('id','','post'))>0){
    $sw = 0;
}
echo $sw;
?>
<? }else{vistaBloqueada();}?>