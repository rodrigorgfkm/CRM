<?php defined('_JEXEC') or die;
$cliente = getCliente();
$nit = getNit($cliente->id);?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Editar empresa</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Empresa</td>
                                    <td><input type="text" name="empresa" id="empresa" value="<?=$cliente->empresa?>"></td>
                                  </tr>
                                  <tr>
                                    <td>NIT</td>
                                    <td><input type="text" name="nit" id="nit" value="<?=$nit->nit?>"></td>
                                  </tr>
                                  <? foreach(getCampos(1) as $campo){?>
                                  <tr>
                                    <td><?=$campo->tipo?></td>
                                    <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" value="<?=getCampoValor($campo->id)?>"></td>
                                  </tr>
                                  <? }?>
                                  <tr>
                                    <td>Dirección</td>
                                    <td><input type="text" name="direccion" id="direccion" value="<?=$cliente->direccion?>"></td>
                                  </tr>
                                  <tr>
                                    <td>Estado</td>
                                    <td>
                                      <select name="id_estado" class="chosen-select">
									  <? foreach(getPaises() as $pais){?>
											<option value=""></option>
                                            <optgroup label="<?=$pais->pais?>">
											<? foreach(getEstados($pais->id) as $e){?>
												<option value="<?=$e->id?>" <?=$e->id==$cliente->id_estado?'selected':''?>><?=$e->estado?></option>
												<? }
												}?>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Ciudad</td>
                                    <td><input type="text" name="ciudad" id="ciudad" value="<?=$cliente->ciudad?>"></td>
                                  </tr>
                                  <tr>
                                  	<th colspan="2">Datos de Contacto</th>
                                  </tr>
                                  <tr>
                                    <td>Nombre</td>
                                    <td><input type="text" name="nombre" id="nombre" value="<?=$cliente->nombre?>"></td>
                                  </tr>
                                  <tr>
                                    <td>Apellido</td>
                                    <td><input type="text" name="apellido" id="apellido" value="<?=$cliente->apellido?>"></td>
                                  </tr>
                                  <? foreach(getCampos() as $campo){?>
                                  <tr>
                                    <td><?=$campo->tipo?></td>
                                    <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" value="<?=getCampoValor($campo->id)?>"></td>
                                  </tr>
                                  <? }?>
                                  
                                  <tr>
                                    <td>Detalle</td>
                                    <td><textarea name="detalle" id="detalle"><?=$cliente->detalle?></textarea></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Guardar cliente</a></td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                            <? }else{
                                editCliente();
								editNitEmpresa()?>
                                <h3>El cliente fue editado correctamente</h3>
                                <p><input type="button" class="btn btn-success" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes'"></p>
                                <?
                                }?>
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientes.php' );?>
			</div>