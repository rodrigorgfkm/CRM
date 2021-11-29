<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Unidad</h3>
      </div>
      <div class="box-body">
       <?
        $lim_uni = 25;  
        $lim_sim = 15;  
        ?>
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" class="form-horizontal" name="form" id="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-3 control-label">
                    Unidad <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-9">
                    <input type="text" name="unidad" id="unidad" class="form-control validate[required, maxSize[<?=$lim_uni?>]]">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-3 control-label">
                    Simbolo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-9">
                    <input type="text" name="simbolo" id="simbolo" class="form-control validate[required, maxSize[<?=$lim_sim?>]]">
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-3">
                <input type="submit" name="submit" id="submit" class="btn btn-success"  value="Guardar">
                <a href="index.php?option=com_erp&view=productosadmunidades" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
            </div>
        </form>
        <? }else{
            newUnidad();?>
            <h3>La unidad fue creada correctamente</h3>
            <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=productosadmunidades'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>