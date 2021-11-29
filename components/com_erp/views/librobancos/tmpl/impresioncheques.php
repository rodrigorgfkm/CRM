<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Transacciones')){?>
<script>
jQuery(document).on('ready',function(){
    jQuery('[type=checkbox]').on('click',function(){
        if(jQuery(this).prop('checked')){
            jQuery(this).closest('tr').addClass('resalta');
        }else{
            jQuery(this).closest('tr').removeClass('resalta');
        }
        if(jQuery('[type=checkbox]:checked').length>0){
            jQuery('.imprimecheque').show(500);
        }else{
            jQuery('.imprimecheque').hide(500);            
        }
    })
    jQuery('.imprimecheque').on('click', function(){
        jQuery('#fomrcheques').trigger('submit');        
    })
    /*jQuery('.filtrar').on('click',function(){
        jQuery('#banco').val()
    })*/
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-print"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Impresión de Cheques</h3>
      </div>
      <div class="container-fluid">
          <div class="col-xs-12  col-sm-9 pull-left">
              <form action="" name="form" class="form-inline" method="post">
                  <label for="" class="col-xs-12 col-sm-2">Banco </label>
                  <select name="banco" id="banco" class="form-control">
                      <option value="">Seleccionar Banco</option>
                      <? foreach (getLBcuentas() as $banco){?>
                          <option value="<?=$banco->id?>" <?=JRequest::getvar('banco','','get')==$banco->id?'selected':''?>><?=$banco->banco?> - <?=$banco->cuenta?></option>
                      <? }?>
                  </select>
                  <button type="submit" class="btn btn-info filtrar"><i class="fa fa-filter"></i> Filtar</button>
              </form>
          </div>
          <div class="col-xs-12 col-sm-3">
              <div class="btn-group pull-right">
                  <button class="btn btn-success imprimecheque" style="display:none"><i class="fa fa-print"></i> Imprimir</button>
              </div>
          </div>
      </div>
      <div class="box-body">
        <form id="fomrcheques" action="index.php?option=com_erp&view=librobancos&layout=postcheques" method="POST">
         <input type="hidden" name="id_banco" value="<?=JRequest::getvar('banco','','post')?>">
         <table class="table table-striped table-bordered datatable">
              <thead>
                  <th></th>
                  <th>Cuenta</th>
                  <th>Dirigido a</th>
                  <th>Detalle</th>
                  <th>Monto</th>
              </thead>
              <tbody>
                  <? if($_POST){?>
                  <?      foreach(getLBcheques(JRequest::getvar('banco','','post'), 1) as $cheque){
                            $cuentabanco = getLBcuenta($cheque->id_cuenta);                            
                        ?>
                          <tr>
                              <td>
                                  <input type="checkbox" name="idcheque[]" id="" value="<?=$cheque->id?>">
                                  <input type="hidden" name="cheque" value="">
                              </td>
                              <td><?=$cuentabanco->banco.' - '.$cuentabanco->cuenta?></td>
                              <td><?=$cheque->nombre?></td>
                              <td><?=$cheque->detalle?></td>
                              <td><?=$cheque->monto?></td>                          
                          </tr>
                     <? }
                    }?>
              </tbody>
          </table>
        </form>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>