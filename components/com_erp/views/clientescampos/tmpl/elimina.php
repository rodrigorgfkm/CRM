<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Clientes')){?>
<?
$conf = getPosConfiguracion();
if(getCampoValores() != 0){
?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Eliminar campo</h3>
   		<h3>El campo no puede ser eliminado, porque existen datos de contacto registrados vinculados al campo</h3>
        <p><a href="index.php?option=com_erp&view=clientescampos" class="btn btn-success">Volver</a></p>
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientesadmi.php' );?>
			</div>
<? }else{
	deleteCampo();?>
<script>
location.href="index.php?option=com_erp&view=clientescampos";
</script>
<? }?>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>