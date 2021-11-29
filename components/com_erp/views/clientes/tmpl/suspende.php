<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Suspende asociado')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
	$filtro = JRequest::getVar('filtro', '', 'post');
	$id_categoria = JRequest::getVar('id_categoria', '', 'post');
	?>
    <script>
    function enviarFiltro(){
		document.filtro.submit();
		}
	function confirma(id, b){
		var url = 'index.php?option=com_erp&view=clientes&layout=suspende_a&id='+id+'&b='+b;
		jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Suspender Asociado');
		jQuery('.modal-body').html('<p>&iquest;Esta seguro de suspender el registro del asociado seleccionado?</p>');
		if(b == 1)
			jQuery('.modal-footer').html('<a class="btn btn-danger" href="'+url+'"><em class="fa fa-ban"></em> Confirmar Suspensión</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
			else
			jQuery('.modal-footer').html('<a class="btn btn-success" href="'+url+'"><em class="fa fa-check"></em> Retirar Suspensión</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
		jQuery('#ventanaModal').trigger('click');
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
        <h3 class="box-title">Suspensión temporal</h3>
		
      </div>
      <? if($session->get('msg') != ''){?>
        <div class="alert alert-dismissable <?=$session->get('msg_tipo')?> fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
            <h4 class="title"><i class="<?=$session->get('msg_icono')?>"></i> <?=$session->get('msg_titulo')?></h4>
            <?=$session->get('msg')?>
        </div>
        <? 
		$session->clear('msg_tipo');
		$session->clear('msg_titulo');
		$session->clear('msg_icono');
		$session->clear('msg');
		}?>
      <div class="box-body">
      	<form action="" method="post" name="form" id="form">
        	<div class="form-group">
                <div class="col-xs-12 col-sm-3">
                	<input type="text" name="asociado" class="form-control" value="<?=$filtro?>" placeholder="Nombre del Asociado">
                </div>
                <div class="col-xs-12 col-sm-3">
                	<select name="id_categoria" id="id_categoria" class="form-control">
                    	<option value="">Todas las categorías</option>
                        <? foreach(getClientesCats() as $cat){?>
						<option value="<?=$cat->id?>" <?=$id_categoria==$cat->id?'selected':''?>><?=$cat->categoria?></option>
						<? }?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-6">
                	<button type="submit" class="btn btn-default">
                        <em class="fa fa-filter"></em>
                        Filtrar
                    </button>
                </div>
                
            </div>
        </form>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>
                    <th width="130"><span  data-toggle="tooltip" title="Haga clic para ordenar por Estado">Estado</span></th>
                    <th width="145">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if($_POST){
					foreach(getClientes(1) as $cliente){
					  
					  if($cliente->bloqueado == 1){
						  $boton = 'btn-danger';
						  $estado = 'Asociado suspendido';
						  $icon = 'fa-check';
						  $label = 'Retirar suspensión';
						  $tooltip = 'Retirar suspensión';
						  $b = 0;
						  }else{
						  $boton = 'btn-success';
						  $estado = 'Asociado vigente';
						  $icon = 'fa-ban';
						  $label = 'Suspender asociado';
						  $tooltip = 'Suspender cuenta';
						  $b = 1;
						  }
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
                        <?=$cliente->categoria?>
                    </td>
                    <td>
                        <a class="btn <?=$boton?> col-md-12"><?=$estado?></a>
                    </td>
                    <td>
                        <a onClick="confirma(<?=$cliente->id?>, <?=$b?>)" data-toggle="tooltip" title="<?=$tooltip?> del asociado <?=$cliente->empresa?>" class="btn btn-info col-md-12" ><i class="fa <?=$icon?>"></i> <?=$label?></a>
                    </td>
                </tr>
                <? }
				}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>