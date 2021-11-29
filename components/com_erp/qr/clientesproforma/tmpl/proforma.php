<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Proformas')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');

$empresa = getEmpresa();
$p = getProforma();
?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Proforma</h3>
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="20%">Cliente</td>
                                    <td width="30%"><?=$p->nombre.' '.$p->apellido?></td>
                                    <td width="20%">Empresa</td>
                                    <td width="30%"><?=$p->empresa?></td>
                                  </tr>
                                  <tr>
                                    <td>Teléfono</td>
                                    <td><?=$p->fono?></td>
                                    <td>Celular</td>
                                    <td><?=$p->celular?></td>
                                  </tr>
                                  <tr>
                                    <td>Correo electrónico</td>
                                    <td><?=$p->email?></td>
                                    <td>Fecha</td>
                                    <td><?=$p->fecha?></td>
                                  </tr>
                                  <? if($ext['veh']->habilitado == 1){?>
                                  <tr>
                                    <td>Marca y modelo</td>
                                    <td><?=$p->vehiculo?>
                                    </td>
                                    <td>Chasis</td>
                                    <td><?=$p->chasis?></td>
                                  </tr>
                                  <? }?>
                                </tbody>
                              </table>
                              <table class="table table-striped table-bordered dataTable" id="detalle_lista">
                                <thead>
                                  <tr>
                                    <td width="100">Código</td>
                                    <td width="80">Cantidad</td>
                                    <td>Detalle</td>
                                    <td width="100">P. Unitario</td>
                                    <td width="100">P. Total</td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <? $total = 0;
								  foreach(getProformaDetalle() as $det){
									  $total+= $det->precio * $det->cantidad;?>
                                  <tr id="tr_0">
                                    <td><?=$det->codigo?></td>
                                    <td><?=$det->cantidad?></td>
                                    <td><?=$det->detalle?></td>
                                    <td><?=$det->precio?></td>
                                    <td><?=($det->precio * $det->cantidad)?></td>
                                  </tr>
                                  <? }?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                  	<td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <th>Total</th>
                                    <td><?=$total?></td>
                                  </tr>
                                  <tr>
                                  	<td colspan="6" style="text-align:center">
                                      <a class="btn btn-info span12" rel="shadowbox; width=950" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=clientesproforma&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=component">Imprimir</a>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                              <script>
							  function boton(){
								  jQuery("#imprime").trigger('click')
								  }
                              boton();
                              </script>
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