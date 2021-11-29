<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
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
	var fila = '<tr id="tr_'+n+'"><td><input autocomplete="off" name="codigo[]" type="text" class="form-control validate[required]" id="codigo_'+n+'" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" /><input type="hidden" name="id_producto[]" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad[]" type="text" class="form-control validate[required]" id="cantidad_'+n+'" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" /></td>';
    fila+= '<td><input name="detalle[]" type="text" class="form-control validate[required]" id="detalle_'+n+'" title="Debe introducir el detalle*" /></td>';
    fila+= '<td><input name="precio[]" type="text" class="form-control validate[required]" id="precio_'+n+'" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>';
    fila+= '<td><input name="subtotal[]" type="text" class="form-control validate[required]" id="subtotal_'+n+'" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
    //alert(fila);
	jQuery('#detalle_lista').children('tbody').append(fila);
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
		
		jQuery.post( "index.php?option=com_erp&view=productosnotas&layout=cliente&tmpl=blank", {cliente:cliente}, function(data) {
		  jQuery('#lista_cliente').html(data);
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
function cargaCliente(id, nombre, email, fono){
	jQuery('#id_cliente').val(id);
	jQuery('#cliente').val(nombre);
	jQuery('#fono').val(fono);
	jQuery('#email').val(email);
	
	cerrarVentana('lista_cliente');
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
            //alert(id[1]+' ---- '+checkP);
			jQuery('#lista_producto_'+id[1]).fadeOut();
			jQuery('#lista_producto_'+id[1]).html('');
			
            jQuery.ajax({
                url: 'index.php?option=com_erp&view=productosnotas&layout=producto&tmpl=blank',
                type: 'POST',
                data: {codigo:codigo, id:id[1]},
            })
            .done(function(data){
			  jQuery('#lista_producto_'+id[1]).html(data);
                //alert(data);
			  jQuery('#lista_producto_'+id[1]).fadeIn();
            })
			/*jQuery.post( "", {}, function(data) {
			});*/
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
function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	//jQuery('#'+id).html('');
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
</script>
<?
$lim_cli = 50;
$lim_tel = 10;
$lim_correo = 50;
$lim_cod = 10;
$lim_cant = 11;
$lim_det = 50;
$lim_uni = 11;
?>
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
                        <input type="text" autocomplete="off" name="cliente" id="cliente" class="form-control validate[required, maxSize[<?=$lim_cli?>]]" onKeyUp="buscaCliente()">
                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                        <input type="hidden" name="id_cliente" id="id_cliente">
                        <div id="lista_cliente" style=" width:100% ;height:0px; overflow:visible; position:absolute; z-index:10000"></div>                     
                 </div>
             </div>
             <div class="form-group" >
                 <label for="" class="col-xs-12 col-sm-2">
                    Teléfono <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">                        
                       <input type="number" name="fono" id="fono" class="form-control validate[required, maxSize[<?=$lim_tel?>]]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                    Correo Electrónico <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">                        
                       <input type="email" name="email" id="email" class="form-control validate[required, maxSize[<?=$lim_correo?>]]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                    Fecha <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">                        
                       <input type="text" name="fecha" id="fecha" class="form-control validate[required]" value="<?=date('d/m/Y')?>" readonly>
                 </div>
             </div><div class="table-responsive">                        
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
                      <tr id="tr_0">
                        <td>
                            <input name="codigo[]" autocomplete="off" type="text" class="form-control validate[required, maxSize[<?=$lim_cod?>]]" id="codigo_0" title="Debe introducir un item*" onkeyup="buscaProducto(this.id)" size="5" maxlength="8" />
                            <input type="hidden" name="id_producto[]" id="id_producto_0">
                            <div id="lista_producto_0" style="width:100%; height:0px; overflow:visible; position:absolute; z-index:10000"></div>
                        </td>
                        <td>
                            <input name="cantidad[]" type="text" class="form-control validate[required, maxSize[<?=$lim_cant?>]]" id="cantidad_0" title="Debe introducir una cantidad*" onkeyup="calcula(this.id)" value="1" maxlength="7" size="5" />
                        </td>
                        <td><input name="detalle[]" type="text" class="form-control validate[required, maxSize[<?=$lim_det?>]]" id="detalle_0" title="Debe introducir el detalle*" /></td>
                        <td><input name="precio[]" type="text" class="form-control validate[required, maxSize[<?=$lim_uni?>]]" id="precio_0" title="Debe introducir el precio del producto*" onkeyup="calcula(this.id)" value="0" maxlength="8" /></td>
                        <td><input name="subtotal[]" type="text" class="form-control validate[required]" id="subtotal_0" readonly /></td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Sub total Bs.</strong></td>
                        <th><input name="total" type="text" class="form-control validate[required]" id="total" readonly /></th>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Descuento Bs.</strong></td>
                        <th><input name="descuento" type="text" class="form-control validate[required]" id="descuento" onkeyup="calculatotal()" /></th>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><strong>Total Bs.</strong></td>
                        <th><input name="total" type="text" class="form-control validate[required]" id="grantotal" readonly /></th>
                        <td>&nbsp;</td>
                      </tr>                      
                    </tfoot>
                  </table>
             </div>
             <div class="col-xs-12">
                 <button type="button" class="btn btn-info col-xs-6 col-md-3" onclick="adicionaFila()"><i class="fa fa-plus"></i> Agregar fila</button>
                 <button class="btn btn-success col-xs-6 col-md-3" type="submit"><i class="fa fa-check"></i> Crear Nota<span class="hidden-xs"> de entrega</span></button>
             </div>
            </form>
            <? }else{
                $id = newNota();?>
                <h3>La nota de entrega se generó correctamente</h3>
              <table class="table table-striped table-bordered">
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
                </tbody>
              </table>
              <table class="table table-striped table-bordered">
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
                    <td style="text-align:right"><?=$_POST['precio'][$i]?></td>
                    <td style="text-align:right"><?=($_POST['precio'][$i] * $_POST['cantidad'][$i])?></td>
                  </tr>
                  <? }?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td><strong>Sub Total Bs.</strong></td>
                    <td style="text-align:right"><?=$total?></td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td><strong>Descuento Bs.</strong></td>
                    <td style="text-align:right"><?=JRequest::getVar('descuento', '', 'post')?></td>
                  </tr>
                  <tr>
                    <td colspan="3"></td>
                    <td><strong> Total Bs.</strong></td>
                    <td style="text-align:right"><?=($total - JRequest::getVar('descuento', '', 'post'))?></td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">
                      <a class="btn btn-info col-md-6" rel="shadowbox;width=800" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=productosnotas&layout=imprime&id=<?=$id?>&tmpl=component">Imprimir</a>
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
<? }else{vistaBloqueada();}?>