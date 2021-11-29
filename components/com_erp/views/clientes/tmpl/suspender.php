<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	?>
    <script>
    function enviarFiltro(){
		document.filtro.submit();
		}
    </script>
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
        <h3 class="box-title">Asociados Registrados</h3>
		
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por cliente">Asociado</span></th>
                    <th width="200"><span  data-toggle="tooltip" title="Haga clic para ordenar por correo-e">Correo-e</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por teléfono">Teléfono</span></th>
                    <th width="195">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClientes(1) as $cliente){
                      $com = getClientesCom($cliente->id);
                        ?>
                <tr>
                    <td>
                        <?=$cliente->registro?>
                    </td>
                    <td>
                        <? echo '<em class="fa fa-briefcase"></em> <strong>'.trim($cliente->empresa).' '.$cliente->sociedad_sigla.'</strong><br />';
                        echo '<span style="font-size:10px"><em class="fa fa-user"></em> Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';?>
                    </td>
                    <td>
					  <?
                      foreach(getClientesC($cliente->id_info, 'e') as $com){
						  echo $com->numero.'<br>';
						  }
					  ?>
                    </td>
                    <td>
					  <?
                      foreach(getClientesC($cliente->id_info, 't') as $com){
						  echo $com->numero.'<br>';
						  }
					  ?>
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=historial&id=<?=$cliente->id?>" data-toggle="tooltip" title="Historial de registros" class="btn btn-info" ><i class="fa fa-history"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=nit&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver NIT's relacionados" class="btn btn-primary" ><i class="fa fa-list-alt"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=editaempresa&id=<?=$cliente->id?>" data-toggle="tooltip" title="Editar cliente" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=elimina&id=<?=$cliente->id?>" data-toggle="tooltip" title="Bloquear cliente" class="btn btn-danger"><i class="fa fa-ban"></i></a>
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