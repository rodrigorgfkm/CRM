<?php defined('_JEXEC') or die;
if(validaAcceso('Ve Cargo Clientes')){?>
<style>
@media
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 25% !important; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	tbody td{ min-height: 20px}
	td:nth-of-type(1):before { content: "Cargo: "; font-weight: bold}
	td:nth-of-type(2):before { content: ""; }
	td:nth-of-type(2){ padding: 5px !important; height:35px}
}
</style>
<script>
function confirma(id){
		var url = 'index.php?option=com_erp&view=clientesadmcargo&layout=elimina&id=' + id;
		jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Eliminar Cargo');
		jQuery('.modal-body').html('<p>&iquest;Está seguro de eliminar el cargo seleccionado?</p>');
		jQuery('.modal-footer').html('<a class="btn btn-warning" href="'+url+'"><em class="icon-ban-circle"></em> Confirmar</a> <button type="button" class="btn btn-info" data-dismiss="modal"><em class="icon-signout"></em> Cerrar</button>');
		jQuery('#ventanaModal').trigger('click');;
		}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Cargos</h3>
		
        <!-- Algunos botones si son necesarios -->        
      </div>
      <div class="box-body">
      <table class="table table-bordered table-striped table_vam datatable">
        <thead>
          <tr>
            <th>Cargo</th>
            <th width="75">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getCargos() as $cargo){?>
          <tr>
            <td><?=$cargo->cargo?></td>
            <td>
                <a href="index.php?option=com_erp&view=clientesadmcargo&layout=edita&id=<?=$cargo->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                <a onClick="confirma(<?=$cargo->id?>)" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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