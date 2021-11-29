<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Base')){

$id = JRequest::getVar('id', '', 'get');
?>
<script>
function confirma(id){
	jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Eliminar cuenta');
	jQuery('.modal-body').html('<p>&iquest;Esta seguro de eliminar la cuenta seleccionada?</p><p>Al confirmar el proceso también se eliminarán las cuentas dependientes de la misma</p>');
	jQuery('.modal-footer').html('<a class="btn btn-danger" href="index.php?option=com_erp&view=multicuentas&layout=elimina&id='+id+'"><em class="fa fa-trash"></em> Eliminar</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
	jQuery('#ventanaModal').trigger('click');
	}
jQuery(document).on('ready',function(){
    jQuery('[type=checkbox]').on('click',function(){
        if(jQuery( "input:checked" ).length>0){
            jQuery('.eliminacta').show(500);
        }else{
            jQuery('.eliminacta').hide(500);
        }
        if(jQuery(this).is(':checked')){
            jQuery(this).closest('tr').addClass('resalta');
        }else{
            jQuery(this).closest('tr').removeClass('resalta');
        }
    })
    jQuery("#checkTodos").change(function () {
    	jQuery("input:checkbox").prop('checked', jQuery(this).prop("checked"));
    });
})

</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
    <? if(!$_POST){?>
   <form action="" name="form" method="POST">
      <div class="box-header">
        <i class="fa fa-reorder"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Plan de Cuentas</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-danger eliminacta" data-toggle="modal" data-target=".borracuentas" style="display:none">
            	<em class="fa fa-trash"></em>
            	Eliminar Cuentas Seleccionadas
            </button >
            <a href="index.php?option=com_erp&view=multicuentas&layout=nuevo" class="btn btn-success">
            	<em class="fa fa-plus"></em>
                Nueva cuenta
            </a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="tabladinamicanp">
          <thead>
            <tr>
              <th width="10"><input type="checkbox" id="checkTodos" name="todos" class="seleccion_cta"></th>
              <th width="20">#</th>
              <th width="100">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="100">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
			foreach(getCNTcuentasMAIN() as $cta){?>
			<tr>
              <td>
                 <? if(getCNThaschildMAIN($cta->id) == 0){?>
                  <input type="checkbox" name="seleccion_cta[]" id="" class="seleccion_cta" value="<?=$cta->id?>">
                 <? }?>
              </td>
			  <td><?=$n?></td>
			  <td><?=codigoRename($cta->codigo)?></td>
			  <td><?=$cta->nombre_completo?></td>
			  <td>
				  <a class="btn btn-success btn-sm" href="index.php?option=com_erp&view=multicuentas&layout=edita&id=<?=$cta->id?>">
					  <em class="fa fa-pencil"></em>
				  </a>
                 <? if(getCNThaschildMAIN($cta->id) == 0){?>
                  <a class="btn btn-danger btn-sm" onClick="confirma(<?=$cta->id?>)">
					  <em class="fa fa-trash"></em>
				  </a>
                 <? }?>
			  </td>
			</tr>
			<? $n++;}?>
          </tbody>
        </table>
      </div>
       <div class="modal fade borracuentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">¿Eliminar Éstas Cuentas?</h4>
              </div>
              <div class="modal-body">
                <p class="text-center">La operación no podrá revertirse</p>
                <button type="button" class="btn pull-left btn-info" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>                        
                <button type="submit" class="btn pull-right btn-danger"><i class="fa fa-trash"></i> Eliminar cuentas</button>               
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
    </form>
    </div>
    <? }else{
        deleteCNTcuentagrupoMAIN();
        ?>
        <div class="box-body">
            <h3 class="alert alert-warning">Se han eliminado las cuentas seleccionadas</h3>
            <a href="index.php?option=com_erp&view=multicuentas" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar al plan de cuentas</a>
        </div>         
    <? }?>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>