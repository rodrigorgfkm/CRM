<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){
	$rubro = getRubro();?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Actividad</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" class="form-horizontal" id="form">
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Actividad <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                 <input type="text" name="rubro" id="rubro" class="form-control validate[required]" value="<?=$rubro->rubro?>">
             </div>
         </div>
         <div class="col-xs-12 col-sm-offset-2">
             <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-refresh"></i> Guardar Cambios</button>
         </div>
        </form>
        <? }else{
            editRubro();?>
            <h3>La actividad fue editada correctamente</h3>
            <p><a href="index.php?option=com_erp&view=facturacionrubro" class="btn btn-success">Volver</a></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>