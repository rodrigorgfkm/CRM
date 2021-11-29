<?php defined('_JEXEC') or die;
if(validaAcceso('ERP')){?>
<script>
location.href = 'index.php';
</script>
<? }else{vistaBloqueada();}?>