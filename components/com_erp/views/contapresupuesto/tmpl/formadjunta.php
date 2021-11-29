<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){?>

<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contapresupuesto&layout=cargacuentas&tmpl=component', width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	jQuery('#cuenta').val(nombre);
	jQuery('#cuenta_id').val(id);
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cargar Archivos de presupuesto</h3>
      </div>
      <div class="box-body">
      <? if(!$_POST){?>
          <form action="" class="form-horizontal" name="form" id="form" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Detalle <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="text" name="detalle" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Adjunto <i class="fa fa-asterisk text-red"></i>                        
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="file" name="archivo" class="file">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Cuenta contable <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="text" name="cuenta" id="cuenta" class="form-control" onClick="popup()" readonly>
                      <input name="cuenta_debe_id" id="cuenta_id" type="hidden" id="cuenta_debe_id">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Monto <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="number" name="monto" id="monto" class="form-control" step="any">                      
                  </div>
              </div>
              <div class="div col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
              </div>
          </form>
      </div>
      <? }
	  else{
		  newCNTsolicitud();
		  ?>
	  <div class="box-body">
      	<h3>El Formulario se envió correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=contapresupuesto&layout=formadjunta" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver
            </a>
        </p>
      </div>
	  <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>