<?php defined('_JEXEC') or die;
if(validaAcceso('Libro de Bancos Cheques')){?>
<script>
function confirma(id, banconum, nombre, detalle){
    jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Suspender Asociado');
    jQuery('.modal-body').html('<p>¿Esta seguro de Anular el Cheque?</p>'+
                                '<p><b>Cuenta: </b>'+banconum+'</p>'+
                                '<p><b>Dirigido a: </b>'+nombre+'</p>'+
                                '<p><b>Detalle: </b>'+detalle+'</p>'+
                                '<form class="form-horizontal" name="form" action="index.php?option=com_erp&view=librobancos&layout=anulandocheque" method="post">'+
                                '<textarea name="motivo" class="form-control validate[required]" placeholder="Motivo"></textarea>'+
                                '<input type="hidden" name="id" value="'+id+'">'+
                                '<button class="btn btn-danger" data-dismiss="modal"><em class="fa fa-remove"></em> Cancelar</button>'+
                                '<button type="submit" class="btn btn-success pull-right"><em class="fa fa-check"></em> Confirmar</button>'+
                                '</form>'
                              );
    jQuery('.modal-footer').html('');
    jQuery('#ventanaModal').trigger('click');
}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Anular Cheque</h3>
      </div>
      <div class="box-body">
         <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Cuenta</th>
                  <th>Dirigido a</th>
                  <th>Detalle</th>
                  <th>Monto</th>
                  <th width="80">Acciones</th>
              </thead>
              <tbody>
                 <? foreach(getLBcheques() as $cheque){
                        $cuentabanco = getLBcuenta($cheque->id_cuenta);
                        $anulado = getLBcheque($cheque->id);
                  ?>
                      <tr>
                          <td><?=$cuentabanco->banco.' - '.$cuentabanco->cuenta?></td>
                          <td><?=$cheque->nombre?></td>
                          <td><?=$cheque->detalle?></td>
                          <td><?=$cheque->monto?></td>
                          <td>
                             <? if($anulado->anulado==0){?>
                                  <button class="btn btn-danger" onclick="confirma(<?=$cheque->id?>,'<?=$cuentabanco->banco.' - '.$cuentabanco->cuenta?>','<?=$cheque->nombre?>','<?=$cheque->detalle?>')"><i class="fa fa-remove"></i></button>
                             <? }else{?>
                                  <button type="button" class="btn bg-purple"><i class="fa fa-ban"></i> Anulado</button>
                             <? }?>
                          </td>
                      </tr>
                 <? }?>
              </tbody>
          </table>          
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>