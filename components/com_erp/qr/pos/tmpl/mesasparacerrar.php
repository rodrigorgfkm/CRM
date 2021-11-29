<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
                              <? foreach(getMesasAbiertas() as $m){
								  if(getPedidosAtendidos($m->id_pedido) == 0){?>
                              <tr>
                                <td><?=$m->ambiente?></td>
                                <td><?=$m->name?></td>
                                <td><?=$m->mesa?></td>
                                <td><?=$m->personas?></td>
                                <td><a onClick="cargaMesa(<?=$m->id_pedido?>)" class="btn btn-success">Cerrar</a></td>
                              </tr>
                              <? }}?>
<!-- FIN -->