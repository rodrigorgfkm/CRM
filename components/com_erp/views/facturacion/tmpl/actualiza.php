<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
actualizaFactura();
?>
<? }else{vistaBloqueada();}?>