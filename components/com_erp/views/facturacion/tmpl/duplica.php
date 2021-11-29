<?php defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
$session = JFactory::getSession();
$ext = $session->get('extension');
$llave = getLlave();
$fecha_actual = date('Y-m-d');

$cabecera = getFactura();
$detalle = getFacturaDetalle();
$tipo = '0';
if($cabecera->id_empresa != 0 && $cabecera->id_persona != 0){
	$cliente = getCliente($cabecera->id_persona);
	$tipo = $cabecera->id_empresa;
	}
	else if($cabecera->id_empresa != 0 && $cabecera->id_persona == 0)
	$cliente = getCliente($cabecera->id_empresa);
	else
	$cliente = getCliente($cabecera->id_persona);

if($cliente->empresa == ''){
	$c = $cliente->apellido.' '.$cliente->nombre;
	$c_tipo = 'p';
	}else{
	$c = $cliente->empresa;
	$c_tipo = 'e';
	}
	
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '                            <tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '                                <td><input name="cantidad[]" type="text" class="form-control validate[required]" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '                                <td><input name="detalle[]" type="text" class="form-control validate[required]" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '                                <td><input name="precio[]" type="text" class="form-control validate[required]" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '                                <td><input name="subtotal[]" type="text" class="form-control validate[required]" id="subtotal_'+n+'" value="0" readonly /></td>';
    fila+= '                                <td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
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
function cargaCliente(id, nombre, tipo, cant){
	if(tipo == 'e')
		jQuery('#empresa_campo').html('<input type="hidden" name="id_empresa" id="id_empresa" value="'+id+'">');
		else
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
function cargaDatos(){
	cargaCliente('<?=$cliente->id?>','<?=$c?>', '<?=$c_tipo?>', '<?=$tipo?>')
	}
</script>
<style>
    input{width:auto;}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Factura</h3>		
      </div>
      <div class="box-body">
        <? if($llave->fecha_limite >= $fecha_actual){?>
        <? if(!$_POST){
            $diff = abs(strtotime($llave->fecha_limite) - strtotime($fecha_actual));
            $diff =  $diff/(60*60*24);
            if($diff <= 14){?>
            <div class="alert alert-warning"><strong>¡Atención!</strong> Su llave de dosificación fenece el <?=fecha($llave->fecha_limite)?></div>
            <? }?>    

        <form method="post" action="index.php?option=com_erp&view=facturacion&layout=generafactura&tmpl=component" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" onSubmit="return verificarFormu(this); ">
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Cliente <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="cliente" id="cliente" class="form-control validate[required]" onKeyUp="buscaCliente()" title="Debe introducir un cliente*" value="<?=$c?>">
                    <a class="btn btn-default btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="fa fa-plus"></em></a>
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div id="lista_cliente" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>                  
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Empresa <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">                    
                    <span id="empresa_campo" style="display:none">
                        <select name="id_empresa" id="id_empresa" class="form-control validate[required]" onChange="cambiaEmpresa()">
                            <option value=""></option>
                        </select>
                    </span>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  A nombre de: <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">                    
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]" value="<?=$cabecera->nombre?>">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nombre">
                    <div id="lista_nombre" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  NIT: <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">                    
                    <input type="text" name="nit" id="nit" class="form-control validate[required]" value="<?=$cabecera->nit?>">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_nit">
                  <div id="lista_nit" style="height:0px; width:0px; overflow:visible; position:absolute; z-index:10000"></div>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                  Fecha: <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">                    
                    <?
                    $db =& JFactory::getDBO();
                    $query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
                    $db->setQuery($query);
                    $fec = $db->loadResult();
                    if($fec == 1)
                     echo '<input type="text" name="fecha" id="fecha" class="form-control validate[required] datepicker">';
                     else
                     echo '<input type="text" name="fecha" id="fecha" class="form-control validate[required] datepicker" value="'.date('Y-m-d').'" readonly>';?>
              </div>
          </div>          
          <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
                <thead>
                  <tr>
                    <td width="100">Código <i class="fa fa-asterisk-text-red"></i></td>
                    <td width="80">Cantidad <i class="fa fa-asterisk-text-red"></i></td>
                    <td>Detalle <i class="fa fa-asterisk-text-red"></i></td>
                    <td width="100">P. Unitario <i class="fa fa-asterisk-text-red"></i></td>
                    <td width="100">P. Total <i class="fa fa-asterisk-text-red"></i></td>
                    <td width="20">&nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                  <? $n = 0;
                  $total = 0;
                  foreach($detalle as $d){
                      $total+= $d->cantidad*$d->precio;?>
                  <tr id="tr_<?=$n?>">
                    <td>
                        <input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_<?=$n?>" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" value="<?=$d->codigo?>" />
                        <input type="hidden" name="id_producto[]" id="id_producto_<?=$n?>">
                        <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                    </td>
                    <td>
                        <input name="cantidad[]" type="text" class="form-control validate[required]" id="cantidad_<?=$n?>" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" maxlength="7" size="5" value="<?=$d->cantidad?>" />
                    </td>
                    <td><input name="detalle[]" type="text" class="form-control validate[required]" id="detalle_<?=$n?>" title="Debe introducir el detalle*" value="<?=$d->detalle?>" /></td>
                    <td><input name="precio[]" type="text" class="form-control validate[required]" id="precio_<?=$n?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$d->precio?>" /></td>
                    <td><input name="subtotal[]" type="text" class="form-control validate[required]" id="subtotal_<?=$n?>" readonly value="<?=($d->cantidad*$d->precio)?>" /></td>
                    <td><a class="btn  btn-danger" onclick="eliminaFila(<?=$n?>)"><em class="fa fa-trash"></em></a></td>
                  </tr>
                <? $n++;}?>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <th><input name="total" type="text" class="form-control validate[required]" id="total" value="<?=$total?>" readonly /></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">                      
                    </td>
                  </tr>
                </tfoot>
              </table>
          </div>
          <div class="col-xs-12 col-sm-offset-2">
              <a class="btn btn-info col-xs-6 col-sm-3" onClick="adicionaFila()">Agregar fila</a>
                      <button class="btn btn-success col-xs-6 col-sm-3" type="submit">Crear Factura</button>
          </div>
        </form>
        <script>
        setTimeout(cargaDatos, 800);
        n = <?=$n?> - 1;
        </script>
        <? }else{
            $id = newFactura();?>
            <h3>La factura se generó correctametne</h3>
          <table class="table table-striped table-bordered dataTable">
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
                  <a class="btn btn-info col-xs-12" rel="shadowbox" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
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
  </section>
</div><?}else{vistaBloqueada();}?>