<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
$comprobante = getComprobante();
?>
<script>
var n = 0;
function saveNew(){
	jQuery('#nuevo').val(1)
	jQuery('.btn-success').trigger('click');
	}
function adicionaDetalle(){
	var fila = '<tr id="tr_' + n + '"><td><input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_' + n + '" style="width:100%" onClick="popup(this.id)"><input type="hidden" name="id[]" id="id_' + n + '"></td><td><input name="descripcion[]" type="text" class="form-control validate[required]" id="descripcion_' + n + '" style="width:100%"></td><td><input name="debe[]" type="text" class="form-control validate[required]" id="debe_' + n + '" style="width:100%; text-align:right" onKeyUp="monto(this.id)"></td><td><input name="haber[]" type="text" class="form-control validate[required]" id="haber_' + n + '" style="width:100%; text-align:right" onKeyUp="monto(this.id)"></td><td><a class="btn btn-danger" id="' + n + '" onclick="quitaDetalle(this.id)"><i class="icon-trash icon-white"></i></a></td></tr>';
	jQuery('#tabla_detalle tbody').append(fila);
	n++;
	}
function quitaDetalle(id){
	jQuery('#tr_' + id).remove();
	}
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contacuentas&layout=lista&tmpl=component&id='+id, width:600, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	
	jQuery('#codigo_' + id_html).val(codigo);
	jQuery('#descripcion_' + id_html).val(nombre);
	jQuery('#id_' + id_html).val(id);
	}
function monto(id){
	var monto = id.split('_');
	if(monto[0] == 'debe')
		jQuery('#haber_' + monto[1]).val('0');
		else
		jQuery('#debe_' + monto[1]).val('0');
	calcula()	
	}
function calcula(){
	var debe = 0;
	var haber = 0;
	for(i=0; i<n; i++){
		debe+= parseFloat(jQuery('#debe_'+i).val());
		haber+= parseFloat(jQuery('#haber_'+i).val());
		}
	jQuery('#total_debe').val(debe);
	jQuery('#total_haber').val(haber);
	if(debe == haber)
		jQuery('#envia').fadeIn();
		else
		jQuery('#envia').fadeOut();
	}
function muestraCuentas(){
	jQuery('.id_padre').fadeIn();
	}
function ocultaCuentas(){
	jQuery('.id_padre').fadeOut();
	}
function asigna(nombre, id){
	jQuery('#id_cliente_nombre').val(nombre);
	jQuery('#id_cliente').val(id);
	ocultaCuentas();
	}
function encabezado(){
	var tipo = jQuery('#tipo').val();
	if(tipo == 1 || tipo == 2){
		jQuery('#id_cliente_nombre').fadeIn();
		jQuery('#encabezado_text').fadeIn();
		if(tipo == 1)
			jQuery('#encabezado_text').html('Hemos abonado a: <i class="fa fa-asterisk text-red"></i>');
			else
			jQuery('#encabezado_text').html('Hemos recibido de: <i class="fa fa-asterisk text-red"></i>');
		}
		else{
		jQuery('#id_cliente_nombre').fadeOut();
		jQuery('#encabezado_text').fadeOut();
		}
	}
</script>
<? //$tipo = ucfirst(tipocomprobante());?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-refresh"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reversión Comprobante</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form action="" method="post" name="form" id="form" class="form-horizontal" role="form">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control_label">
                     Tipo
                 </label>
                 <div class="col-xs-12 col-sm-4">                     
                    <? foreach(getTipoComprobantes() as $tipo){
                         if($comprobante->id_tipo==$tipo->id){?>                            
                            <input type="text" name="" class="form-control" value="<?=$tipo->tipo?>" readonly>
                            <input type="hidden" name="tipo" class="form-control" value="<?=$tipo->id?>">
                    <?   }
                    }?>                        
                 </div>
                 <label for="" class="col-xs-12 col-sm-2 control_label">
                     Fecha de Creación
                 </label>
                 <div class="col-xs-12 col-sm-4">
                    <input type="text" name="fecha" class="form-control datepicker" id="fecha" value="<?=date('Y-m-d')?>" readonly>
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Tipo de Cambio
                 </label>
                 <div class="col-xs-12 col-sm-4">
                    <input name="cambio" type="text" class="form-control validate[required]" id="focusedInput" value="<?=$comprobante->tipo_cambio?>" readonly>
                 </div>
                 <label for="" class="col-xs-12 col-sm-2 control-label" id="encabezado_text"  <?=$comprobante->id_tipo<3?'':'style="display:none"'?>>
                     <? switch($comprobante->id_tipo){
                            case '1':
                            $texto = 'Hemos abonado a';
                            break;
                            case '2':
                            $texto = 'Hemos recibido de';
                            break;
                        }?>
                        <?=$texto?> 
                 </label>
                 <div class="col-xs-12 col-sm-4"  <?=$comprobante->id_tipo<3?'':'style="display:none"'?>>
                    <input type="text"  class="form-control validate[required]" readonly name="cliente_nombre" id="id_cliente_nombre" value="<?=$comprobante->cliente?>">
                 </div>
             </div>
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$comprobante->id_cliente?>" readonly>
                  <div class="id_padre" style="height:0px; overflow:visible; position:absolute; display:none; z-index:10000">
                    <div style="border:1px solid #ccc; border-radius:5px; margin-top:5px; padding:10px; background:#FFF; width:300px">
                    <table cellpadding="0" width="300" cellspacing="0" border="0" class="table table-striped table-bordered" id="tabladinamica">
                        <thead>
                            <tr>
                                <th width="30">N&ordm;</th><th>Beneficiario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $n = 1;
                            foreach(clientes() as $c){
                                if($c->empresa == '')
                                    $nombre = $c->nombre.' '.$c->apellido;
                                    else
                                    $nombre = $c->empresa;?>
                            <tr>
                                <td><?=$n?></td>
                                <td><a onClick="asigna('<?=$nombre?>','<?=$c->id?>')"><?=$nombre?></a></td>
                            </tr>
                            <? $n++;}?>
                        </tbody>
                    </table>
                      <div><a onClick="ocultaCuentas()" class="btn btn-block btn-success">Cerrar</a></div>
                    </div>
                  </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Por concepto de 
                     </label>
                     <div class="col-xs-12 col-sm-4">
                         <input name="concepto" id="concepto" type="text" class="form-control validate[required]" readonly value="Reversión al comprobante: <?=$comprobante->detalle?>">
                     </div>
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                          Gestión
                     </label>
                     <div class="col-xs-12 col-sm-4">                       
                           <? $gestion = getGestion($comprobante->id_gestion);?>
                           <input type="text" name="" class="form-control" value="<?=$gestion->gestion?>" readonly>
                           <input type="hidden" name="id_gestion" class="form-control" value="<?=$comprobante->id_gestion?>">
                     </div>
                 </div>
                 <div class="table-responsive">
                     <table class="table table-striped" id="tabla_detalle">
                          <thead>
                            <tr>
                              <th width="90">C&oacute;digo</th>
                              <th>Cuenta Contable</th>
                              <th>Detalle</th>
                              <th width="100">Debe</th>
                              <th width="100">Haber</th>
                              <th width="42"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?
                            $n = 0;
                            $total_debe = 0;
                            $total_haber = 0;
                            foreach(getComprobanteDetalle() as $detalle){
                                $total_debe+= $detalle->debe;
                                $total_haber+= $detalle->haber;
                            ?>
                            <tr id="tr_<?=$n?>">
                              <td>
                              <input name="codigo[]" readonly type="text" class="form-control validate[required]" id="codigo_<?=$n?>" style="width:100%" value="<?=$detalle->codigo?>">
                              <input type="hidden" name="id[]" id="id_<?=$n?>" value="<?=$detalle->id_cuenta?>"></td>
                              <td><input name="cuenta[]" readonly type="text" class="form-control validate[required]" id="descripcion_<?=$n?>" style="width:100%" value="<?=$detalle->cuenta?>"></td>
                              <td><input name="detalle[]" readonly type="text" class="form-control validate[required]" id="descripcion_<?=$n?>" style="width:100%" value="<?=$detalle->detalle?>"></td>
                              <td><input name="debe[]" readonly type="text" class="form-control validate[required]" id="debe_<?=$n?>" style="width:100%; text-align:right" onKeyUp="monto(this.id)" value="<?=$detalle->haber?>"></td>
                              <td><input name="haber[]" readonly type="text" class="form-control validate[required]" id="haber_<?=$n?>" style="width:100%; text-align:right" onKeyUp="monto(this.id)" value="<?=$detalle->debe?>"></td>
                              <td></td>
                            </tr>
                            <? $n++;}?>
                          </tbody>
                          <tfoot>
                          <tr>
                              <td colspan="3" style="text-align:right"><strong>Total</strong></td>
                              <td><input name="total_debe" readonly type="text" class="form-control validate[required]" id="total_debe" style="width:100%; text-align:right" value="<?=$total_debe?>"></td>
                            <td><input name="total_haber" readonly type="text" class="form-control validate[required]" id="total_haber" style="width:100%; text-align:right" value="<?=$total_haber?>"></td>
                            <td></td>
                            </tr>
                            <tr>
                              <td colspan="5">                                
                              </td>
                            </tr>
                          </tfoot>
                      </table>
                 </div>
                 <div class="col-xs-12">
                     <a class="btn btn-info col-xs-12 col-sm-3" href="index.php?option=com_erp&view=contacomprobantes"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
                    <button class="btn btn-success col-xs-12 col-sm-3 pull-right" id="envia" type="submit"><i class="fa fa-floppy-o"></i> Revertir Comprobante</button>
                 </div>
                  <script>
                  n = <?=$n?>;
                  </script>
            </form>
            <? }else{
                newCNTComprobante(1);
                ?>
                <h3>El comprobante se generó correctamente</h3>
                <p><a href="index.php?option=com_erp&view=contacomprobantes" class="btn btn-success">Volver</a></p>
                <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>