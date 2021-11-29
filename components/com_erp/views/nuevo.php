<?php defined('_JEXEC') or die;

if(validaAcceso("Creación de facturas")){
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

function adicionaFila(){
	n++;
	var fila = '<tr id="tr_'+n+'"><td><input name="codigo_'+n+'" type="text" class="form-control" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" /><input type="hidden" name="id_producto_'+n+'" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad_'+n+'" type="text" class="form-control" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" onKeyPress="LP_data(evt)" size="5" /></td>';
    fila+= '<td><input name="detalle_'+n+'" type="text" class="form-control" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '<td><input name="precio_'+n+'" type="text" class="form-control" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8"  /></td>';
    fila+= '<td><input name="subtotal_'+n+'" type="text" class="form-control" id="subtotal_'+n+'" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
	jQuery('#detalle_lista tbody').append(fila);
	}
function eliminaFila(num){
	jQuery('#tr_'+num).remove();
	}
function buscaNit() {
	checkN++;
	setTimeout(function(){
		var nit = jQuery('#nit').val();
		
		if(checkC > 1){
			checkC--;
			return false;
		}
		jQuery('#loading_nit').fadeOut();
		jQuery('#lista_nit').slideUp();
		jQuery('#lista_nit').html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nit&tmpl=blank", {nit:nit}, function(data) {
		  var resp = data.split('||');
		  if(resp[1] > 0){
			  jQuery('#lista_nit').html(resp[0]);
			  jQuery('#loading_nit').fadeOut();
			  jQuery('#lista_nit').fadeIn();  
			  }
	    });
		checkC = 0;
		}, 1000);
	return false;
	}
function cargaNitP(nombre, nit, id, empresa){
	jQuery('#nombre').val(nombre);
	jQuery('#cliente').val(empresa);
	jQuery('#id_cliente').val(id);
	jQuery('#nit').val(nit);
	cerrarVentana('lista_nit');
	}
function buscaCliente() {
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
function cargaCliente(id, nombre){
	jQuery('#cliente').val(nombre);
	jQuery('#id_cliente').val(id);
	jQuery('#nombre').val('');
	jQuery('#nit').val('');
	jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nits&tmpl=blank", {id:id}, function(data) {
		var lista = data.split('||');
		var n = parseInt(lista[1]);
		if(n > 0){
			jQuery('#lista_nombre').html(lista[0]);
			jQuery('#loading_nombre').fadeOut();
			jQuery('#lista_nombre').fadeIn();	
			}
		jQuery('#div_aportes').slideDown();
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
			  //var respuesta = data.split('<!-- INICIO -->');
			  //var contenido = respuesta[1].split('<!-- FIN -->');
			  jQuery('#lista_producto_'+id[1]).html(data);
			  jQuery('#lista_producto_'+id[1]).fadeIn();
			});
			checkP = 0;
			}, 1000);
		return false;	
		}else{
		jQuery('#detalle_'+id[1]).val('');
		jQuery('#detalle_'+id[1]).attr('readonly', false);
		jQuery('#precio_'+id[1]).val('');
		jQuery('#precio_'+id[1]).attr('readonly', false);
		}
	}
function cargaProducto(id, id_producto, detalle, codigo, precio){
	jQuery('#codigo_'+id).val(codigo);

	jQuery('#detalle_'+id).val(detalle);
	jQuery('#detalle_'+id).attr('readonly', true);
	jQuery('#precio_'+id).val(precio);
	jQuery('#precio_'+id).attr('readonly', true);
	jQuery('#id_producto_'+id).val(id_producto);
	calcula('#codigo_'+id);
	cerrarVentana('lista_producto_'+id);
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
function calcula(varid){
	var id = varid.split('_');
	var cantidad = jQuery('#cantidad_'+id[1]).val();
	var precio = jQuery('#precio_'+id[1]).val();
	var subtotal = cantidad * precio;
	jQuery('#subtotal_'+id[1]).val(subtotal);
	calculasubtotal();
	}
function calculasubtotal(){
	var total = 0;
	for(i=0; i<=n; i++){
		if(!isNaN(jQuery('#subtotal_'+i).val()))
			total+= parseFloat(jQuery('#subtotal_'+i).val());
		}
	jQuery('#total').val(total);
	if(total > 0)
		jQuery('#enviar').fadeIn();
		else
		jQuery('#enviar').fadeOut();
	//calculatotal();
	}
function abreAportes(){ 
	var id = jQuery('#id_cliente').val();
	Shadowbox.open({ content: 'index.php?option=com_erp&view=facturacion&layout=aportes&id='+id+'&tmpl=component', width:800, height:300, player: "iframe"}); return false;
	}
function cargaCuota(mes_ini, anio_ini, mes_fin, anio_fin, cantidad, detalle, precio, total){
	jQuery('#mes_ini').val(mes_ini);
	jQuery('#anio_ini').val(anio_ini);
	jQuery('#mes_fin').val(mes_fin);
	jQuery('#anio_fin').val(anio_fin);
	jQuery('#detalle_0').val(detalle);
	jQuery('#cantidad_0').val(cantidad);
	jQuery('#precio_0').val(precio);
	jQuery('#subtotal_0').val(total);
	jQuery('#enviar').fadeIn();
	calcula();
	Shadowbox.close();
	
	}
</script>
<style>
   
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    input{width: auto !important;}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Factura - <strong>"Sucursal <?=$sucursal->nombre?>"</strong></h3>
      </div>
      <div class="box-body">
      <? 
	  if(getIdSucursalUsuarioF()){
			if($llave->fecha_limite >= $fecha_actual){
				$diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
				$diff =  $diff/(60*60*24);
				if($diff <= 14){?>
                <div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>
                <? }?>    

        <form action="index.php?option=com_erp&view=facturacion&layout=generafactura&tmpl=component" method="post" enctype="multipart/form-data" name="form" id="form"  class="form-horizontal">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   NIT <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="nit" id="nit" onkeypress="LP_data(event)" class="form-control">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nit">
                    <div id="lista_nit" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Cliente <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                   <input type="text" name="cliente" id="cliente" class="form-control" onKeyUp="buscaCliente()" title="Debe introducir un cliente*">
                    <!--<a class="btn btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="icon-plus"></em></a>-->
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div id="lista_cliente" style="height:0px; width:100%; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   A nombre de <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                   
                    <input type="text" name="nombre" id="nombre" class="form-control">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nombre">
                    <div id="lista_nombre" style="height:0px; width:100%; overflow:visible; position:absolute; z-index:10000"></div>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Fecha <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">
                    <?
                    $db =& JFactory::getDBO();
                    $query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
                    $db->setQuery($query);
                    $fec = $db->loadResult();
                    if($fec == 1)
                     echo '<input type="text" name="fecha" id="fecha" class="form-control datepicker">';
                     else
                     echo '<input type="text" name="fecha" id="fecha" class="form-control" value="'.fecha(date('Y-m-d')).'" readonly>';?>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Tipo de pago <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <select name="id_tipopago" id="id_tipopago" class="form-control">
                    	<option value=""></option>
                        <? foreach(getFormasPago() as $forma){?>
                        <option value="<?=$forma->id?>"><?=$forma->forma?></option>
                        <? }?>
                    </select>
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Cheque Nro. 
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_numero" id="cheque_numero" class="form-control">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Banco
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="cheque_banco" id="cheque_banco" class="form-control">
               </div>
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Recibí conforme
               </label>
               <div class="col-xs-12 col-sm-4">                    
                    <input type="text" name="recibi" id="recibi" value="<?=$user->name?>" readonly class="form-control">
               </div>            
            </div>          
           
           <div class="form-group" id="div_aportes" style="display:none">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                   Aportes
               </label>
               <div class="col-xs-12 col-sm-10">                    
                    <a onClick="abreAportes()" class="btn btn-info">
                    	<em class="fa fa-reorder"></em>
                        Aportes
                    </a>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2 control-label">
                  <?
                  if(countTipoFactura() > 1) echo 'Tipo <i class="fa fa-asterisk text-red"></i>';
                  ?>                   
               </label>
               <div class="col-xs-12">                   
               
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
                    <td width="20">&nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                  <tr id="tr_0">
                    <td>
                        <input name="codigo[]" type="text" class="form-control" id="codigo_0" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" />
                        <input type="hidden" name="id_producto[]" id="id_producto_0">
                        <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                    </td>
                    <td>
                        <input name="cantidad[]" type="text" class="form-control" id="cantidad_0" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" onkeypress="LP_data(event)" size="5" />
                    </td>
                    <td><input name="detalle[]" type="text" class="form-control" id="detalle_0" title="Debe introducir el detalle*" /></td>
                    <td><input name="precio[]" type="text" class="form-control" id="precio_0" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8"  /></td>
                    <td><input name="subtotal[]" type="text" class="form-control" id="subtotal_0" readonly /></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <th><input name="total" type="text" class="form-control" id="total" readonly /></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                    </td>
                  </tr>
                </tfoot>
              </table>
          </div>
          <div class="co-xs-12">
              <center>
                  <a class="btn btn-info col-xs-6 col-sm-2" onClick="adicionaFila()"><i class="fa fa-plus"></i> Agregar fila</a>
                  <button class="btn btn-success col-xs-6 col-sm-2" type="submit" id="enviar" style="display: none"><i class="fa fa-check"></i> Crear Factura</button>
              </center>
          </div>
        </form>
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