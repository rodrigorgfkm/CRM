<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$id = JRequest::getVar('id', '', 'get');
	?>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {
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
	td:nth-of-type(1):before { content: "Cliente:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Correo-e:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Teléfono:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Celular:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Vigente:"; font-weight: bold}
	td:nth-of-type(6):before { content: "Acciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Historial de modificaciones</h3>
		
      </div>
      <div class="box-body">
        <a href="index.php?option=com_erp&view=clientes" class="btn btn-info pull-right"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
      </div> 
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="150"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Modificado el</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Modificado por</span></th>
                    <th width="100">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClienteHistorial() as $hist){
                      $com = getClientesCom($cliente->id);
                        ?>
                <tr>
                    <td>
                        <?=fecha($hist->fecha)?>
                    </td>
                    <td>
                        <?=$hist->name?>
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=ver&id=<?=$id?>&id_info=<?=$hist->id?>" data-toggle="tooltip" title="Ver detalle completo del registro" class="btn btn-info" ><i class="fa fa-eye"></i> Ver registro</a>
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