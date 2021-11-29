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
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Sociedades</h3>
      </div>
      <div class="col-xs-12">
          <a href="index.php?option=com_erp&view=tiposdesociedad&layout=nuevo" class="btn btn-primary pull-right" style="margin-bottom:5px"><i class="fa fa-plus"></i> Crear Tipo de Sociedad</a>
      </div>
      <div class="box-body">
            <table class="table datatable">
                <thead>
                    <th>Tipo de sociedad</th>
                    <th>Sigla</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                   <? foreach (getTiposSociedad()  as $tipo){?>
                    <tr>
                        <td><?=$tipo->tipo?></td>
                        <td><?=$tipo->sigla?></td>
                        <td>
                            <a href="index.php?option=com_erp&view=tiposdesociedad&layout=edita&id=<?=$tipo->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".borratiposoc"><i class="fa fa-trash"></i></button>
                            
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
                        <h4 class="modal-title" id="exampleModalLabel">¿Eliminar Éste Tipo de Sociedad?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <form action="" name="form" id="form" class="form-horizontal col-xs-12" role="form" method="get">
                            <div class="col-xs-12 text-right">
                                <input type="hidden" name="option" value="com_erp">
                                <input type="hidden" name="view" value="tiposdesociedad">
                                <input type="hidden" name="layout" value="elimina">
                                <input type="hidden" name="id" value="<?=$tipo->id?>">
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