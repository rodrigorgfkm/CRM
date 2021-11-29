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
<? $solicitud = getCNTsolicitud(JRequest::getVar('id','','get'));?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Solicitud Presupuesto</h3>
      </div>
      <div class="box-body">
         <div>
              <a href="index.php?option=com_erp&view=presupuesto&layout=solicitudes" class="btn btn-info pull-right">
                    <em class="fa fa-arrow-left"></em>
                    Volver
                </a>
         </div>
          <form action="" class="form-horizontal" name="form" id="form" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Detalle
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="text" name="detalle" class="form-control" value="<?=$solicitud->detalle?>" readonly>
                  </div>
              </div>
              <? if($solicitud->adjunto!=''){?>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Adjunto 
                  </label>
                  <div class="col-sx-12 col-sm-4">
                     <?=$solicitud->adjunto?>
                      <a href="<?='media/com_erp/adjunto/'.$solicitud->adjunto?>" class="btn btn-success"><i class="fa fa-download"></i> Descargar Archivo</a>
                  </div>
              </div>
              <? }?>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Cuenta de Presupuesto
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="text" name="cuenta" id="cuenta" class="form-control" value="<?=$solicitud->cuenta?>" readonly>
                      <input name="cuenta_debe_id" id="cuenta_id" type="hidden" id="cuenta_debe_id" value="<?=$solicitud->id_cuenta?>">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Monto 
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="number" name="monto" id="monto" class="form-control" step="any" value="<?=$solicitud->monto?>" readonly>
                  </div>
              </div>
          </form>
      </div>
      <? ?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>