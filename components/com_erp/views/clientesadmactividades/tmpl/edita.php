<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Gestion clientes actividades')){
$actividad = getClienteActividad(JRequest::getVar('id','','get'));
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Actividad</h3>
      </div>    
      <div class="box-body">
          <?
        $lim_act = 20;
        if(!$_POST){?>
           <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Actividad
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="actividad" id="actividad" class="form-control validate[required, maxSize[<?=$lim_act?>]]" value="<?=$actividad->actividad?>">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmactividades" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver al listado de Actividades
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-refresh"></em>
                    Editar actividad
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                editClienteActividad();
            ?>
            <h3>Se ha Editado la Actividad</h3>
            <p><a href="index.php?option=com_erp&view=clientesadmactividades" class="btn btn-primary"><em class="fa fa-arrow-left"></em> Ir al listado de Actividades</a></p>
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>