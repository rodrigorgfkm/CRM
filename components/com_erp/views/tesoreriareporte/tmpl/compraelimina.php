<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras') or validaAcceso('Administrador Tesorería')){?>
<?
deleteCompra();?>
<script>
location.href = 'index.php?option=com_erp&view=tesoreriareporte&layout=compras';
</script>
            
<? }else{vistaBloqueada();}?>