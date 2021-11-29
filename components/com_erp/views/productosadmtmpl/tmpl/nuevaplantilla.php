<?php defined('_JEXEC') or die;
$editor =& JFactory::getEditor();
?>
<? if(validaAcceso('Validación sistema')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Plantilla</h3>
      </div>
      <div class="box-body">
          <form name="form" id="form" class="form-horizontal" role="form">
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
                      Plantilla <i class="fa fa-asterisk text-red"></i> 
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <?= $editor->display( 'plantilla', '', '100%', '100', '20', '20', false, null, null, null, $params ); ?>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar Plantilla</button>
              </div>
          </form>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>