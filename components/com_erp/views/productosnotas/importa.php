<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');

if(JRequest::getVar('t', '', 'get') == 'p'){
	$cabecera = getProforma();
	$detalle = getProformaDetalle();
	$editable = 1;
	}else{
	$cabecera = getNota();
	$detalle = getNotaDetalle();
	$editable = 0;
	}
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '                                  <tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="span12" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '                                <td><input name="cantidad[]" type="text" class="span12" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '                                <td><input name="detalle[]" type="text" class="span12" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '                                <td><input name="precio[]" type="text" class="span12" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '                                <td><input name="subtotal[]" type="text" class="span12" id="subtotal_'+n+'" value="0" readonly /></td>';
    fila+= '                                <td><a class="btn" onclick="eliminaFila('+n+')"><em class="icon-trash"></em></a></td></tr>';
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
function cargaCliente(id, nombre, cant, tipo){
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
	}
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
	var total = 0;
	
	jQuery('#subtotal_'+id[1]).val(subtotal);
	for(i=0; i<=n; i++)
		if(!isNaN(jQuery('#subtotal_'+i).val()))
			total+= parseFloat(jQuery('#subtotal_'+i).val());
	jQuery('#total').val(total);
	}
</script>

              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Nueva Factura</h3>
                            <? if($llave->fecha_limite >= $fecha_actual){?>
							<? if(!$_POST){
								$diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
								$diff =  $diff/(60*60*24);
								if($diff <= 14){?>
								<div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>
								<? }?>    
                            
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return verificarFormu(this); ">
                              <table class="table table-striped table-bordered datatable">
                                <tbody>
                                  <tr>
                                    <td width="20%">Cliente</td>
                                    <td width="30%">
                                    	<input type="text" name="cliente" id="cliente" onKeyUp="buscaCliente()" title="Debe introducir un cliente*" <?=$editable!=1?'readonly':''?>>
                                        <a class="btn btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="icon-plus"></em></a>
                                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                                        <input type="hidden" name="id_cliente" id="id_cliente">
                                        <div id="lista_cliente" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
                                    </td>
                                    <td width="20%"><span id="empresa_titulo" style="display:none">Empresa</span></td>
                                    <td width="30%">
                                    	<span id="empresa_campo" style="display:none">
                                        	<select name="id_empresa" id="id_empresa" onChange="cambiaEmpresa()">
                                            	<option value=""></option>
                                            </select>
                                        </span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>A nombre de</td>
                                    <td><input type="text" name="nombre" id="nombre">
                                    	<img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nombre">
                                        <div id="lista_nombre" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
                                    </td>
                                    <td>NIT</td>
                                    <td><input type="text" name="nit" id="nit">
                                    	<img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nit">
                                      <div id="lista_nit" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Fecha</td>
                                    <td><input type="text" name="fecha" id="fecha" value="<?=date('d/m/Y')?>" readonly></td>
                                    <td></td>
                                    <td><input type="hidden" name="id_origen" id="id_origen" value="<?=JRequest::getVar('id', '', 'get')?>">
                                    <? if(JRequest::getVar('t', '', 'get') == 'n')
										$origen = 'Nota';
										else
										$origen = 'Proforma';?>
                                    <input type="hidden" name="origen" id="origen" value="<?=$origen?>"></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-striped table-bordered datatable" id="detalle_lista">
                                <thead>
                                  <tr>
                                    <td width="100">Código</td>
                                    <td width="80">Cantidad</td>
                                    <td>Detalle</td>
                                    <td width="100">P. Unitario</td>
                                    <td width="100">P. Total</td>
                                    <? if($editable == 1){?>
                                    <td width="50">&nbsp;</td>
                                    <? }?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <? $n = 0;
								  $total = 0;
								  foreach($detalle as $d){
									  $total+= $d->cantidad+$d->precio;?>
                                  <tr id="tr_<?=$n?>">
                                    <td>
                                    	<input name="codigo[]" type="text" class="span12" id="codigo_<?=$n?>" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" value="<?=$d->codigo?>" <?=$editable!=1?'readonly':''?> />
                                        <input type="hidden" name="id_producto[]" id="id_producto_<?=$n?>">
                                        <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                                    </td>
                                    <td>
                                    	<input name="cantidad[]" type="text" class="span12" id="cantidad_<?=$n?>" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" maxlength="7" size="5" value="<?=$d->cantidad?>" <?=$editable!=1?'readonly':''?> />
                                    </td>
                                    <td><input name="detalle[]" type="text" class="span12" id="detalle_<?=$n?>" title="Debe introducir el detalle*" value="<?=$d->detalle?>" <?=$editable!=1?'readonly':''?> /></td>
                                    <td><input name="precio[]" type="text" class="span12" id="precio_<?=$n?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$d->precio?>" <?=$editable!=1?'readonly':''?> /></td>
                                    <td><input name="subtotal[]" type="text" class="span12" id="subtotal_<?=$n?>" readonly value="<?=($d->cantidad+$d->precio)?>" /></td>
                                    <? if($editable == 1){?>
                                    <td><a class="btn" onclick="eliminaFila(<?=$n?>)"><em class="icon-trash"></em></a></td>
                                    <? }?>
                                  </tr>
                                <? $n++;}?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                  	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total</td>
                                    <th><input name="total" type="text" class="span12" id="total" value="<?=$total?>" readonly /></th>
                                    <? if($editable == 1){?>
                                    <td>&nbsp;</td>
                                    <? }?>
                                  </tr>
                                  <tr>
                                  	<td colspan="<?=$editable==1?'6':'5'?>" style="text-align:center">
                                      <? if($editable == 1){?>
                                      <a class="btn btn-info span3" onClick="adicionaFila()">Agregar fila</a>
                                      <? }?>
                                      <button class="btn btn-success span3" type="submit">Crear Factura</button>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </form>
                            <script>
                            cargaCliente('<?=$cabecera->id_cliente?>', '<?=$cabecera->cliapellido.' '.$cabecera->clinombre?>', '<?=getFacturaDatos($cabecera->id_cliente)?>','');
							n = <?=$n?> - 1;
                            </script>
                            <? }else{
                                $id = newFactura();?>
                                <h3>La factura se generó correctametne</h3>
                              <table class="table table-striped table-bordered datatable">
                                <tbody>
                                  <tr>
                                    <td width="20%">Cliente</td>
                                    <td width="30%"><?=JRequest::getVar('cliente', '', 'post')?></td>
                                    <td width="20%"></td>
                                    <td width="30%"></td>
                                  </tr>
                                  <tr>
                                    <td>A nombre de</td>
                                    <td><?=JRequest::getVar('nombre', '', 'post')?></td>
                                    <td>NIT</td>
                                    <td><?=JRequest::getVar('nit', '', 'post')?></td>
                                  </tr>
                                  <tr>
                                    <td>Fecha</td>
                                    <td><?=date('d/m/Y')?></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table class="table table-striped table-bordered datatable" id="detalle_lista">
                                <thead>
                                  <tr>
                                    <td width="100">Código</td>
                                    <td width="80">Cantidad</td>
                                    <td>Detalle</td>
                                    <td width="100">P. Unitario</td>
                                    <td width="100">P. Total</td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <? $total = 0;
								  for($i=0; $i<count($_POST['cantidad']); $i++){
									  $total+= $_POST['precio'][$i] * $_POST['cantidad'][$i];?>
                                  <tr id="tr_0">
                                    <td><?=$_POST['codigo'][$i]?></td>
                                    <td><?=$_POST['cantidad'][$i]?></td>
                                    <td><?=$_POST['detalle'][$i]?></td>
                                    <td><?=$_POST['precio'][$i]?></td>
                                    <td><?=($_POST['precio'][$i] * $_POST['cantidad'][$i])?></td>
                                  </tr>
                                  <? }?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                  	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <th>Total</th>
                                    <td><?=$total?></td>
                                  </tr>
                                  <tr>
                                  	<td colspan="6" style="text-align:center">
                                      <a class="btn btn-info span12" rel="shadowbox" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                              <script>
							  function boton(){
								  jQuery("#imprime").trigger('click')
								  }
                              boton();
                              </script>
                                <?
                                }?>
							<? }else{?>
							<div class="alert alert-danger"><h3>No puede emitir facturas hasta ingresar una nueva llave de dosificación</h3></div>
							<? }?>
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_facturacion.php' );?>
			</div>