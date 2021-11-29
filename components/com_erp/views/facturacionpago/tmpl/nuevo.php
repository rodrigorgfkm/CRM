<?php defined('_JEXEC') or die;
if(validaAcceso('Administración Facturación')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Formas de Pago</h3>
      </div>
      <? if(!$_POST){?>
      <div class="col-xs-12 text-right">
          <div class="btn-group">
               <a href="index.php?option=com_erp&view=facturacionpago" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver</a>
          </div>          
      </div>
      <div class="box-body">
       <!--Nueva Etapa-->
        <form action="" name="form" id="form" class="form-horizontal" method="post" role="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Forma de Pago<i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="forma" id="forma" class="form-control validate[required]">
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-2">
                <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar</button>
            </div>
        </form>
        <? }else{
                newFACforma();
        ?>
                <h5 class="alert alert-success"> Se ha creado una nueva forma de pago correctamente</53>
                <a href="index.php?option=com_erp&view=facturacionpago" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>