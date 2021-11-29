<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Facturas')){
actualizaFacturaMasiva();
?>
<? }else{vistabloqueada(); }?>