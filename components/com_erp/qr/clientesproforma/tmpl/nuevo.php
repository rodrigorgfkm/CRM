<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Proformas')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '                                  <tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="span12" id="codigo_'+n+'" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '                                <td><input name="cantidad[]" type="text" class="span12" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '                                <td><input name="detalle[]" type="text" class="span12" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '                                <td><input name="precio[]" type="text" class="span12" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '                                <td><input name="subtotal[]" type="text" class="span12" id="subtotal_'+n+'" readonly /></td>';
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
		
		jQuery.post( "index.php?option=com_erp&view=clientesproforma&layout=cliente&tmpl=component", {cliente:cliente}, function(data) {
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
function cargaCliente(id, nombre, fono, celular, email, cant){
	jQuery('#id_cliente').val(id);
	jQuery('#cliente').val(nombre);
	jQuery('#fono').val(fono);
	jQuery('#celular').val(celular);
	jQuery('#email').val(email);
	if(cant > 0){
		jQuery.post( "index.php?option=com_erp&view=clientesproforma&layout=empresa&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#empresa_campo select').html(contenido[0]);
		  jQuery('#empresa_campo').fadeIn();
		  jQuery('#empresa_titulo').fadeIn();
		  });	
		}
	<? if($ext['veh']->habilitado == 1){?>
	jQuery.post( "index.php?option=com_erp&view=clientesproforma&layout=vehiculo&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#marca').html(contenido[0]);
		  });
	<? }?>
	cerrarVentana('lista_cliente');
	}
function cargaChasis(chasis){
	var chasis = jQuery('#marca').val();
	var c = chasis.split(':');
	jQuery('#chasis').val(c[1]);
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
		
		jQuery.post( "index.php?option=com_erp&view=clientesproforma&layout=producto&tmpl=component", {codigo:codigo, id:id[1]}, function(data) {
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
		total+= parseFloat(jQuery('#subtotal_'+i).val());
	jQuery('#total').val(total);
	}
</script>

              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Nueva Proforma</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="20%">Cliente</td>
                                    <td width="30%">
                                    	<input type="text" name="cliente" id="cliente" onKeyUp="buscaCliente()">
                                        <a class="btn btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="icon-plus"></em></a>
                                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                                        <input type="hidden" name="id_cliente" id="id_cliente">
                                        <div id="lista_cliente" style="height:0px; overflow:visible; position:relative; z-index:10000"></div>
                                    </td>
                                    <td width="20%"><span id="empresa_titulo" style="display:none">Empresa</span></td>
                                    <td width="30%">
                                    	<span id="empresa_campo" style="display:none">
                                        	<select name="id_empresa" id="id_empresa">
                                            	<option value=""></option>
                                            </select>
                                        </span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Teléfono</td>
                                    <td><input type="text" name="fono" id="fono"></td>
                                    <td>Celular</td>
                                    <td><input type="text" name="celular" id="celular"></td>
                                  </tr>
                                  <tr>
                                    <td>Correo electrónico</td>
                                    <td><input type="text" name="email" id="email"></td>
                                    <td>Fecha</td>
                                    <td><input type="text" name="fecha" id="fecha" value="<?=date('d/m/Y')?>" readonly></td>
                                  </tr>
                                  <? if($ext['veh']->habilitado == 1){?>
                                  <tr>
                                    <td>Marca y modelo</td>
                                    <td>
                                    	<select name="marca" id="marca" onClick="cargaChasis()">
                                        </select>
                                    </td>
                                    <td>Chasis</td>
                                    <td><input type="text" name="chasis" id="chasis" readonly></td>
                                  </tr>
                                  <? }?>
                                </tbody>
                              </table>
                              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
                                <thead>
                                  <tr>
                                    <td width="100">Código</td>
                                    <td width="80">Cantidad</td>
                                    <td>Detalle</td>
                                    <td width="100">P. Unitario</td>
                                    <td width="100">P. Total</td>
                                    <td width="50">&nbsp;</td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr id="tr_0">
                                    <td>
                                    	<input name="codigo[]" type="text" class="span12" id="codigo_0" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" />
                                        <input type="hidden" name="id_producto[]" id="id_producto_0">
                                        <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                                    </td>
                                    <td>
                                    	<input name="cantidad[]" type="text" class="span12" id="cantidad_0" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" />
                                    </td>
                                    <td><input name="detalle[]" type="text" class="span12" id="detalle_0" title="Debe introducir el detalle*" /></td>
                                    <td><input name="precio[]" type="text" class="span12" id="precio_0" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>
                                    <td><input name="subtotal[]" type="text" class="span12" id="subtotal_0" readonly /></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                  	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total</td>
                                    <th><input name="total" type="text" class="span12" id="total" readonly /></th>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                  	<td colspan="6" style="text-align:center">
                                      <a class="btn btn-info span3" onClick="adicionaFila()">Agregar fila</a>
                                      <button class="btn btn-success span3" type="submit">Crear Proforma</button>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </form>
                            <? }else{
                                $id = newProforma();?>
                                <h3>La proforma se generó correctametne</h3>
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="20%">Cliente</td>
                                    <td width="30%">
                                    	<?=JRequest::getVar('cliente', '', 'post')?>
                                    </td>
                                    <td width="20%">Empresa</td>
                                    <td width="30%">
                                    	<?
                                        $emp = getEmpresaCliente();
										echo $emp->empresa;
										?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Teléfono</td>
                                    <td><?=JRequest::getVar('fono', '', 'post')?></td>
                                    <td>Celular</td>
                                    <td><?=JRequest::getVar('celular', '', 'post')?></td>
                                  </tr>
                                  <tr>
                                    <td>Correo electrónico</td>
                                    <td><?=JRequest::getVar('email', '', 'post')?></td>
                                    <td>Fecha</td>
                                    <td><?=JRequest::getVar('fecha', '', 'post')?></td>
                                  </tr>
                                  <? if($ext['veh']->habilitado == 1){?>
                                  <tr>
                                    <td>Marca y modelo</td>
                                    <td>
									  <?
                                      $marca = explode(':',JRequest::getVar('marca', '', 'post'));
									  echo $marca[0]
									  ?>
                                    </td>
                                    <td>Chasis</td>
                                    <td><?=JRequest::getVar('chasis', '', 'post')?></td>
                                  </tr>
                                  <? }?>
                                </tbody>
                              </table>
                              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
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
                                      <a class="btn btn-info span12" rel="shadowbox" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=clientesproforma&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
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
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientes.php' );?>
			</div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>