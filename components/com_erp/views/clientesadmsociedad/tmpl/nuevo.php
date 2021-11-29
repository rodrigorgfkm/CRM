<?php 
defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Tipo de Sociedad</h3>
      </div>    
      <div class="box-body">
          <? 
         $lim_tipo = 15;
         $lim_sig = 6;
         if(!$_POST){?>
           <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Tipo
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="tipo" id="tipo" class="form-control validate[required, maxSize[<?=$lim_tipo?>]]">                    
                  </div>
                </div>
              </div>
              <div class="box-body">
              	<div class="form-group">
                  <label for="sigla" class="col-sm-3 control-label">
                    Sigla
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="sigla" id="sigla" class="form-control validate[required, maxSize[<?=$lim_sig?>]]">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmsociedad" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver al listado de Tipos de Sociedad
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Crear Sociedad
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                newTipoSociedad();
            ?>
            <h3>Se ha Registrado un nuevo tipo de Sociedad</h3>
            <p><a href="index.php?option=com_erp&view=clientesadmsociedad" class="btn btn-primary"><em class="fa fa-arrow-left"></em> Ir al listado de sociedades</a></p>
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>