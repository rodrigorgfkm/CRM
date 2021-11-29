<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');
$user =& JFactory::getUser();
$id_sucursal = JRequest::getVar('id_suc', '', 'get');
$sucursal = getSucursal($id_sucursal);
//var_dump($sucursal);
if(JRequest::getVar('t', '', 'get') == 'p'){
	$cabecera = getProforma();
	$detalle = getProformaDetalle();
	$editable = 1;
}else{
	$cabecera = getNota();
	$detalle = getNotaDetalle();
	$editable = 0;
}
$dolar = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10);
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '<tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="form-control" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad[]" type="text" class="form-control" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '<td><input name="detalle[]" type="text" class="form-control" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '<td><input name="precio[]" type="text" class="form-control" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '<td><input name="subtotal[]" type="text" class="form-control" id="subtotal_'+n+'" value="0" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
	jQuery('#detalle_lista tbody').append(fila);
	}
function eliminaFila(num){
	jQuery('#tr_'+num).remove();
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
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=cliente&tmpl=component", {cliente:cliente}, function(data) {
		  jQuery('#empresa_campo').fadeOut();
		  jQuery('#empresa_titulo').fadeOut();
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#lista_cliente').html(contenido[0]);
		  jQuery('#loading_cliente').fadeOut();
		  jQuery('#lista_cliente').fadeIn();
	    });
		checkC = 0;
		}, 1000);
	return false;
}
/*function cargaCliente(id, nombre, cant, tipo){
	jQuery('#id_cliente').val(id);
	jQuery('#cliente').val(nombre);
	jQuery('#nombre').val('');
	jQuery('#nit').val('');
	if(cant > 0){
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=empresa&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#empresa_campo select').html(contenido[0]);
		  jQuery('#empresa_campo').fadeIn();
		  jQuery('#empresa_titulo').fadeIn();
		  });	
		}
	jQuery.post( "index.php?option=com_erp&view=facturacion&layout=nit&tmpl=component", {id:id}, function(data) {
		var respuesta = data.split('<!-- INICIO -->');
		var contenido = respuesta[1].split('<!-- FIN -->');
		var lista = contenido[0].split(':::');
			if(lista[1] > 0){
			jQuery('#lista_nombre').html(lista[0]);
			jQuery('#loading_nombre').fadeOut();
			jQuery('#lista_nombre').fadeIn();		
				}		
		});
	cerrarVentana('lista_cliente');
	}*/
function cargaNit(nombre, nit){
	jQuery('#nombre').val(nombre);
	jQuery('#nit').val(nit);
	cerrarVentana('lista_nombre');
	}
function buscaProducto(varid) {
	var id = varid.split('_');
	checkP++;
	setTimeout(function(){
		var codigo = jQuery('#codigo_'+id[1]).val();
		
		if(checkP > 1){
			checkP--;
			return false;
		}
		jQuery('#lista_producto_'+id[1]).fadeOut();
		jQuery('#lista_producto_'+id[1]).html('');
		
		jQuery.post( "index.php?option=com_erp&view=facturacion&layout=producto&tmpl=component", {codigo:codigo, id:id[1]}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#lista_producto_'+id[1]).html(contenido[0]);
		  jQuery('#lista_producto_'+id[1]).fadeIn();
	    });
		checkP = 0;
		}, 1000);
	return false;
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
	//calculatotal();
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Factura<h3>
      </div>
      <div class="box-body">
        <? if($llave->fecha_limite >= $fecha_actual){?>
        <? if(!$_POST){
            $diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
            $diff =  $diff/(60*60*24);
            if($diff <= 14){?>
            <div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>
            <? }
        if(JRequest::getVar('t', '', 'get') == 'n'){?>
          <div class="box-body">
              <div clas="col-xs-12">
                    <a href="index.php?option=com_erp&view=productosnotas" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Volver</a>	
              </div>
          </div>
	    <? }
          /*echo '<pre>';
            print_r($cabecera);
          echo '</pre>';*/
        ?>              
        <form method="post" action="index.php?option=com_erp&view=facturacion&layout=generafactura&tmpl=component&id_suc=<?=$sucursal->id?>" enctype="multipart/form-data" name="form" id="form" onSubmit="return verificarFormu(this);" class="form-horizontal">
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Cliente <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                <input type="text" name="cliente" id="cliente" class="form-control" title="Debe introducir un cliente*" <?=$editable!=1?'readonly':''?> value="<?=$cabecera->empresa?>">
                <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$cabecera->id_cliente?>">
                <!--<a class="btn btn-default btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="fa fa-plus"></em></a>
                <img src="components/com_erp/images/loading.gif" style="display:none" id="loading_cliente">
                <div id="lista_cliente" style="height:0px;  overflow:visible; position:absolute; z-index:10000"></div>-->
                
             </div>
         </div>
         <? if($cabecera->empresa==''){?>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Empresa
             </label>
             <div class="col-xs-12 col-sm-10">
                <span id="empresa_campo" style="display:none">
                    <select name="id_empresa" id="id_empresa" class="form-control"onChange="cambiaEmpresa()">
                        <option value=""></option>
                    </select>
                </span>
             </div>
         </div>
        <? }else{?>
            <input type="hidden" name="id_empresa" id="id_empresa" value="<?=$cabecera->id_empresa?>">
        <? }?>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 A nombre de <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?=$cabecera->empresa?>">
                <img src="components/com_erp/images/loading.gif" style="display:none" id="loading_nombre">
                 <div id="lista_nombre" style="height:0px; overflow:visible; position:absolute; z-index:10000"></div>
             </div>
         </div>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 NIT <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                  <input type="text" name="nit" id="nit" class="form-control" value="<?=$cabecera->nit?>">
                  <img src="components/com_erp/images/loading.gif"  style="display:none" id="loading_nit">
                  <div id="lista_nit" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
             </div>
         </div>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Cambio <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                  <input type="text" name="cambio" id="cambio" class="form-control validate[required]" value="<?=$dolar?>">
                  
             </div>
         </div>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Fecha <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                  <input type="text" name="fecha" id="fecha" class="form-control datepicker" value="<?=date('d/m/Y')?>" readonly>
             </div>
             <input type="hidden" name="id_origen" id="id_origen" value="<?=JRequest::getVar('id', '', 'get')?>">
                <? if(JRequest::getVar('t', '', 'get') == 'n')
                    $origen = 'Nota';
                    else
                    $origen = 'Proforma';?>
                <input type="hidden" name="origen" id="origen" value="<?=$origen?>">
         </div>         
          <div class="table-responsive">
              <table class="table table-striped table-bordered" id="detalle_lista">
                <thead>
                  <tr>
                    <td width="120">Código</td>
                    <td width="50">Cantidad</td>
                    <td>Detalle</td>
                    <td width="120">P. Unitario</td>
                    <td width="120">P. Total</td>
                    <td width="120">P. Total $us</td>
                    <? if($editable == 1){?>
                    <td>&nbsp;</td>
                    <? }?>
                  </tr>
                </thead>
                <tbody>
                  <? $n = 0;
                  $total = 0;
                  foreach($detalle as $d){
                      /*echo '<pre>';
                      print_r($d);
                      echo '</pre>';*/
                      $total+= $d->cantidad*$d->precio;?>
                  <tr id="tr_<?=$n?>">
                    <td>
                        <input name="codigo_<?=$n?>" type="text" class="form-control" id="codigo_<?=$n?>" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" value="<?=$d->codigo?>" <?=$editable!=1?'readonly':''?> />
                        <input type="hidden" name="id_producto_<?=$n?>" id="id_producto_<?=$n?>" value="<?=$d->id_producto?>">
                        <input type="hidden" name="id_ctacontable_<?=$n?>" id="id_ctacontable_<?=$n?>" value="<?=$d->id_ctacontable?>">
                        <div id="lista_producto_<?=$n?>" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                    </td>
                    <td>
                        <input name="cantidad_<?=$n?>" type="text" class="form-control" id="cantidad_<?=$n?>" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" maxlength="7" size="5" value="<?=$d->cantidad?>" <?=$editable!=1?'readonly':''?> />
                    </td>
                    <td><input name="detalle_<?=$n?>" type="text" class="form-control" id="detalle_<?=$n?>" title="Debe introducir el detalle*" value="<?=$d->detalle?>" <?=$editable!=1?'readonly':''?> /></td>
                    <td><input name="precio_<?=$n?>" type="text" class="form-control" id="precio_<?=$n?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$d->precio?>" <?=$editable!=1?'readonly':''?> /></td>
                    <td><input name="subtotal_<?=$n?>" type="text" class="form-control" id="subtotal_<?=$n?>" readonly value="<?=($d->cantidad*$d->precio)?>" /></td>
                    <td><input name="subtotald_<?=$n?>" type="text" class="form-control" id="subtotal_<?=$n?>" readonly value="<?=number_format(($d->cantidad*$d->precio)/$dolar, 2, ',', ' ')?>" /></td>
                    <? if($editable == 1){?>
                    <td><!--<a class="btn btn-danger" onclick="eliminaFila(<?=$n?>)"><em class="fa fa-trash"></em></a>--></td>
                    <? }?>
                  </tr>
                <? $n++;}
                if($cabecera->descuento>0){?>
                <tr id="tr_<?=$n?>">
                    <td>
                        <input name="codigo_<?=$n?>" type="text" class="form-control" id="codigo_<?=$n?>" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" <?=$editable!=1?'readonly':''?> value="DESC-001" />
                    </td>
                    <td>
                        <input name="cantidad_<?=$n?>" type="text" class="form-control" id="cantidad_<?=$n?>" title="Debe introducir una cantidad*" value="1" maxlength="7" size="5" <?=$editable!=1?'readonly':''?> />
                    </td>
                    <td><input name="detalle_<?=$n?>" type="text" class="form-control" id="detalle_<?=$n?>" title="Debe introducir el detalle*" value="Descuento" <?=$editable!=1?'readonly':''?> /></td>
                    <td><input name="precio_<?=$n?>" type="text" class="form-control" id="precio_<?=$n?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$cabecera->descuento?>" <?=$editable!=1?'readonly':''?> /></td>
                    <td><input name="subtotal_<?=$n?>" type="text" class="form-control" id="subtotal_<?=$n?>" readonly value="<?=$cabecera->descuento?>" /></td>
                    <td><input name="subtotald_<?=$n?>" type="text" class="form-control" id="subtotal_<?=$n?>" readonly value="<?=number_format($cabecera->descuento/$dolar, 2, ',', ' ')?>" /></td>
                    <? if($editable == 1){?>
                    <td><!--<a class="btn btn-danger" onclick="eliminaFila(<?=$n?>)"><em class="fa fa-trash"></em></a>--></td>
                    <? }?>
                  </tr>
                <? 
                    $descuento = $cabecera->descuento;
                }else{
                    $n--;
                    $descuento = 0;
                }?>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <th><input name="total" type="text" class="form-control" id="total" value="<?=$total-$descuento?>" readonly /></th>
                    <th><input name="totald" type="text" class="form-control" id="totald" value="<?=number_format(($total-$descuento)/$dolar, 2, ',', ' ')?>" readonly /></th>
                    <? if($editable == 1){?>
                    <td>&nbsp;</td>
                    <? }?>
                  </tr>                                        
                </tfoot>
              </table>
              <input type="hidden" name="cant" id="cant" value="<?=$n?>">
              <input type="hidden" name="descuento" id="descuento" value="<?=$cabecera->descuento?>">
          </div>
          <div class="col-xs-12">
              <? if($editable == 1){?>
                  <a class="btn btn-info col-md-6" onClick="adicionaFila()"><i class="fa fa-plus"></i> Agregar fila</a>
                  <? }?>
                  <button class="btn btn-success col-md-6" type="submit"><i class="fa fa-file-text-o"></i> Crear Factura</button>
          </div>
        </form>
        <script>
        /*cargaCliente('<?=$cabecera->id_cliente?>', '<?=$cabecera->cliapellido.' '.$cabecera->clinombre?>', '<?=getFacturaDatos($cabecera->id_cliente)?>','');*/
        n = <?=$n?> - 1;
        </script>
        <? }else{
            //$id = newFactura();
            }?>
        <? }else{?>
        <div class="alert alert-danger"><h3>No puede emitir facturas hasta ingresar una nueva llave de dosificación</h3></div>
        <? }?>
      </div>
    </div>
  </section>
</div>