<?php defined('_JEXEC') or die;
$pedido = getPedido();
$empresa = getEmpresa();
$conf = getPosConfiguracion();

$grantotal = $pedido->total + $pedido->impuesto + $pedido->propina;
?>
<!-- INICIO -->
			<input type="hidden" name="id_pedido" id="id_pedido" value="<?=JRequest::getVar('id', '', 'get')?>">
            <div class="modal-body" style="height:100%">
                <div id="pedido_datos" style="height:100%">
                  	<div style="position:relative"> 
                    	<div class="row-fluid" id="datos_cliente">
                            <div class="row-fluid">
                              <div class="span6">
                                <h4 class="span4">Total</h4>
                                <input class="span4" type="text" name="total" id="total" value="<?=$grantotal?>" readonly>
                                <select class="span4" name="modena" id="moneda">
                                	<option style="font-size:25px" value="efectivo">Efectivo</option>
                                	<option style="font-size:25px" value="tarjeta">Tarjeta</option>
                                </select>
                              </div>
                              <div class="span6">
                                <h4 class="span4">Boleta</h4>
                                <input class="span8" type="text" name="boleta" id="boleta" onClick="cambiaCampo('boleta')">
                              </div>
                            </div>
                            <div class="row-fluid">
                              <div class="span6">
                                <h4 class="span4">Apellido</h4>
                                <input class="span8" type="text" name="apellido" id="apellido" onClick="cambiaCampo('apellido')" autofocus>
                              </div>
                              <div class="span6">
                                <h4 class="span4"><?=$empresa->nombre_docidentidad?></h4>
                                <input class="span7" type="text" name="nit" id="nit" onClick="cambiaCampo('nit')">
                              </div>
                              
                            </div>
                        </div>
                        <div class="row-fluid" id="teclado">
                          <div class="row-fluid fila1" style="margin-top:5px;">
                              <input type="button" class="btn btn-large" value="1" onclick="teclado('1')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="2" onclick="teclado('2')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="3" onclick="teclado('3')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="4" onclick="teclado('4')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="5" onclick="teclado('5')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="6" onclick="teclado('6')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="7" onclick="teclado('7')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="8" onclick="teclado('8')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="9" onclick="teclado('9')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="0" onclick="teclado('0')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="&larr;" onclick="teclado('Limpiar')" style="width:10%" />
                          </div>
                          <div class="row-fluid fila2" style="margin-top:5px;">
                              <input type="button" class="btn btn-large keyboard" value="Q" onclick="teclado(this.value)" style="width:8%; margin-left:15px" />
                              <input type="button" class="btn btn-large keyboard" value="W" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="E" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="R" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="T" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="Y" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="U" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="I" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="O" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="P" onclick="teclado(this.value)" style="width:8%" />
                          </div>
                          <div class="row-fluid fila3" style="margin-top:5px;">
                              <input type="button" class="btn btn-large keyboard" value="A" onclick="teclado(this.value)" style="width:8%; margin-left:39px" />
                              <input type="button" class="btn btn-large keyboard" value="S" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="D" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="F" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="G" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="H" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="J" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="K" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="L" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="Ñ" onclick="teclado(this.value)" style="width:8%" />
                          </div>
                          <div class="row-fluid fila4" style="margin-top:5px;">
                              <input type="button" class="btn btn-large" id="mayuscula" value="Mayus" onclick="btnMayuscula()" style="width:10%" />
                              <input type="button" class="btn btn-large keyboard" value="Z" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="X" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="C" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="V" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="B" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="N" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large keyboard" value="M" onclick="teclado(this.value)" style="width:8%" />
                              <input type="button" class="btn btn-large" value="," onclick="teclado(',')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="." onclick="teclado('.')" style="width:8%" />
                              <input type="button" class="btn btn-large" value="-" onclick="teclado('-')" style="width:8%" />
                          </div>
                          <div class="row-fluid" style="text-align:center; margin-top:5px;">
                              <input type="button" class="btn btn-large" value="Espacio" onclick="teclado(' ')" style="width:80%;" />
                          </div>
                      </div>                    
                    </div>
                    <div class="modal-footer" id="boton_producto">
                        <a class="btn btn-success" style="opacity:1" onClick="confirmaCierre(jQuery('#id_pedido').val(), jQuery('#moneda').val(), jQuery('#apellido').val(), jQuery('#nit').val(), jQuery('#boleta').val())">Cerrar mesa</a>
                    </div>
				</div>
            </div>
<!-- FIN -->