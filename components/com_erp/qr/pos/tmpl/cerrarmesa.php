<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
                    	<table class="table table-condensed table-striped" id="m_listas" data-rowlink="a">
                            <thead>
                              <tr>
                                <th>Ambiente</th>
                                <th>Mesero</th>
                                <th>Mesa</th>
                                <th>PAX</th>
                                <th width="100"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <? foreach(getMesasAbiertas() as $m){
								  if(getPedidosAtendidos($m->id_pedido) == 0){?>
                              <tr>
                                <td><?=$m->ambiente?></td>
                                <td><?=$m->name?></td>
                                <td><?=$m->mesa?></td>
                                <td><?=$m->personas?></td>
                                <td>
								<? if($m->impreso == 0){?>
                                <a onClick="cargaDatosPedido(<?=$m->id_pedido?>)" class="btn btn-success">Cerrar mesa</a>
                                <? }else{?>
                                <a onClick="cargaDatosCliente(<?=$m->id_pedido?>)" class="btn btn-warning">Confirmar pago</a>
                                <? }?>
                                </td>
                              </tr>
                              <? }}?>
                            </tbody>
                        </table>
<!-- FIN -->