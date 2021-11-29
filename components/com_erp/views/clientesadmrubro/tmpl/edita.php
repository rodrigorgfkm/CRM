<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){
$id = JRequest::getVar('id', '', 'get');
$reg = getTipoSociedad($id);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Rubro</h3>
      </div>    
      <div class="box-body">
          <?
        $lim_cat = 15;
        $lim_sig = 5;
        if(!$_POST){?>
           <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Tipo
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="tipo" id="tipo" class="form-control validate[required, maxSize[<?=$lim_cat?>]]" value="<?=$reg->tipo?>">
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
                    <input type="text" name="sigla" id="sigla" class="form-control validate[required, maxSize[<?=$lim_sig?>]]" value="<?=$reg->sigla?>">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="index.php?option=com_erp&view=clientesadmrubro" class="btn btn-info col-xs-12 col-md-4">
                    <em class="fa fa-arrow-left"></em>
                    Volver al listado de Sociedades
                </a>
                <button type="submit" class="btn btn-success pull-right col-xs-12 col-md-4">
                    <em class="fa fa-save"></em>
                    Crear Sociedad
                </button>
              </div>
              <div class="box-footer">
                Los campos marcados con <em class="fa fa-asterisk text-red"></em> son obligatorios.
              </div>
            </form>
            <? }else{
                editTipoSociedad();
            ?>
            <script>
                location.href = "index.php?option=com_erp&view=clientesadmrubro";
            </script>            
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>