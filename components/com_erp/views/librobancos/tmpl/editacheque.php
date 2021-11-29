<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<?
$id = JRequest::getVar('id','','get');
$cheque = getLBchequera($id);
?>
<?
$id = JRequest::getVar('id','','get');
$cheque = getLBchequera($id);
?>
<script>
jQuery(document).on('ready', function(){
    var limiteminimo;
    jQuery('#banco').on('change',function(){
        jQuery.ajax({
            url:'index.php?option=com_erp&view=librobancos&layout=chequeval&tmpl=blank',
            type:'POST',
            data:{banco: jQuery(this).val()}
        })
        .done(function(data){
            jQuery('#desde').val(data);
            limiteminimo = jQuery('#desde').val();
            limiteminimo++;
            jQuery('#hasta').attr('min', limiteminimo);
        })
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Activar Chequera</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
         <form action="" name="form" class="form-horizontal" method="POST">
             <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Banco <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <select name="banco" id="banco" class="form-control validate[required]">
                          <option value="">Seleccionar Banco</option>
                          <? foreach(getLBcuentas() as $banco){?>
                              <option value="<?=$banco->id?>" <?=$cheque->id_cuenta == $banco->id?'selected':''?>><?=$banco->banco?> - <?=$banco->cuenta?></option>
                          <? }?>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Desde <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="number" name="desde" id="desde" class="form-control validate[required]" step="any" placeholder="Nombre del Banco" readonly value="<?=$cheque->desde?>">
                  </div>
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Hasta <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-4">
                      <input type="number" name="hasta" id="hasta" class="form-control validate[required]" step="any" placeholder="Número de Cuenta del Banco" value="<?=$cheque->hasta?>">
                  </div>                  
              </div>
              <input type="hidden" name="id" value="<?=$cheque->id?>">
              <div class="col-xs-12 col-sm-offset-2">
                  <a href="index.php?option=com_erp&view=librobancos&layout=reportecheque" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Listado de Cheques</a>
                  <button type="submit" class="btn btn-success col-xs-12 col-sm-3"><fa class="fa fa-save"></fa> Activar Cheque</button>
              </div>
         </form>
         <? }else{
                editLBchequera();
          ?>
              <h3 class="alert alert-success">Se ha editado la activacion de la Chequera</h3>
              <a href="index.php?option=com_erp&view=librobancos&layout=listachequeras" class="btn btn-info col-xs-12 col-sm-3"><fa class="fa fa-arrow-left"></fa> Ir al Listado de Cheques</a>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>