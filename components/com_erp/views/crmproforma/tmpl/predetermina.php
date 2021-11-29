<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Clientes Proforma') or validaAcceso('CRM Registro')){?>
<?
changePlantilla(3);?>
<script>
location.href="index.php?option=com_erp&view=clientesproforma&layout=plantilla";
</script>
<? }else{ vistaBloqueada(); }?>