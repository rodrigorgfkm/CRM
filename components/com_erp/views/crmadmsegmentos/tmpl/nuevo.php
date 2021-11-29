<?php defined('_JEXEC') or die;
?>
<? if(validaAcceso('CRM ')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Segmento</h3>
      </div>
      <div class="box-body">
         <? if(!$_POST){?>
          <form name="form" id="form" class="form-horizontal" role="form" method="post">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nombre del Segmento<i class="fa fa-asterisk text-red"></i> 
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="segmento" id="segmento" class="form-control validate[required]">
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <a href="index.php?option=com_erp&view=crmadmsegmentos" class="btn btn-info btn-sm"><i class="fa fa-arrow-left"></i> Ir a la Lista de Segmentos</a>
                  <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar Plantilla</button>
              </div>
          </form>
          <? }else{
              newCRMsegmento();
          ?>
          <h4 class="alert alert-success"> Se ha registrado el segmento</h4>
          <a href="index.php?option=com_erp&view=crmadmsegmentos" class="btn btn-info"><i class="fa fa-arrow-left"></i> Ir a la Lista de Segmentos</a>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>