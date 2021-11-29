<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras')){?>
<?
deleteFacturaManual();?>
<script>
    location.href='index.php?option=com_erp&view=facturacion&layout=manual';
</script>
<? }else{vistaBloqueada();}?>