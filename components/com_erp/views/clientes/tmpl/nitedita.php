<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
    $nit = get_NIT();?>  
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Edita NIT</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Etiqueta <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="etiqueta" id="etiqueta" class="form-control validate[required]" value="<?=$nit->etiqueta?>">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Nombre <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="nombre" id="nombre" class="form-control validate[required]" value="<?=$nit->nombre?>">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  NIT <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="nit" id="nit" class="form-control validate[required]" value="<?=$nit->nit?>">
              </div>
          </div>
          <div class="col-xs-12 col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar NIT</button>
          </div>             
        </form>
        <? }else{
            editNIT();?>
            <h3>El NIT fue editado correctamente</h3>
            <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=clientes&layout=nit&id=<?=JRequest::getVar('id', '', 'get')?>'"></p>
            <?
            }?>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>