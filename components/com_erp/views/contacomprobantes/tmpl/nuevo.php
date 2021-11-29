<?php 
defined('_JEXEC') or die;
 if(validaAcceso('Contabilidad Comprobante nuevo')){
?>
<style>
.div_cuenta{
	width: 100%;
	height:0px; 
	overflow:visible; 
	position:absolute; 
	z-index:10000;
	}
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance:textfield;
}
.table-responsive{
    overflow-y: initial;
}
.popover-title {
	text-align: center;
	background-color: red;
    color: white;
}
    .egreso,.ingreso{
        display: none;
    }
</style>
<script>
var checkCod = 0;
var checkCnt = 0;
var n = 2;
function saveNew(){
	jQuery('#nuevo').val(1)
	jQuery('.btn-success').trigger('click');
	}
function adicionaDetalle(){
	var lim_det = 50;
	var fila = '<tr id="tr_'+n+'"><td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td>';
	fila+= '<td><div class="input-group"><input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_'+n+'" onKeyUp="buscaCodigo(this.id)" data-toggle="popover" data-placement="top" data-trigger="focus" title="ADVERTENCIA" data-content="NO SE HA ENCONTRADO LA CUENTA"><div class="input-group-btn"><button type="button" class="btn btn-info" id="buscar_'+n+'" onClick="popup(this.id)"><em class="fa fa-search"></em></button></div></div><input type="hidden" name="id_cta[]" id="id_cta_'+n+'"><input type="hidden" name="id_aux[]" id="id_aux_'+n+'"><div id="lista_producto_'+n+'" class="div_cuenta"></div></td>';
	fila+= '<td><input name="cuenta[]" readonly type="text" class="form-control validate[required]" id="descripcion_'+n+'"></td>';
	fila+= '<td><input name="detalle[]" type="text" class="form-control validate[required,maxSize[<?=$lim_det?>]]" id="cliente_'+n+'"></td>';
	fila+= '<td><input name="debe[]" type="text" step="any" class="form-control validate[required, custom[number]] text-right" id="debe_'+n+'" onkeyup="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>';
	fila+= '<td><input name="haber[]" type="text" step="any" class="form-control validate[required, custom[number]] text-right" id="haber_'+n+'" onkeyup="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>';
	fila+= '<td><a class="btn btn-danger" id="'+n+'" onclick="quitaDetalle(this.id)"><i class="fa fa-trash "></i></a></td></tr>';
	jQuery('#tabla_detalle tbody').append(fila);
	jQuery('[data-toggle="tooltip"]').tooltip();
	n++;
	calcula();
	}
function quitaDetalle(id){
    //alert(jQuery('#tr_' + id).attr('id'))
	jQuery('#tr_' + id).remove();
	calcula();
	}
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listado&tmpl=component&id_html='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html, id_aux){	
	jQuery('#codigo_' + id_html).val(codigo);
	jQuery('#descripcion_' + id_html).val(nombre);
	jQuery('#id_cta_' + id_html).val(id);
	jQuery('#id_aux_' + id_html).val(id_aux);
	}
function monto(id){
	var monto = id.split('_');
	if(monto[0] == 'debe'){
        if(jQuery("#"+id).val()!="0.00"){
		  jQuery('#haber_' + monto[1]).val('0.00');
        }
    }else{
        if(jQuery("#"+id).val()!="0.00"){
		  jQuery('#debe_' + monto[1]).val('0.00');
        }		
    }
	calcula();
	}
function decimal(id){
	/*var num = jQuery('#'+id).val();
	num = (num).toFixed(2);
	jQuery('#'+id).val(num);*/
	}
function calcula(){
	var debe = 0;
	var d = 0;
	var haber = 0;
	var h = 0;
	for(i=0; i<n; i++){
		if(isNaN(parseFloat(jQuery('#debe_'+i).val())))
			d = 0;
			else
			d = parseFloat(jQuery('#debe_'+i).val());
		if(isNaN(parseFloat(jQuery('#haber_'+i).val())))	
			h = 0;
			else
			h = parseFloat(jQuery('#haber_'+i).val());
		debe+= d;
		haber+= h;
		}
	/*debe = Math.round(debe * 100) / 100;
	alert(debe);
	haber = Math.round(haber * 100) / 100;*/
	
	jQuery('#total_debe').val((debe).toFixed(2));
	jQuery('#total_haber').val((haber).toFixed(2));
    debe = debe.toFixed(2);
    haber = haber.toFixed(2);
    
	if(debe === haber && debe != 0){
        jQuery('#inform').html(debe+' SON IGUALES '+haber);
		jQuery('#envia').fadeIn();
		jQuery('#envia').removeAttr('disabled');
    }else{        
        jQuery('#inform').html(debe+' NO SON IGUALES NI IDENTICOS '+haber);
		jQuery('#envia').fadeOut();
		jQuery('#envia').attr('disabled','disabled');        
    }
}
function muestraCuentas(tipo){
	var layout = '';
	if(tipo == 1)
		layout = 'cabonado';
		else
		layout = 'crecibido';
		
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contacomprobantes&layout='+layout+'&tmpl=component', width:800, height:650, player: "iframe"}); return false;
	}
function asigna(nombre, id){
	jQuery('#id_cliente_nombre').val(nombre);
	jQuery('#id_cliente').val(id);
	}
function encabezado(){
	var tipo = jQuery('#tipo').val();
	jQuery('#id_cliente_nombre').val('');
	jQuery('#id_cliente').val('');
	if(tipo == 1 || tipo == 2){
		jQuery('.block_nombre').fadeIn();
		if(tipo == 1){
			jQuery('#encabezado_text').html('Hemos abonado a <i class="fa fa-asterisk text-red"></i>');
			jQuery('#egreso').fadeOut(500);
			jQuery('#ingreso').fadeIn(500);
            jQuery('.egreso').show(500);
            jQuery('.ingreso').hide(500);
		}else{
			jQuery('#encabezado_text').html('Hemos recibido de <i class="fa fa-asterisk text-red"></i>');
			jQuery('#ingreso').fadeOut(500);
			jQuery('#egreso').fadeIn(500);
            jQuery('.egreso').hide(500);
            jQuery('.ingreso').show(500);
		}
    }
    else{
        jQuery('.block_nombre').fadeOut();
        jQuery('.egreso').hide(500);
        jQuery('.ingreso').hide(500);
    }
}
function abrePopUp(t){

	var layout;
	if(t == 'lv'){
		layout = 'listaventa';        
    }else if(t == 'lc'){
		layout = 'listacompra';
    }else{
        layout = 'listacheque';
    }

	Shadowbox.open({ content: 'index.php?option=com_erp&view=contacomprobantes&layout='+layout+'&n='+n+'&tmpl=component', width:900, height:450, player: "iframe"}); return false;
	}
/*function carga(id, id_factura, cliente, total, origen){
	<?
	$lc = getDatosLCV('lc');
	$lv = getDatosLCV('lv');
	?>
	var imp_codigo;
	var imp_id;
	var imp_cuenta;	
	
	var monto = parseFloat(total) * 0.87;
	monto = Math.round(monto * 100) / 100;
	var impuesto = parseFloat(total) - monto;
	impuesto = Math.round(impuesto * 100) / 100;
	
	var casilla;
	var id_impuesto = 0;
	if(origen == 1){
		casilla = 'haber_';
		imp_codigo = '<?=$lv->codigo?>';
		imp_id = '<?=$lv->id?>';
		imp_cuenta = '<?=filtroCadena2($lv->nombre)?>';
		}else{
		casilla = 'debe_';
		imp_codigo = '<?=$lc->codigo?>';
		imp_id = '<?=$lc->id?>';
		imp_cuenta = '<?=filtroCadena2($lc->nombre)?>';
		}
	
	jQuery('#' + casilla + id).val(monto);
	jQuery('#cliente_' + id).val(cliente);
	jQuery('#id_factura_' + id).val(id_factura);
	jQuery('#origen_' + id).val(origen);
	
	adicionaDetalle()
	id_impuesto = n-1;
	
	jQuery('#' + casilla + id_impuesto).val(impuesto);
	jQuery('#codigo_' + id_impuesto).val(imp_codigo);
	jQuery('#id_' + id_impuesto).val(imp_id);
	jQuery('#descripcion_' + id_impuesto).val(imp_cuenta);
	
	calcula();
	}*/
function datos(filas, id, m){
    //alert(filas)
    jQuery('#tabla_detalle tbody').append(filas);
	n = m;
    calcula();
	}
function buscaCodigo(varid) {
	var id = varid.split('_');
	var codigo = jQuery('#codigo_'+id[1]).val();
	checkCod++;
	if(codigo != ''){
		setTimeout(function(){
			if(checkCod > 1){
				checkCod--;
				return false;
			}
			/*jQuery('#lista_producto_'+id[1]).fadeOut();
			jQuery('#lista_producto_'+id[1]).html('');*/
			if(codigo.length == 10){
                
                jQuery.post( 'index.php?option=com_erp&view=contacomprobantes&layout=codigos&tmpl=blank', {codigo:codigo, id:id[1]}, function(data) {
                    
                    if(data==''){                        
                        jQuery('#codigo_'+id[1]).popover('show');
                    }else{
                        jQuery('#codigo_'+id[1]).popover('destroy');
                        var cadena = data.split("|");
                        cargarcuenta(cadena[0], '0', cadena[1], cadena[2], cadena[3]);
                    }
                    /*jQuery('#lista_producto_'+id[1]).html(data);
                  jQuery('#lista_producto_'+id[1]).fadeIn();*/
                });
            }
			checkCod = 0;
			}, 500);
		return false;	
		}
		else
		checkCod = 0;
	}
function buscaCuenta(varid) {
	var id = varid.split('_');
	var cuenta = jQuery('#descripcion_'+id[1]).val();
	checkCnt++;
	if(cuenta != ''){
		setTimeout(function(){
			if(checkCnt > 1){
				checkCnt--;
				return false;
			}
			jQuery('#lista_cuentas_'+id[1]).fadeOut();
			jQuery('#lista_cuentas_'+id[1]).html('');
			
			jQuery.post( "index.php?option=com_erp&view=contacomprobantes&layout=cuentas&tmpl=blank", {cuenta:cuenta, id:id[1]}, function(data) {
			  jQuery('#lista_cuentas_'+id[1]).html(data);
			  jQuery('#lista_cuentas_'+id[1]).fadeIn();
			});
			checkCnt = 0;
			}, 1000);
		return false;	
		}else
		checkCnt = 0;
	}
function cargarcuenta(id, id_aux, codigo, cuenta, idHtml){
	jQuery('#id_cta_'+idHtml).val(id);
	jQuery('#id_aux_'+idHtml).val(id_aux);
	jQuery('#codigo_'+idHtml).val(codigo);
	jQuery('#descripcion_'+idHtml).val(cuenta);
	
	jQuery('#lista_producto_'+idHtml).fadeOut();
	jQuery('#lista_producto_'+idHtml).html('');
	jQuery('#lista_cuentas_'+idHtml).fadeOut();
	jQuery('#lista_cuentas_'+idHtml).html('');
	}
function cerrarVentana(id){
	jQuery('#lista_producto_'+id).fadeOut();
	jQuery('#lista_producto_'+id).html('');
	jQuery('#lista_cuentas_'+id).fadeOut();
	jQuery('#lista_cuentas_'+id).html('');
	}

var contador, numero;
jQuery(document).on('ready',function(){     
    jQuery("body").on('click','.botonelimina', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).remove();      
    });
    jQuery('body').on('mouseenter','.botonelimina, .botonelimina i', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).attr('data-resalta','venta');        
    })
    jQuery('body').on('mouseout','.botonelimina', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).removeAttr('data-resalta');        
    })
    
    jQuery("body").on('click','.botoneliminacomp', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).remove();        
    });
    
    jQuery('body').on('mouseenter','.botoneliminacomp, .botoneliminacomp i', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).attr('data-resalta2','compra');
    })
    jQuery('body').on('mouseout','.botoneliminacomp', function(){
        jQuery('.'+jQuery(this).closest('tr').attr('class')).removeAttr('data-resalta2');
    })
	 jQuery("form").on('focus', 'input[type=text]', function(){	   
		this.select();
	})
    //calendario
    jQuery("form").on('focus', '.calendar', function(){
        jQuery(this).datepicker({
        showOn: 'both',        
        buttonImageOnly: true,        
        numberOfMonths: 1,
        yearRange: '-100:+0',/*
        minDate: jQuery(this).val(),*/
        dateFormat:"dd/mm/yy",
        changeMonth: true, 
        changeYear:true,
        dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Jue", "Vie", "Sa" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        showButtonPanel: true      
        });
        jQuery(this).datepicker("show");        
    });
    jQuery('form').on('keyup',function(e){   
        if(e == 13){
          return false;
        }
    });      
})
</script>
<? //$tipo = ucfirst(tipocomprobante());
$lim_tipoc = 10;
$lim_ab = 50;
$lim_conc = 50;
$lim_ref = 40;
$lim_glos = 255;
$lim_det = 50;
$lim_fecha = 10;
$lim_fact = 255;
$lim_cheq = 255;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Comprobante</h3>        
      </div>
	  <? if(!$_POST){?>
      <form action="" method="post" onSubmit="return verificarFormu(this); " name="form" id="form" enctype="multipart/form-data" class="form-horizontal">
        <div class="box-body">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Tipo de comprobante <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                   <select name="tipo" id="tipo" onChange="encabezado()" class="form-control validate[required]" title="Debe elegir el tipo de comprobante*">
                      <option value=""></option>
                      <? foreach(getTipoComprobantes() as $tipo){?>
                      <option value="<?=$tipo->id?>">
                        <?=$tipo->tipo?>
                      </option>
                      <? }?>
                   </select>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Fecha <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                   <!--<input type="text" id="fecha" name="fecha" class="form-control calendar validate[required, maxSize[<?=$lim_fecha?>]]" value="<?=fecha(getCNTultimafecha());?>" data-calendario="<?=getCNTultimafecha()?>">-->
                   <input type="text" id="fecha" name="fecha" class="form-control calendar " value="<?=date('d/m/Y');?>" data-calendario="<?=getCNTultimafecha()?>">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Tipo de cambio <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                   <input name="cambio" type="text" step="any" class="form-control validate[required, maxSize[<?=$lim_tipoc?>]]" id="focusedInput" value="<?=readXML("https://www.bcb.gob.bo/rss_bcb.php", 10)?>">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  <span class="block_nombre" style="display:none" id="encabezado_text">Hemos recibido de <i class="fa fa-asterisk text-red"></i></span>
               </label>
               <div class="col-xs-12 col-sm-4" >
                    <div class="block_nombre input-group" style="display:none">
                        <input type="text" class="form-control validate[maxSize[<?=$lim_ab?>]]" name="cliente_nombre" id="id_cliente_nombre"></input>
                        <span class="input-group-btn">
                        	<button type="button" onClick="muestraCuentas(1)" id="ingreso" style="display:none" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                        	<button type="button" onClick="muestraCuentas(2)" id="egreso" style="display:none" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                        <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$rw->p_id?>">
                    </div>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Gestión <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                      
                    <select id="id_gestion" name="id_gestion" class="form-control validate[required]">
                      <? foreach(getGestiones() as $gestion){?>
                      <option value="<?=$gestion->id?>" <?=$gestion->activa==1?'selected':''?>><?=$gestion->gestion?></option>
                      <? }?>
                    </select>
               </div>
               <label for="" class="ingreso col-xs-12 col-sm-2 control-label">
                  Factura Nro. <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4 ingreso">                      
                    <input type="text" name="factura_nro" id="nro_factura" class=" form-control validate[required, maxSize[<?=$lim_fact?>]]" value="">
               </div>
           </div>
            <div class="form-group egreso">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Cheque Nro.<i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                   <input name="cheque_nro" type="text" class="form-control validate[required, maxSize[<?=$lim_cheq?>]]">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Banco <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4" >
                    <select name="id_banco" id="id_banco" class="form-control valudate[required]">
                        <? foreach (getLBcuentas() as $banco){
                            echo '<option value="'.$banco->id.'">'.$banco->banco.'</option>';
                        }?>
                    </select>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Concepto <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">                         
                    <input name="concepto" type="text" class="form-control validate[required,maxSize[<?=$lim_ref?>]]" id="focusedInput2">
                      </span><img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nombre">
                    <div id="lista_nombre" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>                      
               </div>
           </div>
          <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  Glosa <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">                         
                    <textarea name="glosa" id="glosa" rows="5" class="form-control validate[required,maxSize[<?=$lim_glos?>]]"></textarea>
               </div>
           </div>
           <div class="">
                <table class="table table-striped sortable" id="tabla_detalle">
                    <thead>
                      <tr>
                        <th width="40"></th>
                        <th width="160">C&oacute;digo <i class="fa fa-asterisk text-red"></i></th>
                        <th>Cuenta Contable <i class="fa fa-asterisk text-red"></i></th>
                        <th width="280">Detalle <i class="fa fa-asterisk text-red"></i></th>
                        <th width="100">Debe <i class="fa fa-asterisk text-red"></i></th>
                        <th width="100">Haber <i class="fa fa-asterisk text-red"></i></th>
                        <th width="42"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr id="tr_0">
                        <td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td>
                        <td id="td_0">
                        	<div class="input-group">
                            	<input name="codigo[]" type="text" class="form-control validate[required] code" id="codigo_0" onKeyUp="buscaCodigo(this.id)" data-toggle="popover" data-placement="top" data-trigger="focus" title="ADVERTENCIA" data-content="NO SE HA ENCONTRADO LA CUENTA">
                                <div class="input-group-btn">
                                	<button type="button" class="btn btn-info" id="buscar_0" onClick="popup(this.id)">
                                    	<em class="fa fa-search"></em>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id_cta[]" id="id_cta_0">
                            <input type="hidden" name="id_aux[]" id="id_aux_0">
                            <div id="lista_producto_0" class="div_cuenta"></div>
                        </td>
                        <td>
                        	<input name="cuenta[]" type="text" class="form-control validate[required]" id="descripcion_0" onKeyUp="buscaCuenta(this.id)">
                        	<div id="lista_cuentas_0" class="div_cuenta"></div>
                        </td>
                        <td>
                            <input name="detalle[]" type="text" class="form-control validate[required,maxSize[<?=$lim_det?>]]" id="cliente_0"></td>
                        <td><input name="debe[]" type="text" class="form-control validate[required,custom[number]] text-right" id="debe_0" onkeyup="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>
                        <td><input name="haber[]" type="text" class="form-control validate[required,custom[number]] text-right" id="haber_0" onkeyup="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>
                        <td><a class="btn btn-danger" id="0" onclick="quitaDetalle(this.id)"><i class="fa fa-trash "></i></a></td>
                      </tr>
                      <tr id="tr_1">
                        <td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td>
                        <td id="td_1">
                        	<div class="input-group">
                            	<input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_1" onKeyUp="buscaCodigo(this.id)" data-toggle="popover" data-placement="top" data-trigger="focus" title="ADVERTENCIA" data-content="NO SE HA ENCONTRADO LA CUENTA">
                                <div class="input-group-btn">
                                	<button type="button" class="btn btn-info" id="buscar_1" onClick="popup(this.id)">
                                    	<em class="fa fa-search"></em>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id_cta[]" id="id_cta_1">
                            <input type="hidden" name="id_aux[]" id="id_aux_1">
                            <div id="lista_producto_1" class="div_cuenta"></div>
                        </td>
                        <td>
                        	<input name="cuenta[]" type="text" class="form-control validate[required]" id="descripcion_1" onKeyUp="buscaCuenta(this.id)">
                            <div id="lista_cuentas_1" class="div_cuenta"></div>
                        </td>
                        <td>
                            <input name="detalle[]" type="text" class="form-control validate[required,maxSize[<?=$lim_det?>]]" id="cliente_1"></td>
                        <td><input name="debe[]" type="text" class="form-control validate[required,custom[number]] text-right" id="debe_1" onKeyUp="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>
                        <td><input name="haber[]" type="text" class="form-control validate[required,custom[number]] text-right" id="haber_1" onKeyUp="monto(this.id)" onBlur="decimal(this.id)" value="0.00"></td>
                        <td><a class="btn btn-danger" id="1" onclick="quitaDetalle(this.id)"><i class="fa fa-trash "></i></a></td>
                      </tr>                                            
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right"><strong>Total</strong></td>
                        <td><input name="total_debe" type="text" readonly class="form-control validate[required] text-right" id="total_debe" value="0.00"></td>
                      <td><input name="total_haber" type="text" readonly class="form-control validate[required] text-right" id="total_haber" value="0.00"></td>
                      <td></td>
                      </tr>
                      <tr>
                        <td colspan="9">
                        </td>
                      </tr>
                    </tfoot>
                </table>
            </div>
           <div class="box-footer">
               <div class="col-xs-12 col-md-4">
                    <a onClick="abrePopUp('lv')" id="venta_0" class="btn btn-info bg-blue btn-block"><i class="fa fa-list-alt "></i> Cargar venta</a>
               </div>
               <div class="col-xs-12 col-md-4">
                    <a onClick="abrePopUp('lc')" class="btn btn-info bg-navy btn-block"><i class="fa fa-list-alt "></i> Cargar compra</a>
               </div>
               <div class="col-xs-12 col-md-4">
                    <a onClick="abrePopUp('ch')" class="btn btn-info bg-primary btn-block"><i class="fa fa-list-alt "></i> Cargar cheque</a>
               </div>
           </div>
           <div class="box-footer">
               <div class="col-xs-12 col-md-6">
                    <a class="btn btn-block btn-info" onclick="adicionaDetalle()"><i class="fa fa-plus"></i> A&ntilde;adir campo</a>
               </div>
               <div class="col-xs-12 col-md-6">
               		<button class="btn btn-block btn-success" id="envia" style="display:none" type="submit" disabled><i class="fa fa-saved"></i> Crear Comprobante</button>
               </div>
           </div>
           
        </div>
      </form>
      <? }else{
          $val = newCNTComprobante();
          $comprobante = getComprobante($val);
          ?>
          <h3>
            El comprobante se <strong>generó</strong> correctamente
          </h3>
          <h3 class="heading">Detalle del Comprobante Nro <?=$comprobante->numero?></h3>
          <div class="box-body">
           <form action="" class="form-horizontal">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Tipo de comprobante 
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input type="text" class="form-control" value="<?=getTipoComprobante($comprobante->id_tipo)?>" readonly>
                   </div>
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Fecha
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input type="text" id="fecha" name="fecha" class="form-control validate[required]" readonly value="<?=$comprobante->fec_creacion?>">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Tipo de cambio <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input name="cambio" type="number" class="form-control validate[required]" id="focusedInput" value="<?=$comprobante->tipo_cambio?>" readonly>
                   </div>
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      <? switch($comprobante->id_tipo){
                          case '1':
                          echo 'Hemos abonado a';
                          break;
                          case '2':
                          echo 'Hemos recibido de';
                          break;
                      }?>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                        <div id="block_nombre">
                            <input type="text" class="form-control" name="cliente_nombre" id="id_cliente_nombre" value="<?=$comprobante->cliente?>">
                        </div>
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Gestión
                   </label>
                   <div class="col-xs-12 col-sm-4">                       
                       <? $gestion = getGestion($comprobante->id_gestion);?>
                       <input type="text" class="form-control" value="<?=$gestion->gestion?>" readonly>                        
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Referencia <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                         
                        <input name="concepto" type="text" class="form-control span12" id="focusedInput2" value="<?=$comprobante->detalle?>" readonly>
                   </div>
                   
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                      Glosa <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                         
                        <textarea name="glosa" id="glosa" disabled rows="5" class="form-control"><?=$comprobante->glosa?></textarea>
                   </div>
               </div>
           </form>
           <table class="table table-striped" id="tabla_detalle">
                <thead>
                  <tr>
                    <th width="90">C&oacute;digo</th>
                    <th>Cuenta</th>
                    <th>Detalle</th>
                    <th width="100">Debe</th>
                    <th width="100">Haber</th>
                  </tr>
                </thead>
                <tbody>
                  <?
                foreach(getTipoComprobantes() as $tipo){                    
                    if($comprobante->id_tipo==$tipo->id){
                       $cmt = $tipo->tipo;
                    }
                }
                  $total_debe = 0;
                  $total_haber = 0;
                  foreach(getComprobanteDetalle($val) as $detalle){
                      $total_debe+= $detalle->debe;
                      $total_haber+= $detalle->haber;?>
                  <tr id="tr_0">
                    <td><?=$detalle->codigo?></td>
                    <td><?=$detalle->cuenta?></td>
                    <td><?=$detalle->detalle?></td>
                    <td style="text-align:right"><?=number_format($detalle->debe,2,",",".")?></td>
                    <td style="text-align:right"><?=number_format($detalle->haber,2,",",".")?></td>
                  </tr>
                  <? }?>
                </tbody>
                <tfoot>
                <tr>
                  <td colspan="3" style="text-align:right"><strong>Total</strong></td>
                  <td style="text-align:right"><?=number_format($total_debe,2,",",".")?></td>
                  <td style="text-align:right"><?=number_format($total_haber,2,",",".")?></td>
                </tr>
                  <tr>
                    <td colspan="5">
                      <a class="btn btn-info col-xs-12 col-sm-4" href="index.php?option=com_erp&view=contacomprobantes"><i class="fa fa-arrow-left"></i> Volver al Listado de Comprobantes</a>
                      <a class="btn btn-success col-xs-12 col-sm-4 pull-right" href="index.php?option=com_erp&view=contacomprobantes&layout=imprimecomprobante&id=<?=$comprobante->id?>&t=<?=$cmt?>&tmpl=component" rel="shadowbox; width=950"><i class="fa fa-print"></i> Imprimir</a>
                      <!--<a class="btn btn-success col-xs-12 col-sm-4 pull-right" href="index.php?option=com_erp&view=contacomprobantes&layout=imprime&id=<?=$val?>&tmpl=component" rel="shadowbox; width=950"><i class="fa fa-print"></i> Imprimir</a>-->
                    </td>
                  </tr>
                </tfoot>
            </table>
        </div> 
          <? 
      }?>
        <div id="inform"></div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>