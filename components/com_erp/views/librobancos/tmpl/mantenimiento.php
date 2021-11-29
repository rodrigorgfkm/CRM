<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador Libro de Bancos')){?>
<script>
function confirma(id){
    var url = 'index.php?option=com_erp&view=librobancos&layout=desactivacuenta&tmpl=blank';
    jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Desactivar Cuenta');
    jQuery('.modal-body').html('<p>¿Está seguro de Desactivar la Cuenta?</p><p>Esta Operación es Irreversible</p>');
    jQuery('.modal-footer').html('<form action="'+url+'" name="form" method="POST">'+
                                 '<input type="hidden" name="id" value="'+id+'">'+
                                 '<button class="btn btn-danger" data-dismiss="modal"><em class="fa fa-remove"></em> Cancelar</button>'+
                                 '<button type="submit" class="btn btn-success"><em class="fa fa-check"></em> Confirmar</button></form>');
    jQuery('#ventanaModal').trigger('click');
}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Mantenimiento de Bancos</h3>
      </div>
      <div class="box-body">
          <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Banco</th>
                  <th>Nro. de Cuenta</th>
                  <th>Tipo de Moneda</th>
                  <th width="120">Acciones</th>
              </thead>
              <tbody>
                 <? 
                  foreach(getLBcuentas() as $banco){?>
                      <tr>
                          <td><?=$banco->banco?></td>
                          <td><?=$banco->cuenta?></td>
                          <td><?=$banco->moneda=="E"?'Extranjera':'Nacional'?></td>
                          <td class="text-center">
                             <? if($banco->activa==1){?>
                              <a href="index.php?option=com_erp&view=librobancos&layout=editar&id=<?=$banco->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                              <button class="btn btn-danger" data-toggle="tooltip" title="Desactivar Cuenta" data-placement="top" onclick="confirma(<?=$banco->id?>)"><i class="fa fa-power-off"></i></button>
                              <a href="index.php?option=com_erp&view=librobancos&layout=tmplcheque&id=<?=$banco->id?>" class="btn bg-purple" data-toggle="tooltip" title="Editar Cheque"><i class="fa fa-credit-card"></i></a>
                             <? }else{?>
                                 <button type="button" class="btn btn-warning" data-toggle="tooltip" title="Cuenta Desactivada" data-placement="top"><i class="fa fa-unlink"></i></button>
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