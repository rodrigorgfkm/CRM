<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Contabilidad Comprobantes')){
	$n = 0;
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
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
function envia(nombre, id){
	window.parent.asigna(nombre, id);
	window.parent.Shadowbox.close();
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asociados</h3>
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
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                    <th data-toggle="tooltip" title="Haga clic para ordenar por cliente">Cliente</th>
                    <th width="80">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){
					foreach(getClientes(1) as $cliente){
                      $com = getClientesCom($cliente->id);
                        ?>
                <tr>
                    <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                    <td>
                        <em class="fa fa-briefcase"></em>
						<?=$cliente->empresa?>
                    </td>
                    <td>
                        <a onClick="envia('<?=filtroCadena2($cliente->empresa)?>','<?=$cliente->id?>')" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Cargar</a>
                    </td>
                </tr>
                <? }}?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>	
<? }else{ vistaBloaqueada();}?>