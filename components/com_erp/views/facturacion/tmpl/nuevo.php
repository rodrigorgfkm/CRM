<?php 
defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	/* compruebaLlave(); */
	$user =& JFactory::getUser();
	$llave = getLlave();
	$fecha_actual = date('Y-m-d');
	$id_sucursal = JRequest::getVar('id_suc', '', 'get');
	$sucursal = getSucursal($id_sucursal);
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
var checkN = 0;
var lim_cod = 20, lim_can = 5, lim_det = 240, lim_uni = 10;
function adicionaFila(){
	n++;
	var fila = '<tr id="tr_'+n+'"><td><input name="codigo_'+n+'" type="text" class="form-control validate[maxSize['+lim_cod+']]" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" /><input type="hidden" name="id_producto_'+n+'" id="id_producto_'+n+'"><input type="hidden" name="id_ctacontable_'+n+'" id="id_ctacontable_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:absolute; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad_'+n+'" type="text" class="form-control validate[required, maxSize['+lim_can+']] cantidad" id="cantidad_'+n+'" title="Debe introducir una cantidad*" value="1" maxlength="7" size="5" /></td>';
    fila+= '<td><input name="detalle_'+n+'" type="text" class="form-control validate[required, maxSize['+lim_det+']]" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '<td><input name="precio_'+n+'" type="text" class="form-control validate[required, maxSize['+lim_uni+']]" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id, this.value)" value="0" maxlength="10"  /></td>';
    fila+= '<td><input name="subtotal_'+n+'" type="text" class="form-control" id="subtotal_'+n+'" readonly /></td>';
    fila+= '<td><input name="subtotald_'+n+'" type="text" class="form-control dolar" id="subtotald_'+n+'" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
	jQuery('#detalle_lista tbody').append(fila);
	jQuery('#cant').val(n);
	}
function eliminaFila(num){
    n--;
	jQuery('#tr_'+num).remove();
	calcula('precio_0');
    jQuery('#totald').val((jQuery('#total').val()/jQuery('#cambio').val()).toFixed(2));
    jQuery('#cant').val(n);
	}
function buscaNit(){
	checkN++;
	setTimeout(function(){
		var nit = jQuery('#nit').val();
		
		if(checkN > 1){
			checkN--;
			return false;
		}
		jQuery('#loading_nit').fadeOut();
		jQuery('#lista_nit').slideUp();
		jQuery('#lista_nit').html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nit&tmpl=blank", {nit:nit}, function(data) {
		  var resp = data.split('||');
         //alert(resp[1]);
		  if(resp[1] > 0){
			  jQuery('#lista_nit').html(resp[0]);
			  jQuery('#loading_nit').fadeOut();
			  jQuery('#lista_nit').fadeIn();
              jQuery('.div_aportes').slideDown();
			  }
	    });
		checkN = 0;
		}, 1000);
	return false;
}
/* function cargaNitP(nombre, nit, id, empresa){
	jQuery('#nombre').val(nombre);
	jQuery('#cliente').val(empresa);
	jQuery('#id_cliente').val(id);
	jQuery('#nit').val(nit);
	cerrarVentana('lista_nit');
	} */
function buscaCliente(){
	checkC++;
	setTimeout(function(){
		var cliente = jQuery('#cliente').val();
		
		if(checkC > 1){
			checkC--;
			return false;
		}
		jQuery('#loading_cliente').fadeOut();
		jQuery('#lista_cliente').slideUp();
		jQuery('#lista_cliente').html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=cliente&tmpl=blank", {cliente:cliente}, function(data) {
		  jQuery('#empresa_campo').fadeOut();
		  jQuery('#empresa_titulo').fadeOut();
		  jQuery('#lista_cliente').html(data);
		  jQuery('#loading_cliente').fadeOut();
		  jQuery('#lista_cliente').fadeIn();
	    });
		checkC = 0;
		}, 1000);
	return false;
	}
function cargaCliente(id, nombre, registro, categoria, estado){
	jQuery('#cliente').val(nombre);
	jQuery('#id_cliente').val(id);
	jQuery('#nombre').val('');
	jQuery('#nit').val('');
	jQuery('#registro').val(registro);
	jQuery('#categoria').val(categoria);
	jQuery('#estado').val(estado);
	jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nits&tmpl=blank", {id:id}, function(data) {
		var lista = data.split('||');
		var n = parseInt(lista[1]);
		if(n > 0){
			jQuery('#lista_nombre').html(lista[0]);
			jQuery('#loading_nombre').fadeOut();
			jQuery('#lista_nombre').fadeIn();	
			}
		jQuery('.div_aportes').slideDown();
		});
	cerrarVentana('lista_cliente');
	}
function cargaNit(nombre, nit){
	jQuery('#nombre').val(nombre);
	jQuery('#nit').val(nit);
	cerrarVentana('lista_nombre');
	}
function buscaProducto(varid) {
	var id = varid.split('_');
	var codigo = jQuery('#codigo_'+id[1]).val();
	checkP++;
	if(codigo != ''){
		setTimeout(function(){
			if(checkP > 1){
				checkP--;
				return false;
			}
			jQuery('#lista_producto_'+id[1]).fadeOut();
			jQuery('#lista_producto_'+id[1]).html('');
			
			jQuery.post( "index.php?option=com_erp&view=facturacion&layout=producto&tmpl=blank", {codigo:codigo, id:id[1]}, function(data) {
			  jQuery('#lista_producto_'+id[1]).html(data);
			  jQuery('#lista_producto_'+id[1]).fadeIn();
			});
			checkP = 0;
			}, 1000);
		return false;	
		}else{
		jQuery('#detalle_'+id[1]).val('');
		//jQuery('#detalle_'+id[1]).attr('readonly', false);
		jQuery('#precio_'+id[1]).val('');
		//jQuery('#precio_'+id[1]).attr('readonly', false);
		}
	}
function cargaProducto(id, id_producto, detalle, codigo, precio, id_cta){
	jQuery('#codigo_'+id).val(codigo);
    //alert(jQuery('#precio_'+id).attr('id'));
	//jQuery('#precio_'+id).val(precio);
	jQuery('#detalle_'+id).val(detalle);
	//jQuery('#detalle_'+id).attr('readonly', true);
    //var ccc = 0;
    //alert(jQuery('#precio_'+id).val());
    //if(jQuery('#precio_'+id).val()==null){// & ccc<=5){
        //ccc++;
        var price = precio;
        //alert('Es Nulo debe de cambiar');
        jQuery('#detalle_'+id).parent().next().children().val(price);
        //jQuery('#detalle_'+id).parent().next().children().attr('readonly', true);
    //}
    //jQuery('#precio_'+id).val(precio);
	//jQuery('#precio_'+id).attr('readonly', true);
	jQuery('#id_producto_'+id).val(id_producto);
	jQuery('#id_ctacontable_'+id).val(id_cta);
	calcula('#codigo_'+id, precio);
	cerrarVentana('lista_producto_'+id);
    /*jQuery('#detalles').append('<br>ID: '+id+'<br>ID Producto: '+id_producto+'<br>Detalle: '+detalle+'<br>Codigo: '+codigo+'<br>Precio: '+precio+'<br>Cuenta: '+id_cta);
    jQuery('#detalles').append('<br>PRECIO CARGA: '+jQuery('#precio_'+id).val());
    jQuery('#detalles').append('<br>Precio BUSQUEDA: '+precio);
	jQuery('#detalles').append('<br>ID PRECIO: '+jQuery('#precio_'+id).attr('id')+'<br><<<-------->>>');*/
	}
function cambiaEmpresa(){
	var id = jQuery('#id_empresa').val();
	if(id != 0){
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=empresanit&tmpl=component", {id:id}, function(data) {
			var respuesta = data.split('<!-- INICIO -->');
			var contenido = respuesta[1].split('<!-- FIN -->');
			var valores = contenido[0].split(':::');
			jQuery('#nombre').val(valores[0]);
			jQuery('#nit').val(valores[1]);
			});
		}
	}
function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	jQuery('#'+id).html('');
	}
function calcula(varid, precio_td){
    //alert(precio_td);
	var id = varid.split('_');
	var cantidad = jQuery('#cantidad_'+id[1]).val();
	var precio = precio_td;
	var subtotal = cantidad * precio;
	jQuery('#subtotal_'+id[1]).val(subtotal);
	jQuery('#subtotald_'+id[1]).val(parseFloat(subtotal/jQuery('#cambio').val()).toFixed(2));
	calculasubtotal();
	}
function calculasubtotal(){
	var total = 0, totald = 0;
	for(i=0; i<=n; i++){
		if(!isNaN(jQuery('#subtotal_'+i).val()))
			total+= parseFloat(jQuery('#subtotal_'+i).val());
			//totald+= parseFloat(jQuery('#subtotald_'+i).val());
		}
	jQuery('#total').val(total);
	jQuery('#totald').val((total/jQuery('#cambio').val()).toFixed(2));
	if(total > 0)
		jQuery('#enviar').fadeIn();
		else
		jQuery('#enviar').fadeOut();
	calculatotal();
	}
/* function abreAportes(){ 
	var id = jQuery('#id_cliente').val();
	Shadowbox.open({ content: 'index.php?option=com_erp&view=facturacion&layout=aportes&id='+id+'&tmpl=component', width:800, height:300, player: "iframe"}); return false;
	}
function abreCuotas(){ 
	var id = jQuery('#id_cliente').val();
	Shadowbox.open({ content: 'index.php?option=com_erp&view=clientesaportes&layout=cuotas&id='+id+'&tmpl=component',  width:900, height:500, player: "iframe"}); return false;
	} */
/* function cargaCuota(mes_ini, anio_ini, mes_fin, anio_fin, cantidad, detalle, precio, total, id_cta){
	//alert(mes_ini+' '+anio_ini+' '+mes_fin+' '+anio_fin+' '+cantidad+' '+detalle+' '+precio+' '+total+' '+id_cta);
    
	jQuery('#mes_ini').val(mes_ini);
	jQuery('#anio_ini').val(anio_ini);
	jQuery('#mes_fin').val(mes_fin);
	jQuery('#anio_fin').val(anio_fin);
	jQuery('#detalle_0').val(detalle);
	jQuery('#cantidad_0').val(cantidad);
	jQuery('#precio_0').val(precio);
    jQuery('#subtotal_0').val(total);
	jQuery('#enviar').fadeIn();
	jQuery('#id_ctacontable_0').val(id_cta);
	jQuery('#id_producto_0').val('1');
	
	calcula('precio_0', precio);
	Shadowbox.close();
	} */
/* function cambiaCheque(){
	var tipo = jQuery('#id_tipopago').val();
	if(tipo == 2)
		jQuery('#div_cheque').slideDown();
		else
		jQuery('#div_cheque').slideUp();
	} */
/* jQuery(document).on('ready', function(){
    jQuery('body').on('change', '#cambio', function(){
    var cantags = jQuery('#cant').val();
    var nuevovalor;
    var cambiod = jQuery(this).val();
    var total_d = 0;
        for(i=0;i<=cantags;i++){
            nuevovalor = parseFloat(jQuery('#subtotal_'+i).val()/cambiod).toFixed(2);
            jQuery('#subtotald_'+i).val(nuevovalor);
            total_d = (parseFloat(total_d)+parseFloat(nuevovalor));
        }
        jQuery('#totald').val(total_d.toFixed(2));
        //alert(cambiod+'   '+nuevovalor);
    })
    jQuery('table').on('keyup','.cantidad', function(){
        var total_t = 0;
        var suma = 0;
        var cantags = jQuery('#cant').val();
        var id_cant = jQuery(this).attr('id');
        var strin = id_cant.split('_');       
        jQuery('#subtotal_'+strin[1]).val(jQuery('#precio_'+strin[1]).val()*jQuery(this).val());
        //alert(cantags);
        for(i=0;i<=cantags;i++){
            suma = jQuery('#subtotal_'+i).val();
            //alert(suma);
            total_t = parseInt(suma)+parseInt(total_t);
        }
        var nuevovalor;
        var total_d = 0;
        var cambiod = jQuery('#cambio').val();
        for(i=0;i<=cantags;i++){
            nuevovalor = parseFloat(jQuery('#subtotal_'+i).val()/cambiod).toFixed(2);
            jQuery('#subtotald_'+i).val(nuevovalor);
            total_d = (parseFloat(total_d)+parseFloat(nuevovalor));
        }
        jQuery('#totald').val(total_d.toFixed(2));
        jQuery('#total').val(total_t);
    })
}) */
</script>
<style>
   
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {
/*input{width: auto !important;}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">
        	Nueva Factura - 
            <strong>"Sucursal <?=$sucursal->nombre?>"</strong>
            <a href="index.php?option=com_erp&view=facturacion&layout=sucursal&c=1" class="btn btn-info btn-xs">
            	<em class="fa fa-exchange"></em>
                Cambiar de Sucursal
            </a>
        </h3>
      </div>
      <div class="box-body">
      <? 
	  if(getIdSucursalUsuarioF()){
          /* echo $llave->fecha_limite .'/'. $fecha_actual; */
			if($llave->fecha_limite >= $fecha_actual){
				$diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
				$diff =  $diff/(60*60*24);
				if($diff <= 14){?>
                <div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>
                <? }?>    
<?
//validaciones
$lim_nit = 20;
$lim_asoc = 50;
$lim_fac = 200;
$lim_tipo = 10;
$lim_chq = 15;
$lim_banco = 40;
$lim_cod = 20;
$lim_can = 5;
$lim_det = 240;
$lim_uni = 10;
?>
        <form action="index.php?option=com_erp&view=facturacion&layout=generafactura&tmpl=component&id_suc=<?=JRequest::getVar('id_suc', '', 'get')?>"  method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   NIT <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="nit" id="nit" class="form-control validate[required,maxSize[<?=$lim_nit?>]]" onkeyup="buscaNit()">
                    <input type="hidden" name="cant" id="cant" value="0">
                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?=$id_sucursal?>">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nit">
                    <div id="lista_nit" style="max-height:350px; width:630px; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Asociado
               </label>
               <div class="col-xs-12 col-sm-4">
                    <input type="text" name="cliente" id="cliente" class="form-control validate[maxSize[<?=$lim_asoc?>]]" onKeyUp="buscaCliente()">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div id="lista_cliente" style="height:0px; width:100%; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Facturar a nombre de <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                   
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required,maxSize[<?=$lim_fac?>]]">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nombre">
                    <div id="lista_nombre" style="height:0px; width:100%; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
                   <label for="" class="col-xs-12 col-sm-2 control-label">
                       Fecha
                   </label>
                   <!-- <div class="col-xs-12 col-sm-4">
                        <?
                       /*  $db =& JFactory::getDBO();
                        $query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
                        $db->setQuery($query);
                        $fec = $db->loadResult();
                        if($fec == 1)
                         echo '<input type="text" name="fecha" id="fecha" class="form-control datepicker">';
                         else
                         echo '<input type="text" name="fecha" id="fecha" class="form-control" value="'.fecha(date('Y-m-d')).'" readonly>'; */?>
                   </div> -->
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Forma de pago <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <select name="id_tipopago" id="id_tipopago" onChange="cambiaCheque()" class="form-control validate[required]">
                    	<option value=""></option>
                        <? foreach(getFormasPago() as $forma){?>
                        <option value="<?=$forma->id?>"><?=$forma->forma?></option>
                        <? }?>
                    </select>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Tipo de cambio  <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cambio" id="cambio" class="form-control validate[required, maxSize[<?=$lim_tipo?>]]" value="<?=readXML("https://www.bcb.gob.bo/rss_bcb.php", 10)?>">
               </div>
           </div>
           <div class="form-group" id="div_cheque" style="display:none">
           	   <label for="" class="col-xs-12 col-sm-2 control-label">
                   Cheque Nro. 
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_numero" id="cheque_numero" class="form-control validate[maxSize[<?=$lim_chq?>]]">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Banco
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_banco" id="cheque_banco" class="form-control maxSize[<?=$lim_banco?>]">
               </div>
            </div>
           <div class="form-group">
               <!--<label for="" class="col-xs-12 col-sm-2 control-label">
                   Recibí conforme <i class="fa fa-asterisk" style="color:red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="recibi" id="recibi" value="<?=$user->name?>" class="form-control" readonly>
               </div>-->
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Fecha de reporte
               </label>
               <div class="col-xs-12 col-sm-4">
               	    <?
                    $fec_rep = (date('d')+1).'-'.date('m-Y');
					?>
                    <input type="text" name="fecha_reporte" id="fecha_reporte" class="form-control datepicker" value="<?=$fec_rep?>">
               </div>
           </div>
           <div class="form-group div_aportes" style="display:none">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Cuotas
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <a onClick="abreAportes()" class="btn btn-info">
                    	<em class="fa fa-reorder"></em>
                        Abrir cuotas pendientes
                    </a>
                    <button type="button" class="btn btn-success" onclick="abreCuotas()"><i class="fa fa-money"></i> Ver Aportes</button>
                    <input type="hidden" name="mes_ini" id="mes_ini">
                    <input type="hidden" name="anio_ini" id="anio_ini">
                    <input type="hidden" name="mes_fin" id="mes_fin">
                    <input type="hidden" name="anio_fin" id="anio_fin">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Número de registro CNC
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="registro" id="registro"  readonly class="form-control">
               </div>
           </div>
           <div class="form-group div_aportes" style="display:none">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Categoría
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="categoria" id="categoria"  readonly class="form-control">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Estado
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="estado" id="estado"  readonly class="form-control">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  <?
                  if(countTipoFactura() > 1) echo 'Tipo <i class="fa fa-asterisk text-red"></i>';
                  ?>                   
               </label>
               <div class="col-xs-12 col-sm-4 col-md-4">
                  <? if(countTipoFactura() > 1){?>
                  <select name="id_factura" id="id_factura" title="Debe elegir un tipo de factura*" class="form-control">
                    <option value=""></option>
                    <? foreach(getTipoFacturas() as $tipo){
                          $tipofac = explode('|',$tipo->factura);?>
                      <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
                      <? }?>
                  </select>
                  <? }?>
               </div>
           </div>
          <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
                <thead>
                  <tr>
                    <td width="100">Código</td>
                    <td width="80">Cantidad</td>
                    <td>Detalle</td>
                    <td width="100">P. Unitario</td>
                    <td width="100">P. Total</td>
                    <td width="100">P. Total $us</td>
                    <td width="20">&nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                  <tr id="tr_0">
                    <td>
                        <input name="codigo_0" type="text" class="form-control validate[maxSize[<?=$lim_cod?>]]" id="codigo_0" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" />
                        <input type="hidden" name="id_producto_0" id="id_producto_0">
                        <input type="hidden" name="id_ctacontable_0" id="id_ctacontable_0">
                        <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:absolute; z-index:10000"></div>
                    </td>
                    <td>
                        <input name="cantidad_0" type="text" class="form-control validate[required, maxSize[<?=$lim_can?>]] cantidad" id="cantidad_0" value="1" maxlength="7" size="5" />
                    </td>
                    <td><input name="detalle_0" type="text" class="form-control validate[required, maxSize[<?=$lim_det?>]]" id="detalle_0" /></td>
                    <td><input name="precio_0" type="text" class="form-control validate[required]" id="precio_0" onkeyup="calcula(this.id, this.value)" value="0" maxlength="8"/></td>
                    <td><input name="subtotal_0" type="text" class="form-control" id="subtotal_0" readonly /></td>
                    <td><input name="subtotald_0" type="text" class="form-control dolar" id="subtotald_0" readonly /></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Total</b></td>
                    <th><input name="total" type="text" class="form-control" id="total" readonly /></th>
                    <th><input name="totald" type="text" class="form-control dolar" id="totald" readonly /></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                    </td>
                  </tr>
                </tfoot>
              </table>
          </div>
          <div class=" col-md-6 col-sm-12">
              <center>
                  <a class="btn btn-info btn-block" onClick="adicionaFila()"><i class="fa fa-plus"></i> Agregar fila</a>
              </center>
          </div>
          <div class=" col-md-6 col-sm-12">
              <center>
                  <button class="btn btn-success btn-block" type="submit" id="enviar" style="display: none"><i class="fa fa-check"></i> Crear Factura</button>
              </center>
          </div>
        </form>
        <div id="detalles"></div>
        	<? }else{?>
            <div class="alert alert-danger"><h3>No puede emitir facturas hasta ingresar una nueva llave de dosificación.</h3></div>
        <? 
			}
		}else{
			$suc = getSucursal($id_sucursal)?>
		<div class="alert alert-danger">
            <h3>Actualmente usted no puede emitir facturas para la sucursal <strong>"<?=$suc->nombre?>".</h3>
        </div>
		<? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}    
?>