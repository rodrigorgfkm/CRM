<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
						<div style="background:#FFF; padding:5px; border:1px solid #CCC; border-radius:4px; width:280px">
                            <div class="row-fluid">
                                <div class="span8"><h4>Lista de Productos</h4></div>
                                <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_producto_<?=$id?>')" class="btn btn-danger btn-mini"><em class="icon-remove icon-white"></em></a></div>
                            </div>             
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th width="80">Codigo</th>
										<th width="200">Producto</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getProductosCodigo() as $producto){
										  if($producto->published == 1){
											  $n++;
										  ?>
                                    <tr>
										<td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->precio?>')"><?=$producto->codigo?></a></td>
										<td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->precio?>')"><?=$producto->name?></a></td>
									</tr>
                                    <? }}?>
								</tbody>
							</table>
                        </div>
<!-- FIN -->