<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();
$conf = getPosConfiguracion();

$pedidoT = getPedidoTotal(JRequest::getVar('id', '', 'get'));
$total = 0;
foreach($pedidoT as $p)
	$total+= ($p->precio * $p->cantidad);
?>
<style type="text/css" media="print">
#impresion td{ font-size:9px}
@page{
   margin: 20px;
}
</style>
<script>
var campo;
function cambiaCampo(id){
	campo = id;
	if(campo == "nit"){
		jQuery('.fila2').slideUp();
		jQuery('.fila3').slideUp();
		jQuery('.fila4').slideUp();
		}else{
		jQuery('.fila2').slideDown();
		jQuery('.fila3').slideDown();
		jQuery('.fila4').slideDown();
		}
	}
function teclado(num){
	var numero = jQuery('#'+campo).val();
	if(num == 'Limpiar'){
		jQuery('#'+campo).val('');
		jQuery('#prop').html('');
		}else{
		numero+= num;
		jQuery('#'+campo).val(numero);
		jQuery('#prop').html(numero);
		}
	}
function montoPagar(){
	var total = parseFloat(jQuery('#p_total').val());
	var impuesto = parseFloat(jQuery('#p_impuesto').val());
	var propina = parseFloat(jQuery('#propina').val());
	var pagar = total + impuesto + propina;
	jQuery('#gran_total').html(pagar)
	}
function imprimeBoleta(){
	var total = jQuery('#p_total').val();
	var impuesto = jQuery('#p_impuesto').val();
	var propina = jQuery('#propina').val();
	var id_pedido = jQuery('#id_pedido').val();
	jQuery('#propina').hide();
	jQuery('#prop').show();
	jQuery('#teclado_numerico').hide();
	jQuery('#boton_imprime').hide();
	jQuery.post( "index.php?option=com_erp&view=pos&layout=imprimeboleta&tmpl=component", {id:id_pedido, total:total, impuesto:impuesto, propina:propina}, function(data) {
	});
	//window.print();
	window.parent.cargaMesasListas();
	//window.parent.cerrarBoleta();
	}
</script>
<style>
#pedido td{ font-size:11px !important}
</style>
<!-- INICIO -->
				<div id="impresion">
                <div id="pedido_detalle">
                    <h5>Consumo</h5>
                    <input type="hidden" name="id_pedido" id="id_pedido" value="<?=JRequest::getVar('id', '', 'get')?>">
                    <table border="0" cellspacing="0" cellpadding="4" width="100%" id="pedido" style="margin:0">
                      <thead>
                          <tr>
                            <td style="border-bottom:1px solid #000" align="center" colspan="4"><small><strong>Fecha:</strong> <?=$pedido->fecha_formato?></small></td>
                          </tr>
      <tr>
                            <td style="border-bottom:1px solid #000" align="center" colspan="4"><small><strong>Hora:</strong> <?=$pedido->hora_ini?></small></td>
                          </tr>
      <tr>
                            <td style="border-bottom:1px solid #000" align="center" colspan="4"><small><strong>Mesa:</strong> <?=$pedido->mesa?></small></td>
                          </tr>
      <tr>
                            <td style="border-bottom:1px solid #000" align="center" colspan="4"><small><strong>Mesera:</strong> <?=$pedido->mesero?></small></td>
                          </tr>
                          <tr>
                            <td style="border-bottom:1px solid #000" align="center"><strong><small>Desc.</small></strong></td>
                            <td style="border-bottom:1px solid #000" align="center"><strong><small>Cant.</small></strong></td>
                            <td style="border-bottom:1px solid #000" width="70" align="center"><strong><small>P.    Unit.</small></strong></td>
                            <td style="border-bottom:1px solid #000" width="70" align="center"><strong><small>Total</small></strong></td>
                          </tr>
                      </thead>
                      <tbody>
                          <? $total = 0;
                          foreach(getPedidoItems(JRequest::getVar('id', '', 'get'), 0, 'A') as $item){
                              $detalle = '';
                              $detalleprod = '';
                              $complemento = explode(';',$item->complemento);
                              $adicionales = explode(';',$item->adicional);
                              $adicional = 0;
                              $adicionalprod = 0;
                              foreach($adicionales as $a){
                                  $ad = explode(':', $a);
                                  $adicionalprod+= $ad[2];
                                  $detalleprod.= '<br>'.$ad[1];
                                  }
                              foreach($complemento as $c){
                                  $co = explode(':', $c);
                                  $adicional+= $co[2];
                                  $detalle.= '<br>'.$co[1];
                                  }
                              $total+= ($item->cantidad * ($item->precio + $adicionalprod + $adicional));?>
                          <tr>
                            <td style="border-bottom:1px solid #000"><?=$item->producto?></td>
                            <td style="border-bottom:1px solid #000" align="center"><?=$item->cantidad?></td>
                            <td style="border-bottom:1px solid #000" align="right"><?=round($item->precio)?></td>
                            <td style="border-bottom:1px solid #000" align="right"><?=($item->precio*$item->cantidad)?></td>
                          </tr>
                          <? }?>
                      </tbody>
                      <?
					  if($empresa->impuesto_incluye == 0)
                      	$impuesto = $total * $empresa->impuesto / 100;
						else
						$impuesto = 0;
                      $propina = $total * $empresa->propina / 100;
					  $propina = (round($propina / 100)) * 100;
                      ?>
                      <tfoot>
                          <tr>
                            <td style="border-bottom:1px solid #000; text-align:right" colspan="3"><strong><small>Total $:</small></strong></td>
                            <td style="border-bottom:1px solid #000" align="right"><?=$total?><input type="hidden" name="p_total" id="p_total" value="<?=$total?>"></td>
                          </tr>
                          <? if($empresa->impuesto_incluye == 0){?>
                          <tr>
                            <td style="border-bottom:1px solid #000; text-align:right" colspan="3"><strong><small>Impuesto $:</small></strong></td>
                            <td style="border-bottom:1px solid #000" align="right"><?=$impuesto?><input type="hidden" name="p_impuesto" id="p_impuesto" value="<?=$impuesto?>"></td
                          ></tr>
                          <? }else{?>
						  <tr>
                            <td colspan="4" style="margin:0; padding:0"><input type="hidden" name="p_impuesto" id="p_impuesto" value="0"></td>
                          </tr>
						  <? }?>
                          <tr>
                            <td style="border-bottom:1px solid #000; text-align:right" colspan="3"><strong><small>Propina sugerida</small></strong></td>
                            <td style="border-bottom:1px solid #000" align="right"><?=$propina?><input type="hidden" name="propina" id="propina" value="<?=$propina?>"></td>
                          </tr>
                          <tr>
                            <td style="border-bottom:1px solid #000; text-align:right" colspan="3"><strong><small>Gran total $:</small></strong></td>
                            <td style="border-bottom:1px solid #000" align="right"><span id="gran_total"><?=$total+$impuesto+$propina?></span></td>
                          </tr>
                          <tr>
                          	<td colspan="4" style="text-align:center"><a class="btn btn-success" id="boton_imprime" onClick="imprimeBoleta()">Imprimir boleta</a></td>
                          </tr>
                      </tfoot>
                    </table>
                </div>
                </div>
<!-- FIN -->