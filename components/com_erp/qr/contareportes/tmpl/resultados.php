<?php defined('_JEXEC') or die;?>
            <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
					  <div class="span12">
						<h3 class="heading">Estado de Resultados</h3>
						<table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th width="20">#</th>
                              <th width="80">C&oacute;digo</th>
                              <th>Nombre</th>
                              <th width="70">Debe</th>
                              <th width="70">Haber</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
						  creaTemporal();
                          cuentasBalance(0, 0, 4);
						  
						  $debe = 0;
						  $haber = 0;
						  foreach(getTempBalance() as $tmp){
							  $debe+= $tmp->debe;
							  $haber+= $tmp->haber;
							  }
						  ?>
                          <tr>
                            <td style="border-top: 1px solid #000"></td>
                            <td style="border-top: 1px solid #000">4</td>
                            <td style="border-top: 1px solid #000">INGRESOS</td>
                            <td style="border-top: 1px solid #000; text-align:right"><?=$debe?></td>
                            <td style="border-top: 1px solid #000; text-align:right"><?=$haber?></td>
                          </tr>
                          <tr>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                              Total
                            </td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                              <?=($haber-$debe)?>
                            </td>
                          </tr>
                          <?php 
						  vaciaTemporal();
                          cuentasBalance(0, 0, 5);
						  
						  $debe = 0;
						  $haber = 0;
						  foreach(getTempBalance() as $tmp){
							  $debe+= $tmp->debe;
							  $haber+= $tmp->haber;
							  }
						  ?>
                          <tr>
                            <td style="border-top: 1px solid #000"></td>
                            <td style="border-top: 1px solid #000">5</td>
                            <td style="border-top: 1px solid #000">EGRESOS</td>
                            <td style="border-top: 1px solid #000; text-align:right"><?=$debe?></td>
                            <td style="border-top: 1px solid #000; text-align:right"><?=$haber?></td>
                          </tr>
                          <tr>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000"></td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000">
                              Total
                            </td>
                            <td style="border-bottom: 2px solid #000; border-top: 1px dotted #000; text-align:right" colspan="2">
                              <?=($haber-$debe)?>
                            </td>
                          </tr>
                          </tbody>
                          <tfoot>
                          </tfoot>
                        </table>
                        
					  </div>
					</div>
              	  </div>
            </div>
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_contabilidad.php' );?>
			</div>      