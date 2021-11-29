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
                                <a href="#">Estado de cuenta</a></li>
                                <li>Detalle</li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Estado de cuenta</h3>
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th width="100">Monto</th>
										<th width="100">Estado</th>
										<th>Registrado por</th>
                                        <th width="200">Fecha y Hora</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getClienteCuenta() as $cuenta){
										if($cuenta->monto < 0){
											$monto = $cuenta->monto * (-1);
											$estado = 'Pago';
											}else{
											$estado = 'Adeuda';
											$monto = $cuenta->monto;
											}
											?>
                                    <tr>
										<td><?=$monto?></td>
										<td><?=$estado?></td>
										<td><?=$cuenta->usuario?></td>
                                        <td><?=$cuenta->fecha?></td>
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