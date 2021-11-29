<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');	
	if(JRequest::getVar('layout') != 'adicioneliminacion'){
        //Adicion Eliminacion
		$session->clear('id_cobrador');
		$session->clear('marcados');
		$session->clear('razon_ae');
	    $session->clear('id_categoriam');
    }
    if(JRequest::getVar('layout') != 'antiguedad'){
        //Antiguedad
        $session->clear('anio');
        $session->clear('mes');
    }
	if(JRequest::getVar('view')!='clientes'){
        //Clientes Aportes
        $session->clear('asociado');
        $session->clear('registro');
        $session->clear('id_categoria');        
    }
    if($_POST){
	  if(JRequest::getVar('limpia', 0, 'post') == 0){
	    $session->set('razon', JRequest::getVar('asociado', '', 'post'));
	    $session->set('registro_ca', JRequest::getVar('registro', '', 'post'));
	    $session->set('id_categoria_ca', JRequest::getVar('id_categoria', '', 'post'));
	  }else{
	    $session->clear('razon');
	    $session->clear('registro_ca');
	    $session->clear('id_categoria_ca');
	  }
	}	
	$asociado = $session->get('razon');
	$registro = $session->get('registro_ca');
	$id_categoria = $session->get('id_categoria_ca');
	?>
<script>
    function limpiaForm(){
        jQuery('#limpia').val(1);
        jQuery('#form').submit();
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
        <h3 class="box-title">Cuotas</h3>
		
      </div>
      <div class="alert alert-dismissible" style="border:1px solid #00c0ef; color:#00c0ef">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        	<em class="fa fa-close"></em>
        </button>
        Debe aplicar un filtro para visualizar una lista de asociados
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-1">
                    	Filtro: 
                	</label>
                    <div class="col-xs-12 col-sm-11">
                    	<input type="text" name="asociado" id="asociado"  class="form-control" placeholder="Asociado" value="<?=$asociado?>" style="width:auto; display:inline-block">
                        <input type="text" name="registro" id="registro"  class="form-control" placeholder="Nro. de Registro" value="<?=$registro?>" style="width:auto; display:inline-block">
                        <select name="id_categoria" id="id_categoria" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Elija una categoría</option>
                            <? foreach(getClientesCats() as $cat){?>
                            <option value="<?=$cat->id?>" <?=$cat->id==$id_categoria?'selected':''?>><?=$cat->categoria?></option>
                            <? }?>
                    	</select>
                        <input type="hidden" name="limpia" id="limpia" value="0">
                        <button type="submit" class="btn btn-success"><em class="fa fa-filter"></em> Filtrar</button>
                        <button type="button" onClick="limpiaForm()" class="btn btn-info"><em class="fa fa-eraser"></em> Limpiar</button>
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>
                    <th width="130">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){
					foreach(getClientes(1) as $cliente){
                        ?>
                <tr>
                    <td>
                        <?=$cliente->registro?>
                    </td>
                    <td>
                        <? echo '<em class="fa fa-briefcase"></em> <strong>'.trim($cliente->empresa).'</strong><br />';
                        echo '<span style="font-size:10px"><em class="fa fa-user"></em> Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';?>
                    </td>
                    <td>
                        <?=$cliente->categoria?>
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientesaportes&layout=cuotas&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver estado de cuenta del asociado" class="btn btn-success" >
                            <i class="fa fa-eye"></i> Ver Cuentas
                        </a>
                        <a href="index.php?option=com_erp&view=clientesaportes&layout=estadodecuenta&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver estado de cuenta del asociado" class="btn btn-info" >
                        	<i class="fa fa-money"></i>
                            Estado de Cuentas
                        </a>
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