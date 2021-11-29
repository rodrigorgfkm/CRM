<?php defined('_JEXEC') or die;
if(validaAcceso('Crear Factura')){
$empresa = getCliente(JRequest::getVar('id', '', 'post'));
$nit = getNit(JRequest::getVar('id', '', 'post'));?>
<!-- INICIO --><?=$empresa->empresa.':::'.$nit->nit?><!-- FIN -->
<? }else{vistaBloqueada();}?>