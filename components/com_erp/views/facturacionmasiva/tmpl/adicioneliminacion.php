<?php defined('_JEXEC') or die;
$pag = JRequest::getVar('p', 1, 'get');
?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
    if(JRequest::getVar('view')!='clientes'){
        //Clientes Aportes
        $session->clear('asociado');
        $session->clear('registro');
        $session->clear('id_categoria');        
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
		  $session->set('id_categoriam', JRequest::getVar('id_categoria', '', 'post'));
		  $session->set('id_cobrador', JRequest::getVar('id_cobrador', '', 'post'));
		  $session->set('marcados', JRequest::getVar('marcados', '-1', 'post'));
		  $session->set('razon_ae', JRequest::getVar('razon', '', 'post'));
		  }else{
		  $session->clear('id_categoriam');
		  $session->clear('id_cobrador');
		  $session->clear('marcados');
		  $session->clear('razon_ae');
		  }
	}
	$id_categoria = $session->get('id_categoriam');
	$id_cobrador = $session->get('id_cobrador');
	$marcados = $session->get('marcados');
	$razon = $session->get('razon_ae');
	?>
<script>
function limpiaForm(){
	jQuery('#limpia').val(1);
	jQuery('#form').submit();
	}
jQuery(document).on('ready',function(){        
    jQuery('.actualiza').on('click',function(){
        jQuery('#tabla-form').submit();        
    })
})
jQuery(document).on('ready', function(){
    jQuery('.toggle-on').on('click',function(){
        jQuery(this).parent().prev().prop('checked',true);
        var id = jQuery(this).parent().prev().val();
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=facturacionmasiva&layout=adddel&tmpl=blank',
            type: 'POST',
            data: {id:id,marca:0},
        })
    })
    jQuery('.toggle-off').on('click',function(){
        jQuery(this).parent().prev().prop('checked',false);
        var id = jQuery(this).parent().prev().val();
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=facturacionmasiva&layout=adddel&tmpl=blank',
            type: 'POST',
            data: {id:id,marca:1},
        })
    })
})
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
        <h3 class="box-title">Adición/Eliminación de Asociado para Facturación Masiva</h3>
		
      </div>
      <div class="alert alert-dismissible" style="border:1px solid #00c0ef; color:#00c0ef">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        	<em class="fa fa-close"></em>
        </button>
        Debe aplicar un filtro para visualizar una lista de asociados
      </div>
      <div class="box-body">
        <!--<div class="text-right container-fluid">
            <button type="button" class="btn bg-purple actualiza"><i class="fa fa-save"></i> Guardar</button>
        </div>-->
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-1">
                    	Filtro: 
                	</label>
                    <div class="col-xs-12 col-sm-11">
                        <select name="id_categoria" id="id_categoria" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Elija una categoría</option>
                            <? foreach(getClientesCats() as $cat){?>
                            <option value="<?=$cat->id?>" <?=$cat->id==$id_categoria?'selected':''?>><?=$cat->categoria?></option>
                            <? }?>
                    	</select>
                        <select name="id_cobrador" id="id_cobrador" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Seleccione el cobrador</option>
                            <? foreach(getUsuariosext('c',1) as $usuario){?>
                            <option value="<?=$usuario->id?>" <?=$usuario->id==$id_cobrador?'selected':''?>><?=$usuario->nombre?></option>
                            <? }?>
                        </select>
                        <select name="marcados" id="marcados" class="form-control" style="width:auto; display:inline-block">
                            <option value="" <?=$marcados==''?'selected':'';?>>Seleccionar</option>
                            <option value="1" <?=$marcados=='1'?'selected':'';?>>Marcados</option>
                            <option value="0" <?=$marcados=='0'?'selected':'';?>>Desmarcados</option>
                        </select>
                        <input type="text" name="razon" id="razon" class="form-control" style="width:auto; display:inline-block" value="<?=$razon?>" placeholder="Empresa o Razon Social">
                        <input type="hidden" name="limpia" id="limpia" value="0">
                        <button type="submit" class="btn btn-success"><em class="fa fa-filter"></em> Filtrar</button>
                        <button type="button" onClick="limpiaForm()" class="btn btn-info"><em class="fa fa-eraser"></em> Limpiar</button>
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="box-body">
       <form id="tabla-form" enctype="multipart/form-data" action="" name="form-tabla" method="post">
       	   <input type="hidden" name="id_categoria_filtro" id="id_categoria_filtro" value="<?=JRequest::getVar('id_categoria', '0', 'post')?>">
           <input type="hidden" name="id_cobrador_filtro" id="id_cobrador_filtro" value="<?=JRequest::getVar('id_cobrador', '0', 'post')?>">
           <table class="table table-bordered table-striped table_vam"><!--id="datatable_sp"-->
                <thead>                    
                    <th width="80"></th>
                    <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                </thead>
                <tbody>
                    <? 
                    if(!empty($id_categoria) || !empty($id_cobrador)|| !empty($marcados)){
                        $i=0;
                        foreach(getClientes(1) as $cliente){
                            ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="seleccion[<?=$i?>]" data-toggle="toggle" <?=$cliente->masiva==1?'checked':'';?> class="checks" value="<?=$cliente->id?>">
                        </td>
                        <td>
                            <?=$cliente->registro?>
                        </td>
                        <td>
                            <? echo '<em class="fa fa-briefcase"></em> <strong>'.trim($cliente->empresa).'</strong><br />';
                            echo '<span style="font-size:10px"><em class="fa fa-user"></em> Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';?>
                        </td>
                    </tr>
                    <? $i++;
                        }
                    }?>
                    <? $c=0;
                    if(!empty($id_categoria) || !empty($id_cobrador)|| !empty($marcados)){
                        
                        foreach(getClientesPag(1) as $cliente){
                            $c++;
                        }
                    }?>
                </tbody>
                
                <tfoot>
                    <tr>
                        <td colspan="2"><b>Total:</b></td>
                        <td><?=$c;?> Registro(s) Obtenido(s) del Filtrado</td>
                    </tr>
                </tfoot>
            </table> 
            <!--Pag-->
             <?
        $url = 'index.php?option=com_erp&view=facturacionmasiva&layout=adicioneliminacion';
        ?>
        <? /*
                $prev = JRequest::getVar('p')-1;
                $next = JRequest::getVar('p','1','get')+1;
                $pag = JRequest::getVar('p');
                if($prev <= 1){
                    $prev = 1;                    
                }*/
            ?>
           <!-- <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=1" aria-label="Inicio">
                    <span aria-hidden="true">Inicio</span>
                    <span class="sr-only">Inicio</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$prev?>" aria-label="Previous">
                    <span aria-hidden="true"><i class="la la-angle-left"></i></span>
                    <span class="sr-only">Previo</span>
                  </a>
                </li>-->
                <!--<? 
                   /* $cuenta_reg = getClientesPag(1);
    echo $cuenta_reg;
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
                           */ ?>
                        <li class="page-item <?=$i==$pag?'active':''?>"><a class="page-link" href="<?=$url?>&p=<?=$i?>"><?=$i?></a></li>
                    <? /*}
                    }*/?>
                <li class="page-item">
                  <a class="page-link" href="<?=$url?>&p=<?=$next?>" aria-label="Next">
                    <span aria-hidden="true"><i class="la la-angle-right"></i></span>
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
            </nav>-->
            
            
             <!--pag-->
        </form> 
        
        <? $cant= 20;
               $paginas = $c / $cant;
	           if(($c % $cant) != 0){
		          $paginas = ceil($paginas);}
                        
               $cantPages = $paginas;
              /*$cantPages = getClientesPag(1);*/
    
              $url = 'index.php?option=com_erp&view=facturacionmasiva&layout=adicioneliminacion';
              ?>
              <div class="row-fluid">
                <div class="col-xs-12">
                  <div  class="btn-group clearfix sepH_a">
                      <a href="<?=$url?>" class="btn ttip_t" title="Ir a la primera página">&lArr;</a>
                      <a href="<?=$url?>&p=<?=($pag-1)?>" class="btn ttip_t" title="Ir a la página anterior">&larr;</a>
                      <? 
                      for($i=1; $i<=$cantPages; $i++){
                        if($pag == $i){?>
                        <a class="btn btn-info"><?=$i?></a>
                        <? }elseif($i < ($pag + 5) && $i > ($pag - 5)){?>
                        <a href="<?=$url?>&p=<?=$i?>" class="btn ttip_t" title="Ir a la página <?=$i?>"><?=$i?></a>
                      <? }
                      }?>
                      <a href="<?=$url?>&p=<?=($pag+1)?>" class="btn ttip_t" title="Ir a la página siguiente">&rarr;</a>
                      <a href="<?=$url?>&p=<?=$cantPages?>" class="btn ttip_t" title="Ir a la última página">&rArr;</a>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>