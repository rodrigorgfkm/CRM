<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<?
deleteUnidad();
?>
<script>
location.href="index.php?option=com_apetitapp&view=unidades&Itemid=802";
</script>
<? }else{vistaBloqueada(); }?>