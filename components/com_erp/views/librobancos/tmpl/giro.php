<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Transacciones')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Giro de cheques</h3>
      </div>
      <div class="box-body">
        <?
          $lim_ciu = 50;
          $lim_mon = 8;
          $lim_nom = 50;
          $lim_det = 50;
          $lim_chq = 12;
        ?>
         <? if(!$_POST){?>
         <form action="" name="form" class="form-horizontal" method="POST">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                      Ciudad <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="ciudad" class="form-control validate[required, maxSize[<?=$lim_ciu?>]]" placeholder="Ciudad">
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Fecha <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="fecha" class="form-control datepicker validate[required]" placeholder="Fecha" readonly>
                  </div>
             </div>
             <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Monto <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="monto" class="form-control validate[required, maxSize[<?=$lim_mon?>]]" placeholder="Monto">
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nombre <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="nombre" id="nombre" class="form-control validate[required,maxSize[<?=$lim_nom?>]]" placeholder="Nombre de la persona">
                  </div>
              </div>              
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Detalle <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="detalle" id="detalle" class="form-control validate[required, maxSize[<?=$lim_det?>]]" placeholder="Detalle">
                  </div>                  
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Cheque <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="cheque" id="cheque" class="form-control validate[required, maxSize[<?=$lim_chq?>]]" placeholder="Cheque">
                  </div>                      
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Banco <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <select name="banco" id="banco" class="form-control validate[required]">
                          <option value="">Seleccionar Banco</option>
                          <? foreach(getLBcuentas() as $banco){?>
                              <option value="<?=$banco->id?>"><?=$banco->banco?> - <?=$banco->cuenta?></option>
                          <? }?>
                      </select>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <a href="index.php?option=com_erp&view=librobancos&layout=listadodegiros" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Listado de Giros</a>
                  <button type="submit" class="btn btn-success col-xs-12 col-sm-3"><fa class="fa fa-save"></fa> Girar Cheque</button>
              </div>
         </form>
         <? }else{
                newLBcheque();
          ?>
              <h3 class="alert alert-success">Se ha Realizado el giro</h3>
              <a href="index.php?option=com_erp&view=librobancos&layout=listadodegiros" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Listado de Giros</a>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>