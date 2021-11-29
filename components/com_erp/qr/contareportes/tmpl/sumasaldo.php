<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
						  <h3 class="heading">Balance de Sumas y Saldos</h3>
                            
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
                                    <tr>
										<th width="90" rowspan="2">Código</th>
                                        <th rowspan="2">Cuentas</th>
                                        <th colspan="2">Sumas</th>
										<th colspan="2">Saldos</th>
                                    </tr>
                                    <tr>
                                      <th width="90">Debe</th>
                                      <th width="90">Haber</th>
                                      <th width="90">Deudor</th>
                                      <th width="90">Acreedor</th>
                                    </tr>
								</thead>
								<tbody>
                                <?php cuentasListaSS(0, 0);?>
								<? 
								/*$grantotal_debe = 0;
								$grantotal_haber = 0;
								$grantotal_deudor = 0;
								$grantotal_acreedor = 0;
								
								foreach(getCuentas() as $cuenta){
									$total_debe = 0;
									$total_haber = 0;
									foreach(getCuentasComprobante($cuenta->id) as $detalle){
										$total_debe+= $detalle->debe;
										$total_haber+= $detalle->haber;
										}
									$grantotal_debe+= $total_debe;
									$grantotal_haber+= $total_haber;
									
									$saldo = $total_debe - $total_haber;
									if($saldo < 0){
										$saldo_haber = $saldo * (-1);
										$saldo_debe = 0.00;
										$grantotal_acreedor+= $saldo * (-1);
										}else{
										$saldo_haber =  0.00;
										$saldo_debe = $saldo;
										$grantotal_deudor+= $saldo;
										}?>
                                    <tr>
                                      <td><?=$cuenta->codigo?></td>
                                      <td><?=$cuenta->nombre?></td>
                                      <td><?=$total_debe?></td>
                                      <td><?=$total_haber?></td>
                                      <td><?=$saldo_debe?></td>
                                      <td><?=$saldo_haber?></td>
                                    </tr>
                                    <? }*/?>
								</tbody>
                                <tfoot>
                                	<tr>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align:right"><?=number_format($GLOBALS['grantotal_debe'], 2, ',', ' ')?></th>
                                      <th style="text-align:right"><?=number_format($GLOBALS['grantotal_haber'], 2, ',', ' ')?></th>
                                      <th style="text-align:right"><?=number_format($GLOBALS['grantotal_deudor'], 2, ',', ' ')?></th>
                                      <th style="text-align:right"><?=number_format($GLOBALS['grantotal_acreedor'], 2, ',', ' ')?></th>
                                    </tr>
                                </tfoot>
							</table>
						</div>
					</div>
					
					<!-- hide elements (for later use) -->
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_contabilidad.php' );?>
			</div>