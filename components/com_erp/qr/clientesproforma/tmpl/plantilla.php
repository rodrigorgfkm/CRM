<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li><a href="#"><i class="icon-home"></i></a></li>
                                <li><a href="#">Clientes</a></li>
                                <li><a href="#">Proformas</a></li>
                                <li>Plantillas</li>
                            </ul>
                        </div>
                    </nav>
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Plantillas</h3>
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
										<th>Nombre</th>
										<th width="120">Predeterminado</th>
									</tr>
								</thead>
								<tbody>
									<? foreach(getPlantillas(3) as $plantilla){
										if($plantilla->predeterminado == 1)
											$star = 'star';
											else
											$star = 'star-empty';
										  ?>
                                    <tr>
										<td><input type="checkbox" name="row_sel" class="row_sel" /></td>
										<td><strong><?=$plantilla->nombre?></strong></td>
										<td>
											<a href="index.php?option=com_erp&view=clientesproforma&layout=predetermina&v=<?=$plantilla->predeterminado?>&id=<?=$plantilla->id?>" class="btn span12"><i class="icon-<?=$star?>"></i></a>
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