<?php defined('_JEXEC') or die;
if(validaAcceso("Creación de facturas")){
	$llave = getLlave();
	$fecha_actual = date('Y-m-d');
	$id_sucursal = JRequest::getVar('id_suc', '', 'get');
?>
<script>
var n = 0;
var checkC = 0;
var checkP = 0;
function adicionaFila(){
	n++;
    var lim_cod = 20, lim_can = 5, lim_det = 50, lim_uni = 10;
	var fila = '<tr id="tr_'+n+'"><td><input name="codigo_'+n+'" type="text" class="form-control validate[maxSize['+lim_cod+']]" id="codigo_'+n+'" onkeyup="buscaProducto(this.id)" size="5" maxlength="20" /><input type="hidden" name="id_producto_'+n+'" id="id_producto_'+n+'"><div id="lista_producto_'+n+'" style="width:0px; height:0px; overflow:visible; position:relative; z-index:10000"></div></td>';
    fila+= '<td><input name="cantidad_'+n+'" type="text" class="form-control validate[maxSize['+lim_can+']]" id="cantidad_'+n+'" onkeyup="calcula(this.id)" value="1" maxlength="7" onKeyPress="LP_data(evt)" size="5" /></td>';
    fila+= '<td><input name="detalle_'+n+'" type="text" class="form-control validate[maxSize['+lim_det+']]" id="detalle_'+n+'" /></td>';
    fila+= '<td><input name="precio_'+n+'" type="text" class="form-control validate[maxSize['+lim_uni+']]" id="precio_'+n+'" onkeyup="calcula(this.id)" value="0" maxlength="8"  /></td>';
    fila+= '<td><input name="subtotal_'+n+'" type="text" class="form-control" id="subtotal_'+n+'" readonly /></td>';
    fila+= '<td><a class="btn btn-danger" onclick="eliminaFila('+n+')"><em class="fa fa-trash"></em></a></td></tr>';
	jQuery('#detalle_lista tbody').append(fila);
	jQuery('#filas').val(n+1);
	}
function eliminaFila(num){
	jQuery('#tr_'+num).remove();
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
			
			jQuery.post( "index.php?option=com_erp&view=facturacion&layout=producto&tmpl=component", {codigo:codigo, id:id[1]}, function(data) {
			  var respuesta = data.split('<!-- INICIO -->');
			  var contenido = respuesta[1].split('<!-- FIN -->');
			  jQuery('#lista_producto_'+id[1]).html(contenido[0]);
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

</script>
<style>
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    input{width: auto !important;}
}
</style>
<?
//validaciones
    $lim_det = 50;
    $lim_cod = 20;
    $lim_can = 5;
    $lim_deta = 50;
    $lim_uni = 10;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nueva Factura Masiva - Sucursal <?=$sucursal->nombre?></h3>
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

        <form action="index.php?option=com_erp&view=facturacionmasiva&layout=generafactura&tmpl=component" method="post" enctype="multipart/form-data" name="form" id="form"  class="form-horizontal">
          <div class="form-group">
            <label for="" class="col-xs-12 col-sm-2">
               Detalle <i class="fa fa-asterisk text-red"></i>
            </label>
            <div class="col-xs-12 col-sm-10">                   
              <input type="text" name="detalle" id="detalle" class="form-control validate[maxSize[<?=$lim_det?>]]" />
            </div>
          </div>
          <!--<div class="form-group">
            <label for="" class="col-xs-12 col-sm-2">
               Categoría <i class="fa fa-asterisk text-red"></i>
            </label>
            <div class="col-xs-12 col-sm-10">                   
              <select name="id_categoria" id="id_categoria" class="form-control">
                <option value="">Elija una categoría</option>
                <? foreach(getClientesCats() as $cat){?>
                <option value="<?=$cat->id?>" <?=$cat->id==$id_categoria?'selected':''?>><?=$cat->categoria?></option>
                <? }?>
           	  </select>
            </div>
          </div>
          <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Fecha <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">
                    <?
                    $db =& JFactory::getDBO();
                    $query = 'SELECT fecha FROM #__erp_facturacion_configuracion LIMIT 1';
                    $db->setQuery($query);
                    $fec = $db->loadResult();
                    if($fec == 1)
                     echo '<input type="text" name="fecha" id="fecha" class="form-control datepicker" readonly>';
                     else
                     echo '<input type="text" name="fecha" id="fecha" class="form-control" value="'.fecha(date('Y-m-d')).'" readonly>';?>
               </div>
           </div>-->
           <?
           if(countTipoFactura() > 1){
		   ?>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                  Tipo <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12">
                  <select name="id_factura" id="id_factura" title="Debe elegir un tipo de factura*" class="form-control">
                    <option value=""></option>
                    <? foreach(getTipoFacturas() as $tipo){
                          $tipofac = explode('|',$tipo->factura);?>
                      <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
                      <? }?>
                  </select>
               </div>
           </div>
           <? }?>
          <div class="table-responsive">
              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
                <thead>
                  <tr>
                    <td width="80">Cantidad</td>
                    <td>Detalle</td>
                    <td>Mes</td>
                    <td>Año</td>
                  </tr>
                </thead>
                <tbody>
                  <tr id="tr_0">
                    <td>
                        <input name="cantidad" style="cursor:not-allowed" type="text" readonly class="form-control" id="cantidad" value="1" maxlength="7" size="5" />
                    </td>
                    <td><input name="detalle_fact" style="cursor:not-allowed" type="text" readonly class="form-control" id="detalle_fact" value="Pago de aportes de: " /></td>
                    <td>
                    	<select name="mes" class="form-control">
                        	<? for($i=1; $i<=12; $i++){?>
                            <option value="<?=$i?>" <?=$i==date('n')?'selected':''?>><?=mes($i)?></option>
                            <? }?>
                        </select>
                    </td>
                    <td><input name="anio" type="number" class="form-control" id="anio" value="<?=date('Y')?>" /></td>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
          </div>
          <div class="co-xs-12">
              <center>
                  <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?=JRequest::getVar('id_suc', '', 'get')?>" />
                  <button class="btn btn-success col-xs-6 col-sm-2" type="submit" id="enviar"><i class="fa fa-check"></i> Crear Factura</button>
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