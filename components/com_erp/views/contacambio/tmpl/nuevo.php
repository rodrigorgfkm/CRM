<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Cambio')){
$moneda = getMoneda()?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear tipo de cambio del d&iacute;a de hoy</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form action="" method="post" name="form" id="form" class="form-horizontal" role="form">
                 <div class="form-group">
                     <label class="col-xs-12 col-sm-2">
                         Fecha 
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <?=fecha(date('Y-m-d'))?>
                     </div>
                 </div>
                 <div class="form-group">
                     <label class="col-xs-12 col-sm-2">
                         Cambio 
                     </label>
                     <div class="col-xs-12 col-sm-10">
                         <input type="text" name="cambio" id="cambio" class="form-control validate[required]">
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-offset-2">
                     <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-2"><i class="fa fa-floppy-o"></i> Guardar</button>                     
                 </div>
            </form>
            <? }else{
                newTipoCambio();
                ?>
                <h3>El tipo de cambio se guardó correctamente</h3>
                <p><a href="index.php?option=com_erp&view=contacambio&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success">Volver</a></p>
         <? }?>
      </div>      
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>