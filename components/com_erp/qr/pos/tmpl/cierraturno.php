<?php defined('_JEXEC') or die;
$t = getTurnoActivo()?>
<!-- INICIO --><?=date('h:i:s')?>
                  <div class="row-fluid" id="turnosdisponibles" style=" margin-bottom:15px">
                  	<div class="span8">
						<? 
						$turnoactivo = getTurnoActivo();?>
						<a class="btn btn-info span6" id="turno_<?=$turnoactivo->id?>" style="font-size:20px;padding: 10px 6px">
                            <span style="display:block"><?=$turnoactivo->turno?></span>
                            <small style="font-size:12px">
                              <?=$turnoactivo->hora_inicio.' - '.$turnoactivo->hora_fin?>
                            </small>
                          </a>
						<? foreach(getTurnosDisponibles() as $turno){
							if($turno->estado == 1)
								$class = 'success';
								else
								$class = 'danger';
							$script = 'onclick="cambiaTurno('.$turno->id.')"';
							?>
                          <a class="btn btn-<?=$class?> span6" id="turno_<?=$turno->id?>" <?=$script?> style="font-size:20px;padding: 10px 6px">
                            <span style="display:block"><?=$turno->turno?></span>
                            <small style="font-size:12px">
                              <?=$turno->hora_inicio.' - '.$turno->hora_fin?>
                            </small>
                          </a>
                          <? }
						  ?>
                    </div>
                    <div class="span4">
                    	<a class="btn btn-warning span12" id="cerrarturno" onclick="cerrarturno()" style="font-size:20px;padding: 10px 6px; display: none">
                            <span style="display:block">Cerrar turno</span>
                            <small style="font-size:12px">
                              <?=$turnoactivo->turno?>
                            </small>
                        </a>
                    </div>
                  </div>
                  <table class="table table-condensed table-striped" data-rowlink="a">
			        <thead>
			          <tr>
			            <th>Ambiente</th>
			            <th>Mesa</th>
                        <th>PAX</th>
                        <th width="230">Mesero</th>
		              </tr>
		            </thead>
			        <tbody>
                      <? $n = 0;
					  $cont = 0;
					  $js = '';
					  foreach(getMesasAbiertas() as $m){
						  $js.= '
turno_meseros['.$n.'] = jQuery("#turnomesero_'.$m->id_pedido.'").val()+"_"+'.$m->id_pedido.';';
						  $n++; ?>
			          <tr id="turno_<?=$m->id_pedido?>">
			            <td><?=$m->ambiente?></td>
			            <td><?=$m->mesa?></td>
                        <td><?=$m->personas?></td>
                        <td class="mesero">
							<?
                            if($m->name != '')
								echo $m->name;
								else{
								$cont++;
								$mesero = getMeseroAnterior($m->id_pedido);
								echo $mesero;
								echo '<select name="turnomesero_'.$m->id_pedido.'" id="turnomesero_'.$m->id_pedido.'">
									<option style="font-size:25px" value="0">Asignar mesero</option>';
								foreach(getMeseros() as $me){
									echo '<option style="font-size:25px" value="'.$me->id.'">'.$me->name.'</option>';
									}
								echo '</select>';
								}
							?>
                        </td>
		              </tr>
                      <? }?>
		            </tbody>
		          </table>
                   <? 
				   if($n == 0){?>
				   <script>
				  	jQuery('#cerrarturno').show()
				   </script>
				   <? }else{?>
                  <div class="modal-footer" id="boton_producto">
                	<input type="hidden" name="id_turno" id="id_turno">
                    <a class="close btn btn-success " id="btnconfirma" onClick="guardamesero(); confirmaCierreTurno()" style="opacity:1; display:none" data-dismiss="modal">Confirmar Cambio de Turno</a>
                  </div>
                  <? }
				  if($cont > 0){?>
				  <div class="modal-footer" id="boton_producto">
                	<input type="hidden" name="id_turno" id="id_turno">
                    <a class="close btn btn-success " id="btnconfirma" onClick="guardamesero(); confirmaAsignacionTurno()" style="opacity:1" data-dismiss="modal">Completar reasignación</a>
                  </div>
				  <? }?>
<script>
function guardamesero(){
	<?=$js?>
	}
</script>
<!-- FIN -->