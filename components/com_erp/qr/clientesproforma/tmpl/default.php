<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Proformas')){?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Proformas</h3>
							<table class="table table-bordered table-striped table_vam" id="tabladinamica">
								<thead>
									<tr>
										<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
										<th>Nombre</th>
										<th width="100">Teléfono</th>
                                        <th width="100">Celular</th>
                                        <th width="250">Correo-e</th>
										<th width="250">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getProformas() as $proforma){
										  ?>
                                    <tr>
										<td><input type="checkbox" name="row_sel" class="row_sel" /></td>
										<td><strong><?=$proforma->nombre?></strong></td>
										<td><?=$proforma->fono?></td>
                                        <td><?=$proforma->celular?></td>
                                        <td><?=$proforma->email?></td>
										<td>
											<a href="index.php?option=com_erp&view=clientesproforma&layout=proforma&id=<?=$proforma->id?>" class="btn"><i class="icon-eye-open"></i> Ver proforma</a>
                                            <a href="index.php?option=com_erp&view=facturacion&layout=importa&t=p&id=<?=$proforma->id?>" class="btn"><i class="icon-eye-open"></i> Crear factura</a>
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
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>