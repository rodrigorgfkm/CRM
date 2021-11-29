<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<?
publicaCliente();?>
<script>
location.href="index.php?option=com_erp&view=clientes&Itemid=802";
</script>
            <? }else{?>
			<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
                <style>
                #maincontainer{ background:#FFF !important}
                </style>
			<? }?>