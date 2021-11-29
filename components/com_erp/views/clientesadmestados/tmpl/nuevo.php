<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Gestion clientes estados')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Estado</h3>
      </div>    
      <div class="box-body">
          <?
        $lim_est = 15;
        if(!$_POST){?>
           <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Estado
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="estado" id="estado" class="form-control validate[required, maxSize[<?=$lim_est?>]]">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmactividades" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver al listado de Estados
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Crear Estado
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                newClienteEstado();
            ?>
            <h3>Se ha Registrado un nuevo tipo de Estado</h3>
            <p><a href="index.php?option=com_erp&view=clientesadmestados" class="btn btn-primary"><em class="fa fa-arrow-left"></em> Ir al listado de Estados</a></p>
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>