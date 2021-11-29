<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');
?>
<script>
var productos = "<select name='servicio[]' class='form-control validate[required]' id='servicio_0'><option value=''>Sin asignar</option>";
     <? foreach (getProductos() as $intereses){?>
            productos += "<option value='<?=$intereses->id?>'><?=$intereses->name?></option>";
    <? }?>
    productos += "</select>";
</script>
<script>
var n = 0;
var checkN = 0;
var checkP = 0;
jQuery(document).on('ready',function(){
    jQuery('.adiciona').on('click',function(){
        n++;
        $('.col-sm-offset-2').before(
             '<div class="compranuevo row col-sm-11" style="border-top: 1px black solid;">'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Razón Social <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="empresa[]" type="text" class="form-control validate[required]" id="empresa_'+n+'" placeholder="Nombre o Razón Social" title="Debe introducir un nombre o razón social*" onkeyup="buscaEmpresa(this.id)" /><input type="hidden" name="id_empresa[]" id="id_empresa_'+n+'"><div id="lista_empresa_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'NIT <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="nit[]" type="text" class="form-control validate[required]" id="nit_'+n+'" placeholder="NIT" title="Debe introducir un NIT*" onkeyup="buscarNit(this.id)" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Nº Autorizacion <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="autorizacion[]" type="text" class="form-control validate[required]" id="autorizacion_'+n+'" placeholder="Nro. Autorizacion" title="Debe introducir un número de autorización*" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Nº Factura <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="numero[]" type="text" class="form-control validate[required]" id="numero_'+n+'" placeholder="Nro. Factura" title="Debe introducir un número de factura*" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Fecha de Emisión <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input type="text" name="fecha_emision[]" id="fecha_emision_'+n+'" class="form-control validate[required] datepicker" title="Debe introducir la fecha de la factura*">'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Número DUI'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="dui[]" data-toggle="tooltip" title="Número DUI" type="text" class="form-control" id="dui_'+n+'" placeholder="Nro. de DUI" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Monto <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="total[]" type="text" class="form-control validate[required]" id="total_'+n+'" placeholder="Monto total factura" title="Debe introducir el monto total de la factura*" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                       ' Importe <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="nocredito[]" data-toggle="tooltip" title="Importe no sujeto a crédito fiscal" type="text" class="form-control validate[required]" id="nocredito_'+n+'" placeholder="Imp. no sujeto a crédito fiscal"  />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Descuento'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="descuento[]" data-toggle="tooltip" title="Descuentos" type="text" class="form-control" id="descuento_'+n+'" placeholder="Descuentos"/>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Código de Control </i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<input name="codigo[]" data-toggle="tooltip" title="Código de Control" type="text" class="form-control" id="codigo_'+n+'" placeholder="Código de Control" style="text-transform:uppercase" />'+
                    '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Tipo de Compra <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        '<select name="tipo[]" class="form-control validate[required]" id="tipo_'+n+'" title="Debe indicar el tipo de compra*">'+
                            '<option value="1">Compra para mercado interno con destino a actividades gravadas</option>'+
                            '<option value="2">Compra para mercado interno con destino a actividades no gravadas</option>'+
                            '<option value="3">Compras sujetas a proporcionalidad</option>'+
                            '<option value="4">Compras para exportaciones</option>'+
                            '<option value="5">Compras tanto para mercado interno como para exportaciones</option>'+
                          '</select>'+
                    '</div>'+
                    '<label class="col-xs-12 col-sm-2">'+
                        'Servicio <i class="fa fa-asterisk text-red"></i>'+
                    '</label>'+
                    '<div class="col-xs-12 col-sm-10">'+
                        productos+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="col-xs-12 col-sm-1">'+
                '<button type="button" class="eliminar btn btn-danger col-xs-12 btn-sm"> <span class="visible-xs"> Eliminar Campos</span><i class="fa fa-trash"></i></button>'+
            '</div>'
        );
    })
    //borrando campos añadidos
    jQuery('form').on('click','.eliminar',function(){
        jQuery(this).parent().prev().remove();
        jQuery(this).parent().remove();
        n--;
    })
})    
function buscaEmpresa(varid) {
	var id = varid.split('_');
	checkP++;
	setTimeout(function(){
		var empresa = jQuery('#empresa_'+id[1]).val();
		if(checkP > 1){
			checkP--;
			return false;
		}
		jQuery('#lista_empresa_'+id[1]).fadeOut();
		jQuery('#lista_empresa_'+id[1]).html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=empresacompra&tmpl=component", {empresa:empresa, id:id[1]}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#lista_empresa_'+id[1]).html(contenido[0]);
		  jQuery('#lista_empresa_'+id[1]).fadeIn();
	    });
		checkP = 0;
		}, 1000);
	return false;
}
function cargaEmpresa(id, id_empresa, empresa, nit){
	jQuery('#id_empresa_'+id).val(id);
	jQuery('#empresa_'+id).val(empresa);
	jQuery('#nit_'+id).val(nit);
	cerrarVentana('lista_empresa_'+id);
	}
function buscarNit(varid) {
	var id = varid.split('_');
	checkN++;
	setTimeout(function(){
		var nit = jQuery('#nit_'+id[1]).val();
		if(checkN > 1){
			checkN--;
			return false;
		}
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nitcompra&tmpl=component", {nit:nit,id:id[1]}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  var v = contenido[0].split('|');
		  if(v[3] != '')
		  	cargaEmpresa(v[0], v[1], v[2], v[3]);
	    });
		checkN = 0;
		}, 1000);
	return false;
	}
function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	jQuery('#'+id).html('');
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-shopping-cart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Compra</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" autocomplete="off" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" onSubmit="return verificarFormu(this); ">
            <div class="compranuevo">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Razón Social <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="empresa[]" type="text" class="form-control validate[required]" id="empresa_0" placeholder="Nombre o Razón Social" title="Debe introducir un nombre o razón social*" onkeyup="buscaEmpresa(this.id)" /><input type="hidden" name="id_empresa[]" id="id_empresa_0"><div id="lista_empresa_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        NIT <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="nit[]" type="text" class="form-control validate[required]" id="nit_0" placeholder="NIT" title="Debe introducir un NIT*" onkeyup="buscarNit(this.id)" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Nº Autorizacion <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="autorizacion[]" type="text" class="form-control validate[required]" id="autorizacion_0" placeholder="Nro. Autorizacion" title="Debe introducir un número de autorización*" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Nº Factura <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="numero[]" type="text" class="form-control validate[required]" id="numero_0" placeholder="Nro. Factura" title="Debe introducir un número de factura*" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Fecha de Emisión <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input type="text" name="fecha_emision[]" id="fecha_emision_0" class="form-control validate[required] datepicker" title="Debe introducir la fecha de la factura*">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Número DUI
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="dui[]" data-toggle="tooltip" title="Número DUI" type="text" class="form-control" id="dui_0" placeholder="Nro. de DUI" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Monto <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="total[]" type="text" class="form-control validate[required]" id="total_0" placeholder="Monto total factura" title="Debe introducir el monto total de la factura*" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Importe <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="nocredito[]" data-toggle="tooltip" title="Importe no sujeto a crédito fiscal" type="text" class="form-control validate[required]" id="nocredito_0" placeholder="Imp. no sujeto a crédito fiscal"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Descuento
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="descuento[]" data-toggle="tooltip" title="Descuentos" type="text" class="form-control" id="descuento_0" placeholder="Descuentos"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Código de Control
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <input name="codigo[]" data-toggle="tooltip" title="Código de Control" type="text" class="form-control" id="codigo_0" placeholder="Código de Control" style="text-transform:uppercase" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Tipo de Compra <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <select name="tipo[]" class="form-control validate[required]" id="tipo_0" title="Debe indicar el tipo de compra*">
                            <option value="1">Compra para mercado interno con destino a actividades gravadas</option>
                            <option value="2">Compra para mercado interno con destino a actividades no gravadas</option>
                            <option value="3">Compras sujetas a proporcionalidad</option>
                            <option value="4">Compras para exportaciones</option>
                            <option value="5">Compras tanto para mercado interno como para exportaciones</option>
                          </select>
                    </div>
                    <label class="col-xs-12 col-sm-2">
                        Servicio <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-10">
                        <select name="servicio[]" class="form-control validate[required]" id="servicio_0">
                            <option value="">Sin Aginar</option>
                            <? foreach (getProductos() as $intereses){ ?>
                                    <option value="<?=$intereses->id?>"><?=$intereses->name?></option>
                            <? }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-2">
                <a class="btn btn-info col-xs-6 btn-sm col-sm-3 adiciona"><i class="fa fa-plus"></i> Agregar fila</a>
                <button class="btn btn-success btn-sm col-xs-6 col-sm-3" type="submit"><i class="fa fa-check"></i> Registra Compras</button>
            </div>
        </form>
            <? }else{
                $compra = newCompra();
                if($compra == ''){?>
                <h3>Los registros fueron adicionados correctamente</h3>
                <a href="index.php?option=com_erp&view=facturacion&layout=compras" class="btn btn-success">Volver</a>
                <?
                }else{
                    $factura = explode(':', $compra);?>
                <h3>Algunas facturas ya se encuentran registradas en el sistema</h3>
                <ul>
                <?
                foreach($factura as $fact){
                    $f = explode('|', $fact);
                    echo '<li>
                    NIT: '.$f[0].'<br />
                    Número: '.$f[1].'<br />
                    Autorización: '.$f[2].'
                    </li>';
                    }
                ?>
                </ul>
                <a href="index.php?option=com_erp&view=facturacion&layout=compras" class="btn btn-success">Volver</a>
                <? }
              }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>