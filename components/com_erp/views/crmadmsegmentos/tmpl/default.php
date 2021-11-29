<?php defined('_JEXEC') or die;
if(validaAcceso('CRM ')){
?>
<script>
function confirma(id){		
		jQuery('.modal-title').html('<i class="icon-ban-circle"></i> ¿Eliminar Éste Segmento?');
		jQuery('.modal-body').html('<form class="form-horizontal" name="form" method="POST" action="index.php?option=com_erp&view=crmadmsegmentos&layout=eliminar&tmpl=blank">'+
                                       '<div class="form-group">'+
                                        '<input type="hidden" name="id" value="'+id+'">'+                                        
                                       '</div>'+
                                       '<div class="col-xs-12"><button type="button" id="data" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>'+
                                       '<button type="submit" id="cambiaestado" class="btn btn-success pull-right"><i class="fa fa-check"></i> Confirmar</button></div>'+
                                   '</form>'
                                   );
		jQuery('.modal-footer').html('');
		/*jQuery('.modal-footer').html('<a class="btn btn-success" href="'+url+'"><em class="fa fa-check"></em> Retirar Suspensión</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');*/
		jQuery('#ventanaModal').trigger('click');
		}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de Segmentos</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable" id="tabladinamica">
            <thead>
                <tr>                    
                    <th>Nombre del segmento</th>
                    <th width="70">acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getCRMsegmentos() as $segmento){?>
                <tr>                    
                    <td><?=$segmento->segmento?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=crmadmsegmentos&layout=editar&id=<?=$segmento->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-danger" onclick="confirma(<?=$segmento->id?>)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>