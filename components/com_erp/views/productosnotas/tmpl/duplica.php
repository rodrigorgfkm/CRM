<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');

$cabecera = getNota();
/*echo '<pre>';
print_r($cabecera);
echo '</pre>';*/
$detalle = getNotaDetalle();
$cliente = getCliente($cabecera->id_cliente);

?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
	var fila = '<tr id="tr_'+n+'"><td><input name="codigo[]" type="text" class="form-control" id="codigo_'+n+'" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad[]" type="text" class="form-control" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '<td><input name="detalle[]" type="text" class="form-control" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '<td><input name="precio[]" type="text" class="form-control" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '<td><input name="subtotal[]" type="text" class="form-control" id="subtotal_'+n+'" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
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
		
		jQuery.post( "index.php?option=com_erp&view=productosnotas&layout=cliente&tmpl=component", {cliente:cliente}, function(data) {
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
function abrepopup(dirurl){
	Shadowbox.open({  
            content:    dirurl,
            player:     "iframe",
            width:      600,
            height:     450  
        });
	}
function cargaCliente(id, nombre, fono, celular, email, cant){
	jQuery('#id_cliente').val(id);
	jQuery('#cliente').val(nombre);
	jQuery('#fono').val(fono);
	jQuery('#celular').val(celular);
	jQuery('#email').val(email);
	jQuery('#nuevovehiculo').html('<a class="btn btn-small" onClick="abrepopup(\'index.php?option=com_erp&view=vehiculos&layout=nuevodinamico&id='+id+'&tmpl=component\')"><em class="icon-plus"></em></a>');
	jQuery('#nuevovehiculo').fadeIn();
	
	if(cant > 0){
		jQuery.post( "index.php?option=com_erp&view=productosnotas&layout=empresa&tmpl=component", {id:id}, function(data) {
		  var respuesta = data.split('<!-- INICIO -->');
		  var contenido = respuesta[1].split('<!-- FIN -->');
		  jQuery('#empresa_campo select').html(contenido[0]);
		  jQuery('#empresa_campo').fadeIn();
		  jQuery('#empresa_titulo').fadeIn();
		  });	
		}
	<? if($ext['veh']->habilitado == 1){?>
	jQuery.post( "index.php?option=com_erp&view=productosnotas&layout=vehiculo&tmpl=component", {id:id}, function(data) {
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
function buscaProducto(varid){
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
		
		jQuery.post( "index.php?option=com_erp&view=productosnotas&layout=producto&tmpl=component", {codigo:codigo, id:id[1]}, function(data) {
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
	
	calculatotal();
	}
function calculatotal(){
	var subtotal = jQuery('#total').val();
	var descuento= jQuery('#descuento').val();
	var total = subtotal - descuento;
	jQuery('#grantotal').val(total);
	}
function cargaProforma(){
<?
if($cliente->empresa != '')
	$nombre = $cliente->empresa;
	else
	$nombre = $cliente->apellido.' '.$cliente->nombre;
?>
	cargaCliente('<?=$cliente->id?>','<?=$nombre?>','<?=$cabecera->fono?>','<?=$cabecera->celular?>','<?=$cabecera->email?>', '<?=$cabecera->id_empresa?>');
<? if($cabecera->id_empresa != 0){?>
	setTimeout(cargaEmpresaProforma, 2500);
<? }?>
	//setTimeout(cargaVehiculoProforma, 2500);
	}
function cargaEmpresaProforma(){
	jQuery('#id_empresa').val(<?=$cabecera->id_empresa?>);
	}

</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Nota de Entrega</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                        Cliente <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                       
                        <input type="text" name="cliente" id="cliente" class="form-control" onKeyUp="buscaCliente()" value="<?=$cliente->apellido.' '.$cliente->nombre?>">
                        <a class="btn btn-default btn-small" rel="shadowbox;width=600;height=400" href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component"><em class="fa fa-plus"></em></a>
                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                        <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$cabecera->id_cliente?>">
                        <div id="lista_cliente" style="height:0px; overflow:visible; position:relative; z-index:10000"></div>
                   </div>
               </div>
               <div class="form-group" id="empresa_titulo" style="display:none">
                   <label for="" class="col-xs-12 col-sm-2">
                        Empresa <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                        
                        <span id="empresa_campo" style="display:none">
                            <select name="id_empresa" id="id_empresa" class="form-control">
                                <option value=""></option>
                            </select>
                        </span>                    
                   </div>
               </div>                  
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                        Teléfono <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                        
                        <input type="text" name="fono" id="fono" class="form-control" value="<?=$cabecera->fono?>">
                   </div>
               </div>
               <div class="form-group" i>
                   <label for="" class="col-xs-12 col-sm-2">
                        Celular <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">                        
                        <input type="text" name="celular" id="celular" class="form-control" value="<?=$cabecera->celular?>">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                        Correo electrónico <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                        <input type="email" name="email" id="email" class="form-control" value="<?=$cabecera->email?>">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                        Fecha <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                        <? $f = explode('-',$cabecera->fecha);
                        $fecha = $f[2].'/'.$f[1].'/'.$f[0];?>
                        <input type="text" name="fecha" id="fecha" class="form-control datepicker" value="<?=$fecha?>" readonly>
                   </div>
               </div>               
              <div class="table-responsive">
                  <table class="table table-striped table-bordered" id="detalle_lista">
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
                      <? $n = 0;
                      $total = 0;
                  
                      foreach($detalle as $d){
                          $subtotal = $d->cantidad * $d->precio;
                          $total+= $subtotal;
                          ?>
                      <tr id="tr_<?=$n?>">
                        <td>
                            <input name="codigo[]" type="text" class="form-control" id="codigo_<?=$n?>" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" value="<?=$d->codigo?>" />
                            <input type="hidden" name="id_producto[]" id="id_producto_0">
                            <div id="lista_producto_0" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div>
                        </td>
                        <td>
                            <input name="cantidad[]" type="text" class="form-control" id="cantidad_<?=$n?>" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" maxlength="7" size="5" value="<?=$d->cantidad?>" />
                        </td>
                        <td><input name="detalle[]" type="text" class="form-control" id="detalle_<?=$n?>" title="Debe introducir el detalle*" value="<?=$d->detalle?>" /></td>
                        <td><input name="precio[]" type="text" class="form-control" id="precio_<?=$n?>" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" maxlength="8" value="<?=$d->precio?>" /></td>
                        <td><input name="subtotal[]" type="text" class="form-control" id="subtotal_<?=$n?>" value="<?=$subtotal?>" readonly /></td>
                        <td><a class="btn btn-danger" onclick="eliminaFila(<?=$n?>)"><em class="fa fa-trash"></em></a></td>
                      </tr>
                      <? $n++;
                      }?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Sub total Bs.</strong></td>
                        <td><input name="total" type="text" class="form-control" id="total"  value="<?=$total?>" readonly /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Descuento Bs.</strong></td>
                        <td><input name="descuento" type="text" class="form-control" id="descuento" onkeyup="calculatotal()" value="<?=$cabecera->descuento?>"/></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Total Bs.</strong></td>
                        <td><input name="grantotal" type="text" class="form-control" id="grantotal" value="<?=$total-$cabecera->descuento?>" readonly /></td>
                        <td>&nbsp;</td>
                      </tr>                        
                    </tfoot>
                  </table>
              </div>
              <div class="col-xs-12">
                  <button type="button" class="btn btn-info col-xs-6" onClick="adicionaFila()"><i class="fa fa-plus"></i> Agregar fila</button>
                  <button class="btn btn-success col-xs-6" type="submit"><i class="fa fa-check"></i> Crear Nota <sapn class="hidden-xs">de entrega</sapn></button>
              </div>
            </form>
            <script>
            n = <?=$n?>;
            cargaProforma();
            </script>
          <? }else{
                $id = newNota();?>
                <h3>La nota de entrega se generó correctamente</h3>
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
                    <td colspan="3">&nbsp;</td>
                    <td><strong>Sub Total Bs.</strong></td>
                    <td><?=$total?></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    <td><strong>Descuento Bs.</strong></td>
                    <td><?=JRequest::getVar('descuento', '', 'post')?></td>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    <td><strong>Total Bs.</strong></td>
                    <td><?=($total - JRequest::getVar('descuento', '', 'post'))?></td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                      <a class="btn btn-info col-xs-12" rel="shadowbox;width=800" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=productosnotas&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
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
<? }else{vistaBloqueada(); }?>