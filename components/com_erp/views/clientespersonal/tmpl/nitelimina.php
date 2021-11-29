<?php defined('_JEXEC') or die;?>
            <? if(validaAcceso('Registro de Clientes')){?>
<?
deleteNIT();?>
<script>
location.href="index.php?option=com_erp&view=clientes&layout=nit&id=<?=JRequest::getVar('id', '', 'get')?>";
</script>
            <? }else{vistaBloqueada();}?>