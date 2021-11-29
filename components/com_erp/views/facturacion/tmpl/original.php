<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Revierte Original') || validaAcceso('Administrador')){?>
<?
revierteFactura();?>
<script>
location.href="index.php?option=com_erp&view=facturacion&layout=factura&id=<?=JRequest::getVar('id', '', 'get')?>";
</script>
            <? }else{vistaBloqueada();}?>