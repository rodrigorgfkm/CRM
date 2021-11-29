<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){
	$factura = getTipoFactura();?>
<?
$lim_nom = 150;
$lim_cod = 200;
$lim_pie = 500;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Tipo de Factura</h3>
      </div>
      <div class="box-body">
        <a href="index.php?option=com_erp&view=facturacionadmtipo" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal formchecks">
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Nombre <i class="fa fa-asterisk text-red"></i>
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <input type="text" name="factura" id="factura" class="form-control validate[required,maxSize[<?=$lim_nom?>]]" value="<?=$factura->factura?>">
                         <span class="help-block"><small>Este será el nombre del tipo de factura que se visualizará en la impresión<br/>
                                Si desea crear un salto de línea utilice el caracter |</small>
                         </span>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Código <i class="fa fa-asterisk text-red"></i>
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <input name="codigo" type="text" id="codigo" class="form-control validate[required,maxSize[<?=$lim_cod?>]]" value="<?=$factura->sigla?>">
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Pie de Factura <i class="fa fa-asterisk text-red"></i>
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <input type="text" name="pie" id="pie" class="form-control validate[required,maxSize[<?=$lim_pie?>]]" value="<?=$factura->pie?>">
                         <span class="help-block"><small>Es el texto que describe la Ley 453 al pie de la factura por ejemplo<br>
                        &quot;En caso de incumplimiento a lo ofertado o convenio el proveedor debe reparar o sustituir el producto&quot;</small>
                         </span>
                     </div>
                 </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Actividades Relacionadas <i class="fa fa-asterisk text-red"></i>
                     </label>
                     <div class="col-xs-12 col-sm-10">
                        <span class="msj-alerta text-red col-xs-12"></span>
                         <? 
                          foreach(getRubros() as $rubro){
                              verifyTipoFactura($rubro->id)?>                              
                              <label><input type="checkbox" name="act[]" class="validacheck" value="<?=$rubro->id?>" <?=verifyTipoFactura($rubro->id)==1?'checked':''?>>
                              <?=$rubro->rubro?></label>
                          <? }?>
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-offset-2">
                     <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-refresh"></i> Guardar Cambios</button>
                 </div>                
            </form>
            <? }else{
                editTipoFactura();?>
                <h3>El tipo de factura fue editado correctamente</h3>                
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>