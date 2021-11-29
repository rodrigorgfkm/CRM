<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<?
$lim_act = 50;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Actividad</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" class="form-horizontal" id="form">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Actividad <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="rubro" id="rubro" class="form-control validate[required,maxSize[<?=$lim_act?>]]">
                 </div>
             </div>
             <div class="col-xs-12 col-sm-offset-2">
                 <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar Actividad</button>
             </div>
            </form>
            <? }else{
                newRubro();?>
                <h3>la actividad fue creada correctamente</h3>
                <p><a href="index.php?option=com_erp&view=facturacionrubro" class="btn btn-success">Volver</a></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>