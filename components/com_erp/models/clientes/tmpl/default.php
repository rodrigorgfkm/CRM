<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <!--<nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-home"></i></a>
                                </li>
                                <li>
                                <a href="#">Clientes</a></li>
                            </ul>
                        </div>
                    </nav>-->
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Lista de clientes</h3>
							<table class="table table-bordered table-striped table_vam" id="tabladinamica">
								<thead>
									<tr>
										<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
										<th>Empresa</th>
                                        <th>Nombre</th>
										<th width="250">Correo-e</th>
                                        <th width="100">Teléfono</th>
                                        <th width="100">Celular</th>
										<th width="100">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getClientes() as $cliente){
										  $com = getClientesCom($cliente->id);
										  if($cliente->vigente == 1){
											  $estado = 'open';
											  $tooltip = 'Cliente Vigente';
											  }else{
											  $estado = 'close';
											  $tooltip = 'Cliente no Vigente';
											  }
										  if($cliente->destacado == 1)
											$destacado = '';
											else
											$destacado = '-empty';?>
                                    <tr>
										<td><input type="checkbox" name="row_sel" class="row_sel" /></td>
										<td>
                                        	<strong>
											<?=$cliente->empresa?>
                                            </strong>
                                        </td>
                                        <td>
                                        	<strong>
											<?=$cliente->apellido.' '.$cliente->nombre?>
                                            </strong>
                                        </td>
										<td><?=$com->email?></td>
                                        <td><?=$com->fono_domicilio?></td>
                                        <td><?=$com->celular?></td>
										<td>
											<a href="index.php?option=com_erp&view=clientes&layout=publica&estado=<?=$cliente->vigente?>&id=<?=$cliente->id?>&Itemid=802" class="sepV_a jcetooltip" title="<?=$tooltip?>"><i class="icon-eye-<?=$estado?>"></i></a>
                                            <a href="index.php?option=com_erp&view=clientes&layout=destacado&estado=<?=$cliente->destacado?>&id=<?=$cliente->id?>&Itemid=802" class="sepV_a" title="View"><i class="icon-star<?=$destacado?>"></i></a>
                                          <? if($cliente->empresa == ''){?>
											  <a href="index.php?option=com_erp&view=clientes&layout=edita&id=<?=$cliente->id?>&Itemid=802" class="sepV_a" title="Edit"><i class="icon-pencil"></i></a>
											  <? }else{?>
											  <a href="index.php?option=com_erp&view=clientes&layout=editaempresa&id=<?=$cliente->id?>&Itemid=802" class="sepV_a" title="Edit"><i class="icon-pencil"></i></a>
											  <? }?>
											<a href="index.php?option=com_erp&view=clientes&layout=elimina&id=<?=$cliente->id?>&Itemid=802" title="Delete"><i class="icon-trash"></i></a>
										</td>
									</tr>
                                    <? }?>
								</tbody>
							</table>
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientes.php' );?>
			</div>