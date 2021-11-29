<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Registro')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear tipo de Comprobante</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Tipo de Comprobante<i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                       <input type="text" class="form-control" name="tipo" id="tipo">
                   </div>
               </div>
               <div class="col-xs-12 col-sm-offset-2">
                   <button type="submit" name="submit" id="submit" class="btn btn-success col-xs-12 col-sm-3"><i class="fa fa-check"></i> Enviar</button>
               </div>              
            </form>
            <? }else{
                newTipoComprobante();?>
                <h3>El tipo de comprobante fue creado correctamente</h3>
                <p><a class="btn btn-success" href="index.php?option=com_erp&view=contatipos">Volver</a></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>