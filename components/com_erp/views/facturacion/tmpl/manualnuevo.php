<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Compras')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');

$options = '';
foreach(getTipoFacturas() as $tipo){
	$tipofac = explode('|',$tipo->factura);
	$options.= '<option value="'.$tipo->id.'">'.$tipofac[0].'</option>';
}
?>
<script>
var n = 0;
var checkN = 0;
var checkP = 0;
function eliminaFila(num){
	jQuery('.tr_'+num).remove();
	}
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

// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_0").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
function fecha(id){
	jQuery("#fecha_"+id).datepicker({
		dateFormat: "yy-mm-dd"
	});
	}
    //validaciones
    var  lim_raz = 50, lim_nit = 20, lim_nfac = 15, lim_naut = 25, lim_total = 25;
jQuery(document).on('ready',function(){
    jQuery('.adicionando').on('click',function(){
        n++;
        jQuery(this).parent().before(
                '<div class="campos col-xs-12 col-md-11" style="border-top: 1px black solid; padding-top-5px;">'+
                   '<div class="form-group">'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                          ' Nombre o Razón Social <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input name="empresa[]" type="text" class="form-control validate[required,maxSize['+lim_raz+']]" id="empresa_'+n+'"/>'+
                       '</div>'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'NIT <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input name="nit[]" type="text" class="form-control validate[required,maxSize['+lim_nit+']]" id="nit_'+n+'" onkeypress="LP_data(event)" />'+
                       '</div>'+
                   '</div>'+
                   '<div class="form-group">'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Fecha de Emisión <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input type="text" name="fecha[]" id="fecha_'+n+'" class="form-control validate[required] fecha" onclick="fecha('+n+')" readonly>'+
                       '</div>'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Num. de Factura <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input name="numero[]" type="text" class="form-control validate[required, maxSize['+lim_nfac+']]" id="numero_'+n+'" onkeypress="LP_data(event)" />'+
                       '</div>'+
                   '</div>'+
                   '<div class="form-group">'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Num. de Autorización <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input name="autorizacion[]" type="text" class="form-control validate[required, maxSize['+lim_nfac+']]" id="autorizacion_'+n+'" />'+
                       '</div>'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Total <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<input name="total[]" type="text" class="form-control validate[required,maxSize['+lim_total+']]" id="total_'+n+'"/>'+
                       '</div>'+
                   '</div>'+
                   '<div class="form-group">'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Tipo <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<select name="id_tipo[]" id="id_tipo_'+n+'" class="form-control validate[required]">'+
                            '<option value="">-- Tipo --</option>'+
                            '<?=$options?>'+
                          '</select>'+
                       '</div>'+
                       '<label for="" class="col-xs-12 col-sm-2 control-label">'+
                           'Estado <i class="fa fa-asterisk text-red"></i>'+
                       '</label>'+
                       '<div class="col-xs-12 col-sm-4">'+
                           '<select name="estado[]" id="estado_'+n+'" class="form-control validate[required]"><option value="">-- Estado --</option><option value="V">Válido</option><option value="A">Anulado</option><option value="E">Extraviada</option><option value="N">No utilizada</option><option value="C">Emitida en contingencia</option></select>'+
                       '</div>'+
                   '</div>'+
               '</div>'+
               '<div class="col-xs-12 col-sm-1">'+
                    '<button type="button" class="btn btn-danger eliminar btn-sm"><span class="visible-xs">Eliminar Campos</span> <i class="fa fa-trash"></i></button>'+
                '</div>'            
        );
    })
    jQuery('form').on('click', '.eliminar', function(){
        jQuery(this).parent().prev().remove();
        jQuery(this).parent().remove();
        n--;
    })
})
</script>
<style>      
    
</style>
<?
//validaciones
    $lim_raz = 50;
    $lim_nit = 20;
    $lim_nfac = 15;
    $lim_naut = 25;
    $lim_total = 25;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Registro de Facturas de Contingecia</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post"  enctype="multipart/form-data" name="form" id="form" onSubmit="return verificarFormu(this);" class="form-horizontal">
               <div class="campos col-xs-12 col-md-11">
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Nombre o Razón Social <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input name="empresa[]" type="text" class="form-control validate[required]" id="empresa_0"/>
                       </div>
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           NIT <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input name="nit[]" type="text" class="form-control validate[required]" id="nit_0" onkeypress="LP_data(event)" />
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Fecha de la Factura <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input type="text" name="fecha[]" id="fecha_0" class="form-control validate[required] fecha" readonly>
                       </div>
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Num. de Factura <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input name="numero[]" type="text" class="form-control validate[required]" id="numero_0" onkeypress="LP_data(event)"/>
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Num. de Autorización <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input name="autorizacion[]" type="text" class="form-control validate[required]" id="autorizacion_0" onkeypress="LP_data(event)"/>
                       </div>
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Total <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <input name="total[]" type="text" class="form-control validate[required]" id="total_0"/>
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Tipo <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <select name="id_tipo[]" id="id_tipo_0" class="form-control validate[required]">
                            <option value="">-- Tipo --</option>
                            <? foreach(getTipoFacturas() as $tipo){
                                  $tipofac = explode('|',$tipo->factura);?>
                            <option value="<?=$tipo->id?>"><?=$tipofac[0]?></option>
                              <? }?>
                          </select>
                       </div>
                       <label for="" class="col-xs-12 col-sm-2 control-label">
                           Estado <i class="fa fa-asterisk text-red"></i>
                       </label>
                       <div class="col-xs-12 col-sm-4">
                           <select name="estado[]" id="estado_0" class="form-control validate[required]"><option value="">-- Estado --</option><option value="V">Válido</option><option value="A">Anulado</option><option value="E">Extraviada</option><option value="N">No utilizada</option><option value="C">Emitida en contingencia</option></select>
                       </div>
                   </div>
               </div>
               <div class="col-xs-12">
                   <a class="btn btn-info col-xs-12 col-sm-3 adicionando"><i class="fa fa-plus"></i> Agregar campos</a>
                   <button class="btn btn-success col-xs-12 col-sm-3 pull-right" type="submit"><i class="fa fa-check"></i> Registra compras</button>
               </div>
            </form>
            <div class="col-xs-12">Todos los campos marcados con <i class="fa fa-asterisk text-red"></i> son obligatorios</div>
            <? }else{
                $session = JFactory::getSession();
                newFacturaManual();
                $duplicado = $session->get('duplicado');
                if(count($duplicado) == 0){?>
                <h3>Los registros fueron adicionados correctamente</h3>
                <a href="index.php?option=com_erp&view=facturacion&layout=manual" class="btn btn-success">Volver</a>
                <? }else{?>
                <h3>Los registros fueron adicionados correctamente, a excepción de los siguientes que ya se encuentran registrados en el sistema</h3>
                <ul>
                  <? foreach($duplicado  as $d){
                      $reg = explode('||', $d);?>
                  <li>
                    <strong>Nombre:</strong> <?=$reg[0]?><br />
                    <strong>NIT:</strong> <?=$reg[1]?><br />
                    <strong>N&ordm; de factura:</strong> <?=$reg[2]?><br />
                  </li>
                  <? }?>
                </ul>
                <a href="index.php?option=com_erp&view=facturacion&layout=manual" class="btn btn-success">Volver</a>
                <? 
                $session->clear('duplicado');
                }
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>