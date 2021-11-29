<?php defined('_JEXEC') or die;
$option = '';
$pedido = getPedido(JRequest::getVar('id', '', 'post'));
$total = 0;
?>
<!-- INICIO -->
<?
for($i=1; $i<=$pedido->personas; $i++){
	$option.= '<option style="font-size:25px" value="'.$i.'">'.$i.'</option>';?>
                                     <table class="table table-striped table-bordered mediaTable" id="<?=$pedido->id_mesa?>_<?=$i?>" style="margin-bottom:0px">
                                        <thead>
                                            <tr class="comensal">
                                                <th colspan="3" class="essential persist">PAX</th>
                                                <th width="60" class="essential"><?=$i?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<? foreach(getPedidoItems(JRequest::getVar('id', '', 'post'), $i) as $item){
												$adicional = 0;
												$adicionalprod = 0;
												
												if($item->complemento != ''){
													$detalle = '';
													$complemento = explode(';',$item->complemento);
													foreach($complemento as $c){
														$co = explode(':', $c);
														if($co[1] != 0){
															$adicional+= $co[2];
															$detalle.= '<br>'.$co[1];	
															}														
														}	
													}												
												
												if($item->adicional != ''){
													$detalleprod = '';
													$adicionales = explode(';',$item->adicional);
													foreach($adicionales as $a){
														$ad = explode(':', $a);
														if($ad[1]){
															$adicionalprod+= $ad[2];
															$detalleprod.= '<br>'.$ad[1];	
															}														
														}	
													}
												$subtotal = $item->cantidad * ($item->precio + $adicionalprod + $adicional);
												$total+= $subtotal;
													?>
                                            <tr id="tr_<?=$item->id?>">
                                                <td width="30">
                                                    <a class="btn btn-small btn-danger" style="padding:2px 6px" onClick="borraProducto('tr_<?=$item->id?>')">
                                                        <i class="icon-trash icon-white"></i>
                                                    </a>
                                                </td>	
                                                <td><?=$item->producto.$detalleprod.$detalle?></td>
                                                <td width="30"><?=$item->cantidad?></td>
                                                <td>
													<?=$subtotal?>
                                                    <input type="hidden" name="precio_item" class="precio_item" value="<?=$subtotal?>">
                                                </td>
                                            </tr>
                                            <? }?>
                                        </tbody>
                                    </table>
	<? }
?>
<script>
jQuery('#nombre_mesero').html('Mesero: <?=$pedido->mesero?>');
jQuery('#id_mesa').html('Mesa: <?=$pedido->mesa?>');
jQuery('#campo_mesa').val(<?=$pedido->id_mesa?>);
jQuery('#total_pedido').val(<?=$total?>);
</script>
:::<?=$option?><!-- FIN -->