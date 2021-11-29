<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-home"></i></a>
                                </li>
                                <li>
                                <a href="#">Clientes</a></li>
                                <li>
                                Estado de cuenta</li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Lista de clientes</h3>
							<table class="table table-bordered table-striped table_vam" id="tabladinamica">
								<thead>
									<tr>
										<th>Nombre</th>
										<th width="100">Estado</th>
                                        <th width="100">Cuenta</th>
										<th width="100">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getClientes() as $cliente){
										if($cliente->cuenta <= 0){
											$estado = 'A cuenta';
											$cuenta = $cliente->cuenta * (-1);
											}else{
											$estado = 'Debe';
											$cuenta = $cliente->cuenta;
											}
											?>
                                    <tr>
										<td><?=$cliente->apellido.' '.$cliente->nombre?></td>
										<td><?=$estado?></td>
                                        <td><?=$cuenta?></td>
										<td>
											<a href="index.php?option=com_erp&view=clientes&layout=estado&id=<?=$cliente->id?>&Itemid=802" class="sepV_a" title="Ver estado de cuenta"><i class="icon-th-list"></i></a>
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