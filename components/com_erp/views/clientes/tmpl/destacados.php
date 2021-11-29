<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	?>
<style>
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
	td:nth-of-type(5):before { content: "Acciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-secret"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Clientes Preferenciales</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <ul>
                  <a href="index.php?option=com_erp&view=clientes" class="btn btn-warning"><em class="fa fa-user"></em> Clientes</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=nuevo" class="btn btn-success"><em class="fa fa-plus"></em> Crear Particular</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=nuevoempresa" class="btn btn-info"><em class="fa fa-plus"></em> Crear Empresa</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=reporte" class="btn btn-default"><em class="fa fa-list"></em> Reportes</a>
            </ul>
          </div>
        </div>
      </div>
      <div class="box-body">
            <table class="table table-bordered table-striped table_vam" id="tabladinamicaordenada">
                <thead>
                    <tr>
                        <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                        <th><span data-toggle="tooltip" title="Haga clic para ordenar por cliente">Cliente</sapn></th>
                        <th width="160"><span data-toggle="tooltip" title="Haga clic para ordenar por correo-e">Correo-e</sapn></th>
                        <th width="70"><span data-toggle="tooltip" title="Haga clic para ordenar por teléfono">Teléfono</sapn></th>
                        <th width="100"><span data-toggle="tooltip" title="Haga clic para ordenar por celular">Celular</sapn></th>
                        <th width="195">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach(getClientes() as $cliente){
                        if($cliente->destacado == 1){
                            $com = getClientesCom($cliente->id);
                            ?>
                    <tr>
                        <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                        <td>
                            <? if($cliente->empresa != ''){
                                echo '<em class="fa fa-briefcase"></em> <strong>'.trim($cliente->empresa).'</strong><br />';
                                if($cliente->nombre != '' || $cliente->apellido != '')
                                    echo '<span style="font-size:9px">Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';
                                }else
                                echo '<em class="fa fa-user"></em> <strong>'.trim($cliente->apellido.' '.$cliente->nombre).'</strong>';?>
                        </td>
                        <td><?=$com->email?></td>
                        <td><?=$com->fono_domicilio?></td>
                        <td><?=$com->celular?></td>
                        <td>
                            <? if($ext['veh']->habilitado == 1){?>
                            <a href="index.php?option=com_erp&view=clientes&layout=vehiculos&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver listado de vehículos" class="btn btn-default">
                                <img src="templates/erp/img/gCons/van.png" alt="" width="23" height="17" />
                            </a>
                            <? }?>
                            <a href="index.php?option=com_erp&view=clientes&layout=nit&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver NIT's relacionados" class="btn btn-primary btn-xs" ><i class="fa fa-list-alt"></i></a>
                            <? if($cliente->empresa == ''){?>
                              <a href="index.php?option=com_erp&view=clientes&layout=edita&id=<?=$cliente->id?>" data-toggle="tooltip" title="Editar cliente" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>
                              <? }else{?>
                              <a href="index.php?option=com_erp&view=clientes&layout=editaempresa&id=<?=$cliente->id?>" data-toggle="tooltip" title="Editar cliente" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>
                              <? }?>
                            <a href="index.php?option=com_erp&view=clientes&layout=destacado&estado=<?=$cliente->destacado?>&id=<?=$cliente->id?>" data-toggle="tooltip" title="<?=$destacado_tooltip?>" class="btn btn-<?=$destacado_boton?> btn-xs"><i class="fa fa-star<?=$destacado?>"></i></a>
                            <a href="index.php?option=com_erp&view=clientes&layout=elimina&id=<?=$cliente->id?>" data-toggle="tooltip" title="Eliminar cliente" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <? }}?>
                </tbody>
            </table>
            <div class="row-fluid">
                <div class="col-xs-12">
                </div>
                <div class="col-xs-12" style="text-align:right">
                  <a href="index.php?option=com_erp&view=clientes" class="btn btn-warning"><em class="fa fa-user"></em> Clientes</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=nuevo" class="btn btn-success"><em class="fa fa-plus"></em> Crear Particular</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=nuevoempresa" class="btn btn-info"><em class="fa fa-plus"></em> Crear Empresa</a>
                  <a href="index.php?option=com_erp&view=clientes&layout=reporte" class="btn btn-default"><em class="fa fa-list"></em> Reportes</a>
                </div>
            </div>
      </div>      
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>