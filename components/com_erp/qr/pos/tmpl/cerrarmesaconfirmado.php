<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();
$conf = getPosConfiguracion();
?>
<!-- INICIO
                    <table border="1" cellspacing="0" cellpadding="4" width="520" id="pedido" style="margin:auto">
                      <thead>
                          <tr>
                            <td align="center"><small><strong>Fecha:</strong> <?=$pedido->fecha_formato?></small></td>
                            <td width="80" align="center"><small><strong>Hora:</strong> <?=$pedido->hora_ini?></small></td>
                            <td width="70" align="center"><small><strong>Mesa:</strong> <?=$pedido->mesa?></small></td>
                            <td width="120" colspan="2" align="center"><small><strong>Mesera:</strong> <?=$pedido->mesero?></small></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center"><strong><small>Descripción</small></strong></td>
                            <td align="center"><strong><small>Cantidad</small></strong></td>
                            <td width="100" align="center"><strong><small>Precio    Unitario</small></strong></td>
                            <td width="100" align="center"><strong><small>Total</small></strong></td>
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
                                  $detalleprod.= '<br>'.$ad[0].': '.$ad[1];
                                  }
                              foreach($complemento as $c){
                                  $co = explode(':', $c);
                                  $adicional+= $co[2];
                                  $detalle.= '<br>'.$co[0].': '.$co[1];
                                  }
                              $total+= ($item->cantidad * ($item->precio + $adicionalprod + $adicional));?>
                          <tr>
                            <td colspan="2"><?=$item->producto?></td>
                            <td align="center"><?=$item->cantidad?></td>
                            <td align="right"><?=$item->precio?></td>
                            <td align="right"><?=($item->precio*$item->cantidad)?></td>
                          </tr>
                          <? }?>
                      </tbody>
                      <?
                      $impuesto = $total * $empresa->impuesto / 100;
                      $propina = JRequest::getVar('propina', '', 'post');
                      ?>
                      <tfoot>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                            <td><strong><small>Total $:</small></strong></td>
                            <td align="right"><?=$total?><input type="hidden" name="p_total" id="p_total" value="<?=$total?>"></td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                            <td><strong><small>Impuesto $:</small></strong></td>
                            <td align="right"><?=$impuesto?><input type="hidden" name="p_impuesto" id="p_impuesto" value="<?=$impuesto?>"></td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                            <td><strong><small>Prop. sugerida $:</small></strong></td>
                            <td align="right"><input type="text" name="propina" id="propina" value="<?=$propina?>" style="width:90%; text-align:right" onClick="cambiaCampo('propina')"></td>
                          </tr>
                          <tr>
                            <td colspan="3">&nbsp;</td>
                            <td><strong><small>Gran total $:</small></strong></td>
                            <td align="right"><input type="text" name="propina" id="propina" value="<?=$propina+$impuesto+$propina?>" style="width:90%; text-align:right" onClick="cambiaCampo('propina')"></td>
                          </tr>
                          <tr>
                          	<td colspan="5"><a class="btn btn-success" onClick="pideDatos()">Datos del cliente</a></td>
                          </tr>
                      </tfoot>
                    </table>
 FIN -->
<?
cierreMesa();
?>