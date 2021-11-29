<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo NIT</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>
        </div>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Etiqueta <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="etiqueta" id="etiqueta" class="form-control validate[required]">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Nombre <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="nombre" id="nombre" class="form-control validate[required]">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  NIT <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input type="text" name="nit" id="nit" class="form-control validate[required]">
              </div>
          </div>
          <div class="col-xs-12 col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar NIT</button>
          </div>             
        </form>
        <? }else{
            newNIT();?>
            <h3>El NIT fue creado correctamente</h3>
            <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=clientes&layout=nit&id=<?=JRequest::getVar('id', '', 'get')?>'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>
			