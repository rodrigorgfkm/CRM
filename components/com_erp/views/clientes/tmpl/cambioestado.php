<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Suspende asociado')){
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
    function enviarFiltro(){
		document.filtro.submit();
		}
	function confirma(id, id_estado, ic){		
		jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Cambiar Estado de Asociado');
		jQuery('.modal-body').html('<form class="form-horizontal" name="form" method="POST" action="index.php?option=com_erp&view=clientes&layout=changeestado&tmpl=blank">'+
                                       '<div class="form-group">'+
                                        '<label class="col-xs-12 col-sm-2">¿Cuál es el Motivo?</label>'+
                                        '<div class="col-xs-12 col-sm-10"><input type="text" name="motivo" class="form-control validate[required]">'+                                        
                                        '<input type="hidden" name="id_estado" value="'+id_estado+'">'+
                                        '<input type="hidden" name="ic" value="'+ic+'">'+
                                       '</div>'+
                                       '<div class="col-xs-12"><button type="button" id="data" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>'+
                                       '<button type="submit" id="cambiaestado" class="btn btn-success pull-right"><i class="fa fa-check"></i> Confirmar</button></div>'+
                                   '</form>'
                                   );
		jQuery('.modal-footer').html('');
		/*jQuery('.modal-footer').html('<a class="btn btn-success" href="'+url+'"><em class="fa fa-check"></em> Retirar Suspensión</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');*/
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
		/*padding-left: 25% !important; */
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
	td:nth-of-type(1):before { content: ""; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: ""; font-weight: bold}
	td:nth-of-type(3):before { content: ""; font-weight: bold}
	td:nth-of-type(4):before { content: ""; font-weight: bold}	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<script>
function limpiaForm(){
    jQuery('#asociado').val('');
	jQuery('#registro').val('');
	jQuery('#id_categoria').val('');
	jQuery('#limpia').val(1);
	jQuery('#form').submit();
}
jQuery(document).on('ready',function(){
    jQuery('.id_estado').on('change', function(){
        /**/
        //alert(jQuery(this).siblings().attr('id')+'   '+jQuery(this).val());        
        confirma(jQuery(this).siblings('.idf').attr('id'),jQuery(this).val(), jQuery(this).siblings('.icl').val());
        /*jQuery.ajax({
            url:'index.php?option=com_erp&view=clientes&layout=changeestado&tmpl=blank',
            type:'POST',
            data:{id_info: jQuery(this).siblings('input').attr('id'),id_estado:jQuery(this).val()}
        })
        jQuery(this).siblings('span').show(500);*/
        /*
        .done(function(data){
            alert(data)
        })*/
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cambio de Estatus</h3>
		
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
                    <th width="80"><span data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
                    <th width="100"><span data-toggle="tooltip" title="Haga clic para ordenar por Categoría">Categoría</span></th>
                    <th width="130"><span data-toggle="tooltip" title="Haga clic para ordenar por Estado">Estado</span></th>
                    <th width="130"><span>Historial</span></th>
                </tr>
            </thead>
            <tbody>
                <? 
				if(!empty($asociado) || !empty($registro) || !empty($id_categoria)){                    
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
                       <select name="" id="" class="form-control id_estado" style="width:100%">
                           <option value="">Sin Asignar</option>
                           <? foreach (getClienteEstados() as $estado){
                               if($estado->id==$cliente->id_estado){?>
                                  <option value="<?=$estado->id?>" selected><?=$estado->estado?></option>
                            <? }else{?>
                                  <option value="<?=$estado->id?>"><?=$estado->estado?></option>
                            <? }
                           }?>                           
                       </select>
                       <span class="text-success" style="display:none">Se ha cambiado de Estado</span>
                       <input type="hidden" class="idf" id="<?=$cliente->id_info?>">
                       <input type="hidden" class="icl" value="<?=$cliente->id?>">
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientes&layout=hcambioestado&id=<?=$cliente->id?>" class="btn bg-purple"><i class="fa fa-archive"></i> Historial de Cambios</a>
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