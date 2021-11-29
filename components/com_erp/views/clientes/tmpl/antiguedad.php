<?php defined('_JEXEC') or die;
?>
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
	if(JRequest::getVar('view')!='clientesaportes'){
        //Clientes Aportes
        $session->clear('razon');
        $session->clear('registro_ca');
        $session->clear('id_categoria_ca');        
    }
    if(JRequest::getVar('layout')=='antiguedad'){
        //Clientes Aportes
        $session->clear('asociado');
        $session->clear('registro');
        $session->clear('id_categoria');        
    }
	if($_POST){
	  if(JRequest::getVar('limpia', 0, 'post') == 0){
	    $session->set('mes', JRequest::getVar('mes', '', 'post'));
	    $session->set('anio', JRequest::getVar('anio', '', 'post'));
      }else{
        $session->clear('mes', JRequest::getVar('mes', '', 'post'));
	    $session->clear('anio', JRequest::getVar('anio', '', 'post'));
      }
	}
    $mes = JRequest::getVar('mes','','post');
    $anio = JRequest::getVar('anio','','post');
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
        <h3 class="box-title">Revisión y Edición de Registro</h3>
		
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
                    	<!--<input type="text" name="antiguedad" id="antiguedad"  class="form-control datepicker" placeholder="Antigüedad" value="<?=$antiguedad?>" style="width:auto; display:inline-block" readonly>-->
                    	<select name="mes" id="mes" class="form-control" style="width:auto;display:inline">
                            <option value="">Mes</option>
                            <option value='1' <?=$mes=='1'?'selected':'';?>>Enero</option>
                            <option value='2' <?=$mes=='2'?'selected':'';?>>Febrero</option>
                            <option value='3' <?=$mes=='3'?'selected':'';?>>Marzo</option>
                            <option value='4' <?=$mes=='4'?'selected':'';?>>Abril</option>
                            <option value='5' <?=$mes=='5'?'selected':'';?>>Mayo</option>
                            <option value='6' <?=$mes=='6'?'selected':'';?>>Junio</option>
                            <option value='7' <?=$mes=='7'?'selected':'';?>>Julio</option>
                            <option value='8' <?=$mes=='8'?'selected':'';?>>Agosto</option>
                            <option value='9' <?=$mes=='9'?'selected':'';?>>Septiembre</option>
                            <option value='10' <?=$mes=='10'?'selected':'';?>>Octubre</option>
                            <option value='11' <?=$mes=='11'?'selected':'';?>>Noviembre</option>
                            <option value='12' <?=$mes=='12'?'selected':'';?>>Diciembre</option>
                    	</select>
                    	<input type="number" name="anio" id="anio" class="form-control validate[required]" style="width:auto;display:inline" value="<?=$anio?>" placeholder="Año">
                    	<input type="hidden" name="limpia" id="limpia" value="0">
                        <button type="submit" class="btn btn-success"><em class="fa fa-filter"></em> Filtrar</button>
                        <button type="button" onClick="limpiaForm()" class="btn btn-info"><em class="fa fa-eraser"></em> Limpiar</button>
                	</div>
                </form>
            </div>
            <? if($_POST){?>
                <form action="components/com_erp/views/clientes/tmpl/exportarantiguedad.php" method="post" style="margin:0px" class="pull-right">                   
                    <button class="btn btn-success pull-right" type="submit">
                    	<em class="fa fa-file-excel-o"></em> 
                        Exportar a Excel
                    </button>                    
                    <input type="hidden" name="filtro_mes" value="<?=$session->get('mes')?>">
                    <input type="hidden" name="filtro_anio" value="<?=$session->get('anio')?>">
                  </form>
            <? }?>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>
                    <th width="200"><span  data-toggle="tooltip" title="Haga clic para ordenar por Correo-e">Correo-e</span></th>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Teléfono">Teléfono</span></th>
                    <th width="190">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria) || !empty($mes) || !empty($anio)){
					foreach(getClientes(1) as $cliente){
                      $com = getClientesCom($cliente->id);
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
                    <? foreach(getClienteContacto($cliente->id_info, 'e', 'e') as $correoe){?>
                           <span><?=$correoe->valor?></span><br>
                    <? }?>
                    </td>
                    <td>					 
                    <? foreach(getClienteContacto($cliente->id_info, 't', 'e') as $telefono){?>
                            <span><?=$telefono->valor?></span><br>
                    <? }?>
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=ver&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver detalle completo del registro" class="btn btn-info" ><i class="fa fa-eye"></i></a>
                        <a href="index.php?option=com_erp&view=clientespersonal&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver personal del Asociado" class="btn bg-purple" ><i class="fa fa-users"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=nit&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver NIT's relacionados" class="btn btn-primary" ><i class="fa fa-list-alt"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=editaempresa&id=<?=$cliente->id?>" data-toggle="tooltip" title="Editar cliente" class="btn btn-success"><i class="fa fa-pencil"></i></a>
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