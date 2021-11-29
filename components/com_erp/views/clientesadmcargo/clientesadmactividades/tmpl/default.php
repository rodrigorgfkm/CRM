<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Gestion clientes actividades')){?>
<style>
    
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {   
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: "Actividad"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: ""}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<script>
jQuery(document).on('ready',function(){
    jQuery('.btn-delete').on('click', function(){
        jQuery('[name=id]').val(jQuery(this).attr('data-id'));
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Actividades</h3>
      </div>
      <div class="col-xs-12">
          <a href="index.php?option=com_erp&view=clientesadmactividades&layout=nuevo" class="btn btn-primary pull-right" style="margin-bottom:5px"><i class="fa fa-plus"></i> Crear Actividad</a>
      </div>
      <div class="box-body">
            <table class="table datatable">
                <thead>
                    <th>Actividad</th>
                    <th width="120px;">Acciones</th>
                </thead>
                <tbody>
                   <? foreach (getClienteActividades()  as $actividad){?>
                    <tr>
                        <td><?=$actividad->actividad?></td>
                        <td>
                            <a href="index.php?option=com_erp&view=clientesadmactividades&layout=edita&id=<?=$actividad->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target=".borratiposoc" data-id="<?=$actividad->id?>"><i class="fa fa-trash"></i></button>                            
                        </td>
                    </tr>
                    <? }?>
                </tbody>
            </table>
              <!-- Modal -->
                <div class="modal fade borratiposoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">¿Eliminar Ésta Actividad?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <form action="" name="form" id="form" class="form-horizontal col-xs-12" role="form" method="get">
                            <div class="col-xs-12 text-right">
                                <input type="hidden" name="option" value="com_erp">
                                <input type="hidden" name="view" value="clientesadmactividades">
                                <input type="hidden" name="layout" value="elimina">
                                <input type="hidden" name="id" value="">
                                <button type="button" class="btn pull-left btn-info" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>                        
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                            </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>
              
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>