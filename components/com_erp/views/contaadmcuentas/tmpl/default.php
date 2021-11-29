<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables')){
	
$id = JRequest::getVar('id', getGestionAc(), 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	location.href = 'index.php?option=com_erp&view=contaadmcuentas&id='+id;
	}
function confirma(id){
	var href = 'index.php?option=com_erp&view=contaadmcuentas&layout=elimina&id='+id;
	jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Eliminar cuenta');
	jQuery('.modal-body').html('<p>&iquest;Esta seguro de eliminar la cuenta seleccionada?</p><p>No hay reversion de esta operación</p>');
	jQuery('.modal-footer').html('<a class="btn btn-danger" href="'+href+'"><em class="fa fa-trash"></em> Eliminar Cuenta</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
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
    });
	jQuery("#checkTodos").change(function () {
    	jQuery("input:checkbox").prop('checked', jQuery(this).prop("checked"));
    });
    
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Auxiliares a Cuentas Contables</h3>
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-2">
                    	Seleccionar Gestión: 
                	</label>
                    <div class="col-xs-12 col-sm-8">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){?>
                            <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                            <? }?>
                    	</select>
                	</div>
                </form>
            </div>
        </div>		
     <? if(!$_POST){?>
       <form action="" name="form" method="POST">
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-danger eliminacta" data-toggle="modal" data-target=".borracuentas" style="display:none">
            	<em class="fa fa-trash"></em>
            	Eliminar selección
            </button >
            <a href="index.php?option=com_erp&view=contaadmcuentas&layout=nuevo&id=<?=$id?>" class="btn btn-success">
            	<em class="fa fa-plus"></em>
            	Nueva cuenta contable
            </a>
            <!--<a href="index.php?option=com_erp&view=contaadmcuentas&layout=nuevoaux&id=<?=$id?>" class="btn btn-success">
            	<em class="fa fa-plus"></em>
            	Nuevo auxiliar
            </a>-->
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered" id="tabladinamicanp">
          <thead>
            <tr>
              <th width="10"><input type="checkbox" id="checkTodos" name="todos" class="seleccion_cta"></th>
              <th width="20">#</th>
              <th width="80">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="100">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
			foreach(getCNTcuentas($id, 0, 1) as $cta){?>
			<tr>
			  <td>
                  <? if($cta->id_origen == 0){?>
			      <input type="checkbox" name="seleccion_cta[]" id="" class="seleccion_cta" value="<?=$cta->id?>">
                  <? }?>
			  </td>
			  <td><?=$n?></td>
			  <td>
              	<?
                if($cta->codigo != 0)
					echo codigoRename($cta->codigo)
				?>
              </td>
			  <td><?=$cta->nombre_completo?></td>
			  <td>
				  <? if($cta->id_origen == 0){?>
                  <a class="btn btn-success btn-sm" href="index.php?option=com_erp&view=contaadmcuentas&layout=edita&id=<?=$cta->id?>">
					  <em class="fa fa-pencil"></em>
				  </a>
                  &nbsp;
                  <a class="btn btn-danger btn-sm" href="#" onClick="confirma(<?=$cta->id?>)">
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
      <? }else{
        deleteCNTcuentagrupo();
        ?>
        <div class="box-body">
            <h3 class="alert alert-warning">Se han Eliminado las Cuentas Seleccionadas</h3>
            <a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar al plan de cuentas</a>
        </div>
     <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>