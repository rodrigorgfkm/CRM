<?php defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){
$lim_cobra = 25;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-send-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Formas de Envio</h3>
      </div>
      <? if(!$_POST){?>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacionadmcobranzas" class="btn btn-info"><i class="fa fa-arrow-left"></i> Ir al listado de pago</a>
          </div>          
      </div>
      <div class="box-body">
       <!--Nueva Etapa-->
        <form action="" name="form" id="form" class="form-horizontal" method="post" role="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Forma de Envio <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="modo_envio" id="modo_envio" class="form-control validate[required,maxSize[<?=$lim_cobra?>]]">
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-2">
                <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar</button>
            </div>
        </form>
        <? }else{
                newFACcobranza();
        ?>
                <h5 class="alert alert-success"> Se ha Creado una nueva forma de Envio</53>
                <a href="index.php?option=com_erp&view=facturacionadmcobranzas" class="btn btn-succes"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>