<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Validación sistema')){?>
<script>
function cierraventana(id){
	jQuery('#row_'+id+' .estado').html('<a class="btn btn-danger span12" style="cursor: default">Anulada</a>');
	Shadowbox.close()
	}
</script>
<?
$lim_naut = 25;
$lim_nfac = 25;
$lim_nit = 10;
$lim_total = 20;
$lim_llave = 500;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-check-circle-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Validar Sistema</h3>		
      </div>
      <div class="box-body">
        <? if(JRequest::getVar('codigo', '', 'post') == ''){?>
        <form action="index.php?option=com_erp&view=facturacionadmvalida&layout=validasistemacodigo&tmpl=component" name="form" id="form" method="post" class="form-horizontal">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">Número de Autorización <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="auth" class="form-control validate[required, maxSize[<?=$lim_naut?>]]">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">Número de la factura <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="numero" class="form-control  validate[required,maxSize[<?=$lim_nfac?>]]">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">NIT <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="nit" class="form-control validate[required, maxSize[<?=$lim_nit?>]]">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">Fecha de Emisión <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="fecha" class="form-control validate[required]">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">Total <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="total" class="form-control validate[required, maxSize[<?=$lim_total?>]]">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">Llave de Dosificación <i class="fa fa-asterisk text-red"></i></label>
               <div class="col-xs-12 col-sm-10">
                   <input type="text" name="llave" class="form-control validate[required, maxSize[<?=$lim_llave?>]]">
               </div>
           </div>
           <div class="col-xs-12 col-sm-offset-2">
               <button type="submit" name="enviar" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-code"></i> Generar Código</button>
           </div>
        </form>
        <? }else{?>
        <h2>El código es: <?=JRequest::getVar('codigo', '', 'post')?></h2>
        <p><a href="index.php?option=com_erp&view=facturacion&layout=validasistema" class="btn btn-success">Siguiente</a></p>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>