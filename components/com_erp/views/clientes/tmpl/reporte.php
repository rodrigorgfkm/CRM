<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
	$session->clear('antiguedad');
	$session->clear('mes');
	$session->clear('anio');
	
	if($_POST){
	  if(JRequest::getVar('limpia', 0, 'post') == 0){
	    $session->set('r_asociado', JRequest::getVar('asociado', '', 'post'));
	    $session->set('r_registro', JRequest::getVar('registro', '', 'post'));
	    $session->set('r_id_categoria', JRequest::getVar('id_categoria', '', 'post'));
	    $session->set('r_id_cobrador', JRequest::getVar('id_cobrador', '', 'post'));
	    $session->set('r_id_mensajero', JRequest::getVar('id_mensajero', '', 'post'));
	    $session->set('r_id_tipo', JRequest::getVar('id_tipo', '', 'post'));
	    $session->set('r_id_estado', JRequest::getVar('id_estado', '', 'post'));
	    $session->set('r_id_actividad', JRequest::getVar('id_actividad', '', 'post'));
	  }else{
	    $session->clear('r_asociado');
	    $session->clear('r_registro');
	    $session->clear('r_id_categoria');
        $session->clear('r_id_cobrador');
	    $session->clear('r_id_mensajero');
	    $session->clear('r_id_tipo');
	    $session->clear('r_id_estado');
	    $session->clear('r_id_actividad');
	  }
	}	
	$asociado = $session->get('r_asociado');
	$registro = $session->get('r_registro');
	$id_categoria = $session->get('r_id_categoria');
	$id_cobrador = $session->get('r_id_cobrador');
	$id_mesajero = $session->get('r_id_mensajero');
	$id_tipo = $session->get('r_id_tipo');
	$id_estado = $session->get('r_id_estado');
	$id_actividad = $session->get('r_id_actividad');
	?>
<script>
    function limpiaForm(){
        jQuery('#limpia').val(1);
        jQuery('#form').submit();
	}    
    function enviarFiltro(){
		document.filtro.submit();
		}
jQuery(document).on('ready',function(){
    jQuery('#reg').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#uas').removeClass('bg-orange');
            jQuery('#dc').removeClass('bg-orange');
            jQuery('#uas').addClass('bg-blue');
            jQuery('#dc').addClass('bg-blue');
            jQuery('.regisasoc').slideDown(500);
            jQuery('#uas').attr('data-sw',1);
            jQuery('#dc').attr('data-sw',1);
            jQuery('.reguas').slideUp(500);
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regisasoc').slideUp(500);
            jQuery(this).attr('data-sw',0);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#uas').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.reguas').slideDown(500);
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#reg').removeClass('bg-orange');
            jQuery('#dc').removeClass('bg-orange');
            jQuery('#reg').addClass('bg-blue');
            jQuery('#dc').addClass('bg-blue');
            jQuery('#reg').attr('data-sw',1);
            jQuery('#dc').attr('data-sw',1);
            jQuery('.regisasoc').slideUp(500);
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.reguas').slideUp(500);
            jQuery(this).attr('data-sw',1);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#dc').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.regdcon').slideDown(500);
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#reg').removeClass('bg-orange');
            jQuery('#uas').removeClass('bg-orange');
            jQuery('#reg').addClass('bg-blue');
            jQuery('#uas').addClass('bg-blue');
            jQuery('#reg').attr('data-sw',1);
            jQuery('#uas').attr('data-sw',1);
            jQuery('.reguas').slideUp(500);
            jQuery('.regisasoc').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',1);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#eac').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.regacec').show();
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regacec').hide();
            jQuery(this).attr('data-sw',1);
        }
    })
    jQuery('#m_reg').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.regis').trigger('click');
        }else{
            jQuery('.regis').removeAttr('checked');
        }        
    })
    jQuery('.regis').on('click', function(){
        if(jQuery('.regis:checked').length!=13){
            jQuery('#m_reg').removeAttr('checked');
        }else{
            jQuery('#m_reg').prop('checked', true);
        }
    })
    jQuery('#m_uas').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.uas').trigger('click');
        }else{
            jQuery('.uas').removeAttr('checked');            
        }        
    })
    jQuery('.uas').on('click', function(){
        if(jQuery('.uas:checked').length!=7){
            jQuery('#m_uas').removeAttr('checked');
        }else{
            jQuery('#m_uas').prop('checked', true);
        }
    })
    jQuery('#m_dc').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.contacto').trigger('click');
        }else{
            jQuery('.contacto').removeAttr('checked');
        }        
    })
    jQuery('.contacto').on('click', function(){
        if(jQuery('.contacto:checked').length!=3){
            jQuery('#m_dc').removeAttr('checked');
        }else{
            jQuery('#m_dc').prop('checked', true);
        }
    })
    /*jQuery('#m_eac').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.encuesta').trigger('click');
        }else{
            jQuery('.encuesta').removeAttr('checked');
        }        
    })*/    
    jQuery('.labelcheck').on('click',function(){
        jQuery(this).children().trigger('click');
    })
})
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
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa  fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Ejecutivo</h3>
      </div>
      <div class="alert alert-dismissible" style="border:1px solid #00c0ef; color:#00c0ef">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              <em class="fa fa-close"></em>
          </button>
          Debe aplicar un filtro para visualizar una lista de asociados
      </div>
      <div class="box-body">
          <div class="row">
              <div class="col-sm-12 col-md-10">
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
                        <select name="id_cobrador" id="id_cobrador" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Cobrador</option>
                            <? foreach(getUsuariosext('c') as $usuario){?>
                            <option value="<?=$usuario->id?>" <?=$id_cobrador==$usuario->id?'selected':'';?>><?=$usuario->nombre?></option>
                            <? }?>
                        </select>
                        <select name="id_mensajero" id="id_mensajero" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Mensajero</option>
                            <? foreach(getUsuariosext('m') as $usuario){?>
                                <option value="<?=$usuario->id?>" <?=$id_mesajero==$usuario->id?'selected':'';?>><?=$usuario->nombre?></option>
                                    
                            <? }?>
                        </select>
                        <select name="id_tipo" id="id_tipo" class="form-control" style="width:auto; display:inline-block">
                         <option value="">Tipo de Sociedad</option>
                         <? foreach(getTiposSociedad() as $tipo){?>
                                <option value="<?=$tipo->id?>" <?=$id_tipo==$tipo->id?'selected':'';?>><?=$tipo->tipo?></option>                                
                         <? }?>
                        </select>
                        <select name="id_estado" id="id_estado" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Estado</option>
                            <? foreach (getClienteEstados($cliente->id) as $estado){?>
                                <option value="<?=$estado->id?>" <?=$id_estado==$estado->id?'selected':'';?>><?=$estado->estado?></option>
                            <? }?>                        
                        </select>
                        <select name="id_actividad" id="id_actividad" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Actividad</option>
                            <? foreach (getClienteActividades()  as $actividad){?>
                                <option value="<?=$actividad->id?>" <?=$id_actividad==$actividad->id?'selected':'';?>><?=$actividad->actividad?></option>
                            <? }?>
                        </select>
                        <input type="hidden" name="limpia" id="limpia" value="0">
                        <button type="submit" class="btn btn-success"><em class="fa fa-filter"></em> Filtrar</button>
                        <button type="button" onClick="limpiaForm()" class="btn btn-info"><em class="fa fa-eraser"></em> Limpiar</button>
                	</div>
                  </form>
              </div>
              <? if($_POST){?>
              <div class="col-sm-12 col-md-12">
                  <!--<form action="index.php?option=com_erp&view=clientes&layout=exportar&tmpl=blank" method="post" style="margin:0px">-->
                   <form action="components/com_erp/views/clientes/tmpl/exportar.php" method="post" style="margin:0px">
                      <div class="col-sm-12">
                        <div class="row">
                        	<div class="col-md-4"><button type="button" class="btn bg-blue btn-sm col-md-12" style="text-align:left" id="reg" data-sw="1">Registro de Asociado</button></div>
                            <div class="col-md-4"><button type="button" class="btn bg-blue btn-sm col-md-12" style="text-align:left" id="uas" data-sw="1">Registro UAS</button></div>
                            <div class="col-md-4"><button type="button" class="btn bg-blue btn-sm col-md-12" style="text-align:left" id="dc" data-sw="1">Datos de Contacto</button></div>
                        </div>
                        <div class="col-md-12 regisasoc" style="display:none">
                            <div class="col-sm-12">
                                <label for="" class="text-blue labelcheck"><input type="checkbox" name="m_reg" id="m_reg" value="1" checked> Marcar Todo</label>
                            </div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="nit" id="" class="regis_as" value="1" checked> NIT</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="testimonio_nro" id="testimonio_nro" value="1" checked> Testimonio Nro.</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="mat_fundaempresa" id="mat_fundaempresa" value="1" checked> Mat. FUNDEMPRESA</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="capital" id="capital" value="1" checked> Capital</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="correo" id="correo" value="1" checked> Correo-e</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="telefono" id="telefono" value="1" checked> Teléfono</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="celular" id="fax" value="1" checked> Celular</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="casilla" id="casilla" value="1" checked> Casilla</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="dirección" id="dirección" value="1" checked> Dirección</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="zona" id="zona" value="1" checked> Zona</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="ciudad" id="ciudad"value="1" checked> Ciudad</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="departamento" id="departamento" value="1" checked> Departamento</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="regis" name="inscrito_por" id="inscrito_por" value="1" checked> Inscrito por</label></div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="col-xs-12 reguas" style="display:none">
                            <div class="col-sm-12">
                                <label for="" class="text-blue labelcheck"><input type="checkbox" name="m_uas" id="m_uas" value="1" checked> Marcar Todo</label>
                            </div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="libro" id="libro" value="1" checked> Libro</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="tomo" id="tomo" value="1" checked> Tomo</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="partida" id="partida" value="1" checked> Partida</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="categoría" id="categoría" value="1" checked> Categoría</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="cobrador" id="cobrador" value="1" checked> Cobrador</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="mensajería" id="mensajería" value="1" checked> Mensajería</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="uas" name="atache" id="atache" value="1" checked> Ataché</label></div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="col-xs-12 regdcon" style="display:none">
                            <div class="col-sm-12">
                                <label for="" class="text-blue labelcheck"><input type="checkbox" name="m_dc" id="m_dc" value="1" checked> Marcar Todo</label>
                            </div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="contacto" name="nombreyapellido" id="nombreyapellido" value="1" checked> Nombre y Apellido</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="contacto" name="cargo" id="cargo" value="1" checked> Cargo</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="contacto" name="poder_nro" id="poder_nro" value="1" checked > Poder nro.</label></div>
                        </div>
                      </div>
                      <!--<div class="col-sm-12">
                        <div class="col-xs-12">
                            <button type="button" class="btn bg-blue btn-sm col-sm-6 col-md-2 col-xs-12" style="text-align:left" id="eac" data-sw="1">Encuesta de Actividad Económica</button>
                        </div>
                        <div class="col-xs-12 regacec" style="display:none">
                            <div class="col-sm-12">
                                <label for="" class="text-blue labelcheck"><input type="checkbox" name="m_eac" id="m_eac" value="1" checked> Marcar Todo</label>
                            </div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="encuesta" name="tipo_de_empresa" id="tipo_de_empresa" value="1" checked> Tipo de Empresa</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="encuesta" name="sucursales" id="sucursales" value="1" checked> Sucursales</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="encuesta" name="personal_permanente" id="personal_permanente" value="1" checked> Personal Permanente</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="encuesta" name="personal_temporal" id="personal_temporal" value="1" checked> Personal Temporal</label></div>
                            <div class="col-sm-4 col-md-3"><label for="" class="labelcheck"><input type="checkbox" class="encuesta" name="actividades" id="actividades" value="1" checked> Actividades</label></div>
                        </div>
                      </div>-->
                    <button class="btn btn-success pull-right" type="submit">
                    	<em class="fa fa-file-excel-o"></em> 
                        Exportar a Excel
                    </button>
                    <a href="index.php?option=com_erp&view=clientes&layout=imprimeejecutivo&tmpl=component" class="btn btn-primary pull-right" rel="shadowbox">
                    	<em class="fa fa-print"></em> 
                        Imprimir
                    </a>
                    <input type="hidden" name="filtro_asociado" value="<?=$asociado?>">
                    <input type="hidden" name="filtro_registro" value="<?=$registro?>">
                    <input type="hidden" name="filtro_id_categoria" value="<?=$id_categoria?>">
                  </form>
              </div>
              <? }?>
          </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
          <thead>
            <tr>
              <th width="80"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Registro</span></th>
              <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Asociado</span></th>
              <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cobrador">Cobrador</span></th>
            </tr>
          </thead>
          <tbody>
            <? 
			if(!empty($asociado) || !empty($registro) || !empty($id_categoria) || !empty($id_mensajero) || !empty($id_tipo) || !empty($id_estado) || !empty($id_actividad)){
				foreach(getClientesrep(1) as $cliente){
               // print_r($cliente);?>
            <tr>
              <td><?=$cliente->registro?></td>
              <td><? echo '<em class="fa fa-briefcase"></em> <strong>'.trim($cliente->empresa).'</strong><br />';
                        echo '<span style="font-size:10px"><em class="fa fa-user"></em> Titular: '.$cliente->apellido.' '.$cliente->nombre.'</span>';?></td>
              <td><? foreach(getUsuariosext('c',1) as $usuarioc){
                    if($cliente->id_usuario_cobrador== $usuarioc->id){?>
						<?=$usuarioc->nombre;?>
                    <? }
                 }?>
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