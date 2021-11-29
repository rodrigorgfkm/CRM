<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$id_cliente = JRequest::getVar('id', '', 'get');
	?>
    <script>
    function enviarFiltro(){
		document.filtro.submit();
		}
    </script>
<style>
@media only screen and (max-width: 760px),
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
	td:nth-of-type(1):before { content: "Nombre:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "NIT:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Acciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>  
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-sticky-note-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de NIT's relacionados</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <a href="index.php?option=com_erp&view=clientes&layout=nitnuevo&id=<?=$id_cliente?>" class="btn btn-success">
            	<em class="fa fa-plus"></em> Crear NIT
            </a>
            <a href="index.php?option=com_erp&view=clientes" class="btn btn-success">
            	<em class="fa fa-arrow-left"></em> Volver
            </a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th><span data-toggle="tooltip" title="Haga clic para ordenar por Nombre">Nombre</span></th>
                    <th width="150"><span data-toggle="tooltip" title="Haga clic para ordenar por NIT">NIT</span></th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				foreach(getNitCliente($id_cliente) as $nit){
					if($nit->principal == 1){
						$boton = 'btn-warning';
						$icon = 'fa-star';
						$href = '';
						$tooltip = 'Este es el NIT por defecto del Asociado';
						}else{
						$boton = 'btn-default';
						$icon = 'fa-star-o';
						$href = 'href="index.php?option=com_erp&view=clientes&layout=nitprincipal&id='.$nit->id.'"';
						$tooltip = 'Haga clic para marcar el NIT como predeterminado';
						}
						
                ?>
                <tr>
                    <td><?=$nit->nombre?></td>
                    <td><?=$nit->nit?></td>
                    <td>
                        <a <?=$href?> data-toggle="tooltip" title="<?=$tooltip?>" class="btn <?=$boton?>"><i class="fa <?=$icon?>"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=nitedita&id=<?=$id_cliente?>&id_nit=<?=$nit->id?>" data-toggle="tooltip" title="Editar NIT" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=nitelimina&id=<?=$id_cliente?>&id_nit=<?=$nit->id?>" data-toggle="tooltip" title="Eliminar NIT" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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