<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
<?
                      foreach(getMesasAbiertas() as $m){?>
			          <tr>
			            <td>
							<?
                            if($m->ambiente == 'Sin ambiente')
								echo $m->mesa;
								else
								echo $m->ambiente
							?>
                        </td>
                        <td>
                        <?
						if($m->name != '')
							echo $m->name;
							else{
							$mesero = getMeseroAnterior($m->id_pedido);
							echo $mesero;
							}
						?>
                        </td>
			            <td><?=$m->mesa?></td>
                        <td><?=$m->personas?></td>
                        <td><a onClick="cargaMesa(<?=$m->id_pedido?>)" class="btn btn-success">Cargar</a></td>
                        <td>
							<? 
							if(getPedidosAtendidos($m->id_pedido) == 0){
								if($m->impreso == 1)
									echo 'Confirmar pago';
									else
									echo 'Listo para cerrar';
								}else
								echo 'Aún en atención';
								?>
                        </td>
		              </tr>
                      <? }
?>
<!-- FIN -->