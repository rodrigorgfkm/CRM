<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	$session->clear('antiguedad');
	$session->clear('id_cobrador');
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
	if(JRequest::getVar('view')!='clientesaportes'){
        //Clientes Aportes
        $session->clear('razon');
        $session->clear('registro_ca');
        $session->clear('id_categoria_ca');        
    }
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
		width: 30%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	td:nth-of-type(1) { display: none}
	td:nth-of-type(2):before { content: "Registro:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Asociado:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Categoría:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Correo-e:"; font-weight: bold}
	td:nth-of-type(6):before { content: "Teléfonos:"; font-weight: bold}
	td:nth-of-type(7){ padding: 5px !important; height:auto}
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
        <table class="table table-bordered table-striped table_vam">
            <thead>
                <tr>
                    <th width="40">Estado</th>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>
                    <th width="180"><span  data-toggle="tooltip" title="Haga clic para ordenar por Correo-e">Correo-e</span></th>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Teléfono">Teléfono</span></th>
                    <th width="270">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){                    
					foreach(getClientes(1) as $cliente){
                        //print_r($cliente);
                      $com = getClientesCom($cliente->id);
                ?>
                <tr>
                    <td>                        
                        <button class="btn bg-<?=$cliente->color;?>"><i class="fa fa-bullseye"></i></button>
                    </td>
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
                    <? foreach(getClienteContacto($cliente->id_info, 't', 'e') as $telefono){
                        $dato2 = explode('|',$telefono->valor);
                        if(empty($dato2)){
                            $telfc = $telefono->valor;
                            $extc = '';
                        }else{
                            $telfc = $dato2[0];
                            $extc =  $dato2[1];
                            if($dato2[1]!=''){
                                $extc = ' ('.$dato2[1].')';                                
                            }
                        }?>
                            <span><?=$telfc.$extc?></span><br>
                    <? }?>
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=ver&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver detalle completo del registro" class="btn btn-info" ><i class="fa fa-eye"></i></a>
                        <a href="index.php?option=com_erp&view=clientespersonal&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver personal del Asociado" class="btn bg-purple" ><i class="fa fa-users"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=historico&id=<?=$cliente->id?>" data-toggle="tooltip" title="Seguimiento de información" class="btn btn-warning" ><i class="fa fa-clock-o"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=nit&id=<?=$cliente->id?>" data-toggle="tooltip" title="Ver NIT's relacionados" class="btn btn-primary" ><i class="fa fa-list-alt"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=listarchivos&id=<?=$cliente->id?>" data-toggle="tooltip" title="Listado de Archivos" class="btn bg-maroon" ><i class="fa fa-file-text-o"></i></a>
                        <a href="index.php?option=com_erp&view=clientes&layout=editaempresa&id=<?=$cliente->id?>" data-toggle="tooltip" title="Editar cliente" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
                <? }
				}?>
            </tbody>
        </table>        
        <?  if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){
            $url = 'index.php?option=com_erp&view=clientes';
            ?>
            <? 
                $prev = JRequest::getVar('p')-1;
                $next = JRequest::getVar('p','1','get')+1;
                $pag = JRequest::getVar('p','1','get');
                if($prev <= 1){
                    $prev = 1;                    
                }
            ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=1" aria-label="Inicio">
                    <span aria-hidden="true">Inicio</span>
                    <span class="sr-only">Inicio</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$prev?>" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                    <span class="sr-only">Previo</span>
                  </a>
                </li>
                <? 
                    $cuenta_reg = listClientes(1);
                    $mod_pag = ($cuenta_reg % 20);
                    if($mod_pag == 0){
                       $cuenta_pag = $cuenta_reg/20;
                    }else{
                       $cuenta_pag = intval($cuenta_reg / 20);
                       $cuenta_pag = $cuenta_pag + 1;
                    }                    
                    //echo "total Registros: ".$cuenta_reg;
                    $limite = $pag + 10;
                    for($i=$pag;$i<=$limite;$i++){
                        if($i<=$cuenta_pag){
                            ?>
                        <li class="page-item <?=$i==$pag?'active':''?>"><a class="page-link" href="<?=$url?>&p=<?=$i?>"><?=$i?></a></li>
                    <? }
                    }?>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$next?>" aria-label="Next">
                    <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                    <span class="sr-only">Siguiente</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$cuenta_pag?>" aria-label="Fin">
                    <span aria-hidden="true">Fin</span>
                    <span class="sr-only">Fin</span>
                  </a>
                </li>
              </ul>
            </nav>
            <? }?>
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