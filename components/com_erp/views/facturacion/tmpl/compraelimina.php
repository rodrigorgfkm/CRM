<?php defined('_JEXEC') or die;?>
            <? if(validaAcceso('Registro de Compras')){?>
<?
deleteCompra();?>
<script>
location.href="index.php?option=com_erp&view=facturacion&layout=compras";
</script>
            
            <? }else{vistaBloqueada();}?>