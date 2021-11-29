<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Libro Mayor</h3>
                            <div class="row-fluid">
                              <div class="span10">
                                <form action="" method="post" class="filtro">
                                    <div class="row-fluid">
                                        Filtrar: 
                                        Cuenta:
                                        <select name="id" class="chosen-select span3">
                                          <option value=""></option>
                                          <? cuentasListaSelect(0, 0)?>
                                        </select>
                                        Desde 
                                        <?=JHTML::calendar(date('Y').'-01-01','fecha_inicio','fecha_inicio','%Y-%m-%d');?> 
                                        Hasta 
                                        <?=JHTML::calendar(date('Y-m-d'),'fecha_fin','fecha_fin','%Y-%m-%d');?> 
                                        <button type="submit" class="btn btn-info"><i class="icon-filter icon-white"></i> Generar reporte</button>
                                    </div>
                                  </form>  
                              </div>
                              <div class="span2" style="text-align:right">
                              	<a href="index.php?option=com_erp&view=contareportes&layout=imprime_libromayor&fi=<?=JRequest::getVar('fecha_inicio', date('Y').'-01-01', 'post')?>&ff=<?=JRequest::getVar('fecha_fin', date('Y-m-d'), 'post')?>&id=<?=JRequest::getVar('id','', 'post')?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-success"><i class="icon-print icon-white"></i> Imprimir</a>
                              </div>
                            </div>
                            
                            <? 
							if($_POST){
							$cuenta = getCuenta(JRequest::getVar('id','', 'post'));?>
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
                                      <th colspan="6"><?=$cuenta->nombre?></th>
                                    </tr>
                                    <tr>
										<th width="80">Fecha</th>
                                        <th>Nombre</th>
                                        <th>Concepto</th>
                                        <th width="70">Debe</th>
										<th width="70">Haber</th>
                                        <th width="70">Saldo</th>
									</tr>
								</thead>
								<tbody>
                                    <? 
									$total_debe = 0;
									$total_haber = 0;
									foreach(getCuentasComprobante($cuenta->id) as $detalle){
										$total_debe+= $detalle->debe;
										$total_haber+= $detalle->haber;
										
										$saldo = $total_debe - $total_haber;
										?>
                                    <tr>
                                      <td><?=$detalle->fec_creacion?></td>
                                      <td><?=$detalle->cliente?></td>
                                      <td><?=$detalle->detalle?></td>
                                      <td style="text-align:right"><?=number_format($detalle->debe,2,",",".")?></td>
                                      <td style="text-align:right"><?=number_format($detalle->haber,2,",",".")?></td>
                                      <td style="text-align:right"><?=number_format($saldo,2,",",".")?></td>
                                    </tr>
                                    <? }?>
								</tbody>
							</table>
							<? }?>
						</div>
					</div>
					
					<!-- hide elements (for later use) -->
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_contabilidad.php' );?>
			</div>
<style>
.row-fluid .input-append{ display:inline}
.filtro input{width: 100px !important}
</style>