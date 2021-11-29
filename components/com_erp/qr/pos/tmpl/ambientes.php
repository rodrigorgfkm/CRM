<?php defined('_JEXEC') or die;
$empresa = getEmpresa();
?>
<!-- INICIO -->
			      <table class="table table-condensed table-striped" data-rowlink="a">
			        <thead>
			          <tr>
			            <td>Personas</td>
                        <td><select name="pax" id="pax">
                                <? for($i=1; $i<=$empresa->maxpax; $i++){?>
                                <option value="<?=$i?>" style=" font-size:25px"><?=$i?></option>
                                <? }?>
                            </select></td>
		              </tr>
                      <tr>
			            <td>Mesero</td>
                        <td>
                        	<select name="mesero" id="mesero" onChange="muestraAmbiente()">
                            	<option value=""></option>
                                <? foreach(getMeseros() as $mesero){?>
                                <option value="<?=$mesero->id?>" style=" font-size:25px"><?=$mesero->name?></option>
                                <? }?>
                            </select>
                        </td>
		              </tr>
                      <tr>
			            <th colspan="2">Ambiente</th>
		              </tr>
		            </thead>
                  </table>
                  <div class="row-fluid" id="ambientesdisponibles" style="display:none">
                  	<? foreach(getAmbientes() as $ambiente){
						  if($ambiente->cant != 0){?>
			          <a href="#" class="btn btn-info span4" onclick="cargaAmbiente(<?=$ambiente->id?>)" style="font-size:20px;padding: 10px 6px">
					  	<?=$ambiente->ambiente?>
                      </a>
                      <? }}?>
                  </div>
<!-- FIN -->