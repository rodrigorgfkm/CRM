<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('CRM Registro')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
	$session->clear('antiguedad');
	
	if($_POST){
	  if(JRequest::getVar('limpia', 0, 'post') == 0){
	    $session->set('asociado', JRequest::getVar('asociado', '', 'post'));
	    $session->set('registro', JRequest::getVar('registro', '', 'post'));
	    $session->set('id_categoria', JRequest::getVar('id_categoria', '', 'post'));
	  }else{
	    $session->clear('asociado');
	    $session->clear('registro');
	    $session->clear('id_categoria');
	  }
	}
	
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
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
        <h3 class="box-title">Lista de Asociados</h3>		
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
                    <th width="60">Estado</th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>                    
                    <th width="190">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){
					foreach(getCRMAsociados() as $cliente){
                      $com = getClientesCom($cliente->id);
                ?>
                <tr>
                    <td>                        
                        <button class="btn bg-<?=$cliente->color;?>"><i class="fa fa-bullseye"></i></button>
                    </td>
                    <td>
                        <?=$cliente->empresa?>
                    </td>
                    <td>
                        <?=$cliente->categoria?>
                    </td>
                    <td>
                        <button onclick="parent.carga_asoc('<?=$cliente->id?>', '<?=filtroCadena2($cliente->empresa);?>')" class="btn btn-info boton-carga" ><i class="fa fa-plus"></i> Cargar</a>
                    </td>
                </tr>
                <? }
				}?>
            </tbody>
        </table>
        <div class="col-xs-12">
            <p><b>Estados:</b><br><br>
                <? foreach (getClienteEstados() as $estado){?>                    
                    <button type="button" class="btn bg-<?=$estado->color?> btn-xs"><i class="fa fa-bullseye"></i></button> 
                    <?=$estado->estado?>
                <? }?>
            </p>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>