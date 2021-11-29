<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Cliente Proformas') or validaAcceso('CRM Registro')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$proforma = getProforma();
if($proforma->id_empresa != 0){
	$tipo = 'e';
	}else{
	$c = getCliente($proforma->id_cliente);
	if($c->empresa == '')
		$tipo = 'p';
		else
		$tipo = 'e';
	}
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '                            <tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="form-control" id="codigo_'+n+'" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '                                <td><input name="cantidad[]" type="text" class="form-control" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '                                <td><input name="detalle[]" type="text" class="form-control" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '                                <td><input name="precio[]" type="text" class="form-control" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '                                <td><input name="subtotal[]" type="text" class="form-control" id="subtotal_'+n+'" readonly /></td>';
    fila+= '                                <td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="icon-trash icon-white"></em></a></td></tr>';
	jQuery('#detalle_lista tbody').append(fila);
	}
function eliminaFila(num){
	jQuery('#tr_'+num).remove();
	calculasubtotal();
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
		  jQuery('#tabladinamica').datatable({
					"bSort":false,
					"bFilter":false,
					"bPaginate":true,
					"iDisplayLength": 5
					});
		  //jQuery('.datatables_filter').hide();
	    });
		checkC = 0;
		}, 1000);
	return false;
}
function abrepopup(dirurl){
	Shadowbox.open({  
            content:    dirurl,
            player:     "iframe",
            width:      600,
            height:     450  
        });
	}

function cargaCliente(id, nombre, fono, celular, email, tipo, pre){
	jQuery('#id_cliente').val(id);
	jQuery('#cliente').val(nombre);
	jQuery('#fono').val(fono);
	jQuery('#celular').val(celular);
	jQuery('#email').val(email);
	jQuery('#nuevovehiculo').html('<a class="btn btn-small" onClick="abrepopup(\'index.php?option=com_erp&view=vehiculos&layout=nuevodinamico&id='+id+'&tmpl=component\')"><em class="icon-plus"></em></a>');
	jQuery('#nuevovehiculo').fadeIn();
	
	if(tipo == 'p'){
		jQuery.post( "index.php?option=com_erp&view=clientesproforma&layout=empresa&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#empresa_campo select').html(contenido[0]);
		  jQuery('#empresa_campo').fadeIn();
		  jQuery('#empresa_titulo').fadeIn();
		  jQuery('#id_empresa').val(pre);
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
function cargaDatos(option, value, chasis){
	jQuery('#marca').append(option);
	jQuery('#marca').val(value);
	jQuery('#chasis').val(chasis);
	}
function cargaChasis(){
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
/*function calculatotal(){
	var subtotal = jQuery('#total').val();
	var descuento= jQuery('#descuento').val();
	var total = subtotal - descuento;
	jQuery('#grantotal').val(total);
	}*/
function cargaDatos(){
	cargaCliente('<?=$proforma->id_cliente?>','<?=$proforma->nombre?>','<?=$proforma->fono?>','<?=$proforma->celular?>','<?=$proforma->email?>', '<?=$tipo?>', '0');
	setTimeout(cargaVehiculo, 800);
	}
function cargaVehiculo(){
	jQuery('#marca').val('<?=$proforma->vehiculo.':'.$proforma->chasis?>');
	jQuery('#chasis').val('<?=$proforma->chasis?>');
	jQuery('#id_empresa').val('<?=$proforma->id_empresa?>');
	}
</script>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Proforma</h3>
      </div>
      <div class="box-body">
          <? if(!$_POST){
                $val = explode(' ', $proforma->validez);
                $validez = $val[0];
                array_shift($val);
                $validez_tipo = implode(' ', $val);

                $ent = explode(' ', $proforma->entrega);
                $entrega = $ent[0];
                array_shift($ent);
                $entrega_tipo = implode(' ', $ent);
                ?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td width="20%">Cliente</td>
                    <td width="30%">
                        <input type="text" name="cliente" id="cliente" onKeyUp="buscaCliente()">
                        <a class="btn btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="icon-plus"></em></a>
                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                        <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$proforma->id_cliente?>">
                        <div id="lista_cliente" style="height:0px; width:0px; overflow:visible; position:relative; z-index:10000"></div>
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
                    <td><input type="text" name="fono" id="fono" class="form-control"></td>
                    <td>Celular</td>
                    <td><input type="text" name="celular" id="celular" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Correo electrónico</td>
                    <td><input type="text" name="email" id="email" class="form-control"></td>
                    <td>Fecha</td>
                    <td><input type="text" name="fecha" id="fecha" class="form-control" value="<?=date('d/m/Y')?>" readonly></td>
                  </tr>
                  <? if($ext['veh']->habilitado == 1){?>
                  <tr>
                    <td>Marca y modelo</td>
                    <td>
                        <select name="marca" id="marca" onClick="cargaChasis()" class="select2 form-control">
                        </select>
                        <span id="nuevovehiculo" style="display: none"></span>
                    </td>
                    <td>Chasis</td>
                    <td><input type="text" name="chasis" id="chasis" readonly></td>
                  </tr>
                  <? }?>
                  <tr>
                    <td>Fec. Validez</td>
                    <td>
                        <input name="validez" type="text" id="validez" size="5" maxlength="5" style="width:auto" class="form-control" value="<?=$validez?>">
                        <select name="validez_tipo" style="width:auto" class="form-control">
                            <option value="días calendario" <?=$validez_tipo=='días calendario'?'selected':''?>>Días calendario</option>
                            <option value="días hábiles" <?=$validez_tipo=='días hábiles'?'selected':''?>>Días hábiles</option>
                        </select>
                    </td>
                    <td>Fec. Entrega</td>
                    <td>
                        <input name="entrega" type="text" id="entrega" size="5" maxlength="5" style="width:auto" class="form-control" value="<?=$entrega?>">
                        <select name="entrega_tipo" style="width:auto" class="form-control">
                            <option value="Días hábiles" <?=$entrega_tipo=='días hábiles'?'selected':''?>>Días hábiles</option>
                            <option value="Días calendario" <?=$entrega_tipo=='días calendario'?'selected':''?>>Días calendario</option>
                        </select>
                    </td>
                  </tr>
                </tbody>
              </table>
              <hr />
              <table class="table table-striped table-bordered datatable" id="detalle_lista">
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
                  <? $i = 0;
                  $total = 0;
                  foreach(getProformaDetalle() as $item){
                      $subtotal = $item->precio * $item->cantidad;
                      $total+= $subtotal?>
                  <tr id="tr_<?=$i?>">
                    <td>
                        <input name="codigo[]" type="text" class="form-control" id="codigo_<?=$i?>" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" value="<?=$item->codigo?>" />
                        <input type="hidden" name="id_producto[]" id="id_producto_<?=$i?>">
                        <div id="lista_producto_<?=$i?>" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                    </td>
                    <td>
                        <input name="cantidad[]" type="text" class="form-control" id="cantidad_<?=$i?>" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" maxlength="7" size="5" value="<?=$item->cantidad?>" />
                    </td>
                    <td><input name="detalle[]" type="text" class="form-control" id="detalle_<?=$i?>" title="Debe introducir el detalle*" value="<?=$item->detalle?>" /></td>
                    <td><input name="precio[]" type="text" class="form-control" id="precio_<?=$i?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$item->precio?>" /></td>
                    <td><input name="subtotal[]" type="text" class="form-control" id="subtotal_<?=$i?>" value="<?=$subtotal?>" readonly /></td>
                    <td><a class="btn btn-danger" onclick="eliminaFila(<?=$i?>)"><em class="icon-trash icon-white"></em></a></td>
                  </tr>
                  <? $i++;
                  }?>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <th><input name="total" type="text" class="form-control" id="total" readonly value="<?=$total?>" /></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                      <a class="btn btn-info span6" onClick="adicionaFila()">Agregar fila</a>
                      <button class="btn btn-success span6" type="submit">Crear Proforma</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </form>
            <script>
                setTimeout(cargaDatos, 800);
                n = <?=$i?>;
            </script>
            <? }else{
                $id = newProforma();?>
                <h3>La proforma se generó correctametne</h3>
              <table class="table table-striped table-bordered datatable">
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
              <hr />
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
                      <a class="btn btn-info col-xs-12" rel="shadowbox" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=clientesproforma&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
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
  </section>
</div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>