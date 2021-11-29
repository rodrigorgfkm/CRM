<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administracion Libro de Bancos')){?>
<?
$id = JRequest::getVar('id','','get');
$reg = getLBcuenta($id);
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Cuenta de Banco</h3>
      </div>
      <div class="box-body">
        <?
          $lim_ban = 50;
          $lim_cta = 40;
        ?>
         <? if(!$_POST){?>
          <form action="" name="form" class="form-horizontal" method="post">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nombre de Banco <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="namebanco" class="form-control validate[required, maxSize[<?=$lim_ban?>]]" placeholder="Nombre del Banco" value="<?=$reg->banco?>">
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Número de Cuenta <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="text" name="nrocuenta" class="form-control validate[required, maxSize[<?=$lim_cta?>]]" placeholder="Número de Cuenta del Banco" value="<?=$reg->cuenta?>">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Tipo de Moneda <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <select name="tipomoneda" class="form-control validate[required]" placeholder="Tipo de Moneda de la Cuenta">
                          <option value="">Sin Asignar</option>
                          <option value="N" <?=$reg->moneda=="N"?'selected':''?>>Nacional</option>
                          <option value="E" <?=$reg->moneda=="E"?'selected':''?>>Extranjera</option>
                          <option value="E" <?=$reg->moneda=="O"?'selected':''?>>Otros</option>
                      </select>                      
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Número de Dígitos <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <select name="digitos" class="form-control validate[required]" id="">
                          <option value="">Sin Asignar</option>
                          <option value="2" <?=$reg->digitos==2?'selected':''?>>Dos Dígitos (<?=date('y')?>)</option>
                          <option value="4" <?=$reg->digitos==4?'selected':''?>>Cuatro Dígitos (<?=date('Y')?>)</option>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Imprimir Moneda <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <label for=""><input type="checkbox" name="impmoneda" id="impmoneda" value="1" <?=$reg->imp_moneda==1?'checked':''?>> Si</label>
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Imprimir Mes en Literal <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <label for=""><input type="checkbox" name="mesliteral" id="mesliteral" value="1" <?=$reg->mesliteral==1?'checked':''?>> Si</label>
                  </div>
              </div>
              <!--ya no hay saldo-->
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Tipo de de cambio<i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="number" name="tipo_cambio" id="tipo_cambio" step="any" class="form-control validate[required]" value="<?=$reg->tipo_cambio?>">
                  </div>
              </div>
              <input type="hidden" name="id" value="<?=$reg->id?>">
              <div class="col-xs-12 col-sm-offset-2">
                  <a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Mantenimiento de Bancos</a>
                  <button type="submit" class="btn btn-success col-xs-12 col-sm-3"><fa class="fa fa-edit"></fa> Editar Cuenta</button>
              </div>
          </form>
          <? }else{
                editLBcuenta();
          ?>
                  <h3 class="alert alert-success">Se ha Editado la Cuenta de Banco de <?=$reg->banco?></h3>
              <a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Mantenimiento de Bancos</a>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>