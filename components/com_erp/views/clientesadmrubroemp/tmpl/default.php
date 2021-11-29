<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<style>
    
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {   
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: "Tipo de sociedad:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Sigla:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Accciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<script>
jQuery(document).on('ready',function(){
    jQuery('.eliminar').on('click',function(){        
        jQuery('#id_rub').val(jQuery(this).attr('id'));
        jQuery('#nombre').html(jQuery(this).attr('data-nombre'));
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Rubros de Empresa</h3>
      </div>
      <div class="col-xs-12">
          <a href="index.php?option=com_erp&view=clientesadmrubroemp&layout=nuevo" class="btn btn-primary pull-right" style="margin-bottom:5px"><i class="fa fa-plus"></i> Crear Rubro</a>
      </div>
      <div class="box-body">
            <table class="table datatable">
                <thead>
                    <th>Rubro</th>
                    <th width="80">Acciones</th>
                </thead>
                <tbody>
                   <? foreach (getRubros()  as $rubro){?>
                    <tr>
                        <td><?=$rubro->rubro?></td>                        
                        <td>
                            <a href="index.php?option=com_erp&view=clientesadmrubroemp&layout=edita&id=<?=$rubro->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger eliminar" data-toggle="modal" data-target=".borratiposoc" id="<?=$rubro->id?>" data-nombre="<?=$rubro->rubro?>"><i class="fa fa-trash"></i></button>
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
                        <h4 class="modal-title" id="exampleModalLabel">¿Eliminar Éste Rubro?</h4>                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <form action="" name="form" id="form" class="form-horizontal col-xs-12" role="form" method="get">
                            <div class="form-group">
                                <div id="nombre" class="col-md-12"></div>
                            </div>
                            <div class="col-xs-12">                                
                                <input type="hidden" name="option" value="com_erp">
                                <input type="hidden" name="view" value="clientesadmrubroemp">
                                <input type="hidden" name="layout" value="elimina">
                                <input type="hidden" name="id" id="id_rub" value="">
                                <button type="button" class="btn pull-left btn-info" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>                        
                                <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash"></i> Eliminar</button>
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