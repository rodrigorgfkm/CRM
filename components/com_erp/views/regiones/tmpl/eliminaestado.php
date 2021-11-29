<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración POS')){?>
<?
deleteEstado();
?>
<script>
location.href="index.php?option=com_erp&view=regiones&layout=estados&id=<?=JRequest::getVar('id', '', 'get')?>";
</script>
<? }else{vistaBloqueada();}?>