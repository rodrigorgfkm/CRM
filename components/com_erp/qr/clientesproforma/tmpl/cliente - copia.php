<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
						<div style="background:#FFF; padding:5px; border:1px solid #CCC; border-radius:4px">
                            <div class="row-fluid">
                                <div class="span8"><h4>Lista de clientes</h4></div>
                                <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-mini"><em class="icon-remove icon-white"></em></a></div>
                            </div>             
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th width="20">N&ordm;</th>
										<th>Nombre</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getclientesEmergente() as $cliente){
										  if($cliente->vigente == 1){
											  $n++;
										  	  $com = getClientesCom($cliente->id);
										  ?>
                                    <tr>
										<td><?=$n?></td>
										<td><a style="cursor:pointer" onClick="parent.cargaCliente('<?=$cliente->id?>','<?=$cliente->apellido.' '.$cliente->nombre?>','<?=$com->fono_domicilio?>','<?=$com->celular?>','<?=$com->email?>', '<?=$cliente->cant?>')"><?=$cliente->apellido.' '.$cliente->nombre?></a></td>
									</tr>
                                    <? }}?>
								</tbody>
							</table>
                        </div>
<!-- FIN -->