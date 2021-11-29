<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'post');
$nit = getNitCompra();?>
<!-- INICIO --><?=$id?>|<?=$nit->id?>|<?=$nit->empresa?>|<?=$nit->nit?><!-- FIN -->