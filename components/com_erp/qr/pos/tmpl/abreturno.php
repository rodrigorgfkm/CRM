<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
                  <div class="row-fluid" id="ambientesdisponibles">
                  	<? foreach(getTurnos() as $turno){
						if($turno->estado = 1)
							$class = 'success';
							else
							$class = 'danger';?>
			          <a href="#" class="btn btn-<?=$class?> span4" onclick="activaTurno(<?=$turno->id?>)" style="font-size:20px;padding: 10px 6px">
					  	<span style="display:block"><?=$turno->turno?></span>
                            <small style="font-size:12px">
                              <?=$turno->hora_inicio.' - '.$turno->hora_fin?>
                            </small>
                      </a>
                      <? }?>
                  </div>
<!-- FIN -->