<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
	$id = JRequest::getVar('banco', '', 'get');?>
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
})
function enviaFiltro(){
	var id = jQuery('#banco').val();
	location.href = 'index.php?option=com_erp&view=librobancos&layout=listacheques&banco='+id;
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de cheques</h3>
      </div>
      <div class="container-fluid">
          <div class="col-xs-12  col-sm-9 pull-left">
            <label for="" class="col-xs-12 col-sm-2">Banco </label>
            <select name="banco" id="banco" class="form-control" style="width: auto; display:inline">
                <option value="">Seleccionar Banco</option>
                <? foreach (getLBcuentas() as $banco){?>
                    <option value="<?=$banco->id?>" <?=$id==$banco->id?'selected':''?>><?=$banco->banco?> - <?=$banco->cuenta?></option>
                <? }?>
            </select>
            <button type="button" onClick="enviaFiltro()" class="btn btn-info"><i class="fa fa-filter"></i> Filtar</button>
          </div>
          <div class="col-xs-12 col-sm-3">
              <div class="btn-group pull-right">
                  <button class="btn btn-success imprimecheque" style="display:none"><i class="fa fa-print"></i> Imprimir</button>
              </div>
          </div>
      </div>
      <div class="box-body">
        <form id="fomrcheques" action="index.php?option=com_erp&view=librobancos&layout=postcheques" method="POST">            
         <table class="table table-striped table-bordered datatable">
              <thead>
                  <th></th>
                  <th>Banco</th>
                  <th>Nro. de Cuenta</th>
                  <th>Nro. Cheque</th>
                  <th>Girado a</th>
                  <th>Monto</th>
              </thead>
              <tbody>
                  <? 
				  if($id != ''){?>
                  <?  
				  $n = 0;
				    foreach(getLBcheques($id) as $cheque){
					  $n++;
                      $cuentabanco = getLBcuenta($cheque->id_cuenta);
					  if($cuentabanco->moneda == 'N')
					  	$mon = 'Bs. ';
						else
						$mon = '$us ';
                        ?>
                          <tr>
                              <td><?=$n?></td>
                              <td><?=$cuentabanco->banco?></td>
                              <td><?=$cuentabanco->cuenta?></td>
                              <td><?=$cheque->numero?></td>
                              <td><?=$cheque->nombre?></td>   
                              <td class="text-right"><?=$mon.num2monto($cheque->monto)?></td>                       
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
<? /*}else{
    vistaBloqueada();
}*/?>