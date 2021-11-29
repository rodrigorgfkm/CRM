<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
?>
<script>
function popup(){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contacuentas&layout=lista&tmpl=component', width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	jQuery('#cuenta').val(nombre);
	jQuery('#id_cuenta').val(id);
	
	}
// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
</script>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Libro Diario</h3>
                            <div class="row-fluid">
                              <div class="span10 filtro">
                                  <form action="" method="post">
                                    <div class="row-fluid">
                                      <div class="span12">
                                        <input name="cuenta" type="text" id="cuenta" readonly placeholder="Cuenta" style="float:left; cursor:pointer" value="<?=JRequest::getVar('cuenta', '', 'post')?>" onClick="popup()">                      
                                        <input type="hidden" name="id_cuenta" id="id_cuenta" value="<?=JRequest::getVar('id_cuenta', '', 'post')?>">
                                        Desde       
                                        <input type="text" id="fecha_ini" name="fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
                                        Hasta
                                        <input type="text" id="fecha_fin" name="fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
                                        <button type="submit" class="btn btn-info"><i class="icon-filter icon-white"></i> Filtrar</button>
                                        <button class="btn"><i class="icon-ban-circle"></i>Limpiar</button>
                                      </div>
                                    </div>
                                  
                                  </form>
                              </div>
                              <div class="span2" style="text-align:right">
                                  <a href="index.php?option=com_erp&view=contareportes&layout=imprime_librodiario&fi=<?=JRequest::getVar('fecha_inicio', date('Y').'-01-01', 'post')?>&ff=<?=JRequest::getVar('fecha_fin', date('Y-m-d'), 'post')?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-success"><i class="icon-print icon-white"></i> Imprimir</a>
                              </div>
                              
                            </div>
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<tbody>
									<?php 
								if($_POST){
								foreach(getComprobantes() as $c){
									?>
                                    <tr>
                                      <td colspan="4" style="background:#e0e0e0">
                                        <div class="row-fluid">
                                          <div class="span2">
                                            <strong>Comprobante N&ordm; <?=$c->id?></strong>
                                          </div>
                                          <div class="span2">
                                            <strong>Fecha:</strong> <?=fecha($c->fec_creacion)?>
                                          </div>
                                          <div class="span8">
                                            <?='<strong>'.$c->tipo.':</strong> '.$c->detalle?>
                                        <? if($c->cliente!='')
											echo '<br><strong>Nombre:</strong> '.$c->cliente;
										?>
                                          </div>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th style="background:#ececec">Código</th>
                                      <th style="background:#ececec">Cuenta</th>
                                      <th style="background:#ececec">Debe</th>
                                      <th style="background:#ececec">Haber</th>
                                    </tr>
									<?php 
									$total_debe = 0;
									$total_haber = 0;
									foreach(getComprobantesDetalle($c->id) as $d){
										$total_debe+=$d->debe;
										$total_haber+=$d->haber?>
									<tr>
                                      <td><?=$d->codigo?></td>
                                      <td><?=$d->concepto?></td>
                                      <td style="text-align:right"><?=number_format($d->debe,2,",",".")?></td>
                                      <td style="text-align:right"><?=number_format($d->haber,2,",",".")?></td>
                                    </tr>
									<? }?>
									<tr>
                                      <td style="border-top: 1px solid #333"></td>
                                      <td style="border-top: 1px solid #333; text-align:right">Total</td>
                                      <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_debe,2,",",".")?></td>
                                      <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_haber,2,",",".")?></td>
                                    </tr>
									<? }
								}?>
								</tbody>
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
<style>
.row-fluid .input-append{ display:inline}
#fecha_ini, #fecha_fin{width:80px;}
</style>