<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<? 
destacaCliente();?>
<script>
location.href="index.php?option=com_erp&view=clientes&Itemid=802";
</script>
            <? }else{vistaBloqueada()};?>