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
        <h3 class="box-title">Validación de registro de asociados</h3>
		
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por cliente">Cliente</span></th>
                    <th width="200"><span  data-toggle="tooltip" title="Haga clic para ordenar por correo-e">Correo-e</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por teléfono">Teléfono</span></th>
                    <th width="10">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClientes() as $cliente){
                      $com = getClientesCom($cliente->id);
                        ?>
                <tr>
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
                        <a href="index.php?option=com_erp&view=clientes&layout=ver&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver detalle completo del registro" class="btn btn-info" ><i class="fa fa-eye"></i> Ver registro</a>
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