<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Transacciones')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Egreso Sin Cheque</h3>
      </div>
      <?
        $lim_det = 50;
        $lim_mon = 20;
      ?>
      <div class="box-body">
        <? if(!$_POST){?>
         <form name="form" method="POST" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Fecha <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="fecha" id="fecha" class="form-control datepicker validate[required]" readonly placeholder="Fecha">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                     Detalle <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="text" name="detalle" id="detalle" class="form-control validate[required,maxSize[<?=$lim_det?>]]" placeholder="Detalle">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Monto <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <input type="number" name="monto" id="monto" step="any" class="form-control validate[required,maxSize[<?=$lim_mon?>]]" placeholder="Monto">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2 control-label">
                    Banco <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <select name="banco" id="banco" class="form-control validate[required]">
                        <option value="">Seleccionar Banco</option>
                        <? foreach(getLBcuentas() as $banco){?>
                              <option value="<?=$banco->id?>"><?=$banco->banco?> - <?=$banco->cuenta?></option>
                        <? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-success col-xs-12 col-sm-3"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
         </form>
        <? }else{
          newLBingeg("E");
          ?>
            <div class="col-xs-12">
                <h3 class="alert alert-success">Se ha Registrado el Egreso Correctamente</h3>
            </div>          
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>