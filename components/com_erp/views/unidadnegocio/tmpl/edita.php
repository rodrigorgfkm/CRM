<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){
$id = JRequest::getVar('id', '', 'get');
$reg = getUnidadDeNegocio();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Unidad de Negocio</h3>
      </div>    
      <div class="box-body">
          <?
        $lim_cat = 255;
        $lim_sig = 5;
        if(!$_POST){?>
           <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Unidad de Negocio
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="unidad" id="unidad" class="form-control validate[required, maxSize[<?=$lim_cat?>]]" value="<?=$reg->unidad_negocio?>">
                  </div>
                </div>
              </div>
              <input type="hidden" name="id" value="<?=$reg->id?>">
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=unidadnegocio" class="btn btn-info">
                    <em class="fa fa-arrow-left"></em>
                    Volver al listado de Unidades de Negocios
                </a>
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-refresh"></em>
                    Actualizar Unidad de Negocio
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                editUnidadDeNegocio();
            ?>
            <script>
                location.href = "index.php?option=com_erp&view=unidadnegocio";
            </script>            
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>