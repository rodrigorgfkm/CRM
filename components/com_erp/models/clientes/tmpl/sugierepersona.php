<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
						<div style="background:#FFF; padding:5px; border:1px solid #CCC; border-radius:4px">
                            <div class="row-fluid">
                                <div class="span8"><h4>Lista de clientes</h4></div>
                                <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-mini"><em class="icon-remove icon-white"></em></a></div>
                            </div>             
							<table class="table table-bordered table-striped table_vam" id="tabladinamica">
								<thead>
									<tr>
										<th width="20">N&ordm;</th>
										<th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getClientesPSugerido() as $cliente){
										  if($cliente->vigente == 1){
											  $n++;
										  	  $com = getClientesCom($cliente->id);
										  ?>
                                    <tr>
										<td><?=$n?></td>
										<td><a style="cursor:pointer" href="index.php?option=com_erp&view=clientes&layout=edita&id=<?=$cliente->id?>"><?=$cliente->apellido.' '.$cliente->nombre?></a></td>
                                        <td><?=getClienteCelular($cliente->id)?></td>
                                        <td><?=getClienteEmail($cliente->id)?></td>
                                        <td><?=$cliente->direccion?></td>
									</tr>
                                    <? }}?>
								</tbody>
							</table>
                        </div>
<!-- FIN -->