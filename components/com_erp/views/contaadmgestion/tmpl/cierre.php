<?php defined('_JEXEC') or die;
//$tipo = ucfirst(tipocomprobante());
if(validaAcceso('Contabilidad Gestion')){
$id_gestion_origen = JRequest::getVar('id_gestion', '', 'get')?>
<script>
function cargaEstado(){
	var id_gestion = jQuery('#id_gestion_origen').val();
	location.href = 'index.php?option=com_erp&view=contaadmgestion&layout=cierre&id_gestion=' + id_gestion;
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cierre de Gestión</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
                <form action="" method="post" onSubmit="return verificarFormu(this); " enctype="multipart/form-data">
                  <table class="table table-striped table-bordered datatable">
                        <tbody>
                          <tr>
                            <td width="20%">Tipo de comprobante</td>
                            <td width="30%">Traspaso</td>
                            <td width="20%">Fecha de creación</td>
                            <td width="30%"><?=date('01/01/Y')?>
                              <input type="hidden" id="fecha" value="<?=date('Y').'-01-01'?>" name="fecha" >
                              <? //JHTML::calendar(date('Y-m-d'),'fecha','fecha','%Y-%m-%d');?>
                            </td>
                          </tr>
                          <tr>
                            <td>Gestión a cerrar</td>
                            <td width="30%">
                              <select name="id_gestion_origen" id="id_gestion_origen" class="form-control" onChange="cargaEstado()">
                                <option value=""></option>
                                <? foreach(getGestiones() as $ge){?>
                                <option value="<?=$ge->id?>"><?=$ge->gestion?></option>
                                <? }?>
                              </select>
                            </td>
                            <td width="20%">Gestión a abrir</td>
                            <td width="30%">
                              <select name="id_gestion_destino" class="form-control">
                                <option value=""></option>
                                <? foreach(getGestiones() as $ge){?>
                                <option value="<?=$ge->id?>"><?=$ge->gestion?></option>
                                <? }?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Por concepto de</td>
                            <td colspan="3"><span class="controls">
                              <input name="detalle" type="hidden" value="Comprobante de apertura" class="input-xlarge span12" id="focusedInput2">
                              Comprobante de apertura
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <? if($id_gestion_origen != ''){?>
                      <table class="table table-striped sortable" id="tabla_detalle">
                          <thead>
                            <tr>
                              <th width="40"></th>
                              <th width="90">C&oacute;digo</th>
                              <th>Cuenta Contable</th>
                              <th width="100">Debe</th>
                              <th width="100">Haber</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            cuentasListaGE(0, 0);
                            ?>
                          </tbody>
                          <? ?>
                          <tfoot>
                          <tr>
                              <td colspan="3" style="text-align:right"><strong>Total</strong></td>
                              <td style="text-align:right">
                                <input name="total_debe" type="hidden" value="<?=$GLOBALS['grantotal_deudor']?>">
                                <?=$GLOBALS['grantotal_deudor']?>
                              </td>
                              <td style="text-align:right">
                                <input name="total_haber" type="hidden" value="<?=$GLOBALS['grantotal_acreedor']?>">
                                <?=$GLOBALS['grantotal_acreedor']?>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="9">
                                <a class="btn btn-block btn-info col-xs-6" onclick="adicionaDetalle()">A&ntilde;adir campo</a>
                                <button class="btn btn-block btn-success col-xs-6" id="envia" style="display:none" type="submit">Crear Comprobante</button>
                              </td>
                            </tr>
                          </tfoot>
                      </table>
                      <? }?>
                </form>
                <? }else{
                    $val = comprobante_guarda();
                    $v = explode(';', $val);
                    //if($val == 1){

                    $comprobante = getComprobante($v[0]);
                    ?>
                    <div class="alert alert-success">
                      <a class="close" data-dismiss="alert">x</a>
                      El comprobante se <strong>generó</strong> correctamente
                    </div>
                    <h3 class="heading">Detalle del Comprobante Nro <?=$comprobante->id?></h3>
                    <table class="table table-striped table-bordered datatable">
                            <tbody>
                              <tr>
                                <td width="20%">Tipo</td>
                                <td width="30%"><?=getTipoComprobante($comprobante->id_tipo)?></td>
                                <td width="20%">
                                    <? switch($comprobante->id_tipo){
                                        case '1':
                                        echo 'Hemos abonado a';
                                        break;
                                        case '2':
                                        echo 'Hemos recibido de';
                                        break;
                                        }?>
                                </td>
                                <td width="30%">
                                  <?=$comprobante->cliente?>
                                </td>
                              </tr>
                              <tr>
                                <td>Por concepto de</td>
                                <td><?=$comprobante->detalle?></td>
                                <td>Fecha de creaci&oacute;n</td>
                                <td><?=$comprobante->fec_creacion?></td>
                              </tr>
                              <tr>
                                <td>Tipo de cambio</td>
                                <td><?=$comprobante->tipo_cambio?></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                    <table class="table table-striped" id="tabla_detalle">
                          <thead>
                            <tr>
                              <th width="90">C&oacute;digo</th>
                              <th>Descripci&oacute;n</th>
                              <th width="100">Debe</th>
                              <th width="100">Haber</th>
                            </tr>
                          </thead>
                          <tbody>
                            <? 
                            $total_debe = 0;
                            $total_haber = 0;
                            foreach(getComprobanteDetalle($v[0]) as $detalle){
                                $total_debe+= $detalle->debe;
                                $total_haber+= $detalle->haber;?>
                            <tr id="tr_0">
                              <td><?=$detalle->codigo?></td>
                              <td><?=$detalle->concepto?></td>
                              <td style="text-align:right"><?=number_format($detalle->debe,2,",",".")?></td>
                              <td style="text-align:right"><?=number_format($detalle->haber,2,",",".")?></td>
                            </tr>
                            <? }?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <td colspan="2" style="text-align:right"><strong>Total</strong></td>
                            <td style="text-align:right"><?=number_format($total_debe,2,",",".")?></td>
                            <td style="text-align:right"><?=number_format($total_haber,2,",",".")?></td>
                          </tr>
                            <tr>
                              <td colspan="4">
                                <a class="btn btn-block btn-info col-xs-6" href="index.php?option=com_erp&view=contacomprobantes">Volver</a>
                                <a class="btn btn-block btn-success col-xs-6" href="index.php?option=com_erp&view=contacomprobantes&layout=imprime&id=<?=$v[0]?>&tmpl=component" rel="shadowbox; width=950">Imprimir</a>
                              </td>
                            </tr>
                          </tfoot>
                      </table>
                    <? 

                    /*}else{?>
                    <h3>La fecha del comprobante no puede ser inferior a <?=$val?></h3>
                    <p><a  onClick="history.back()" class="btn btn-warning"><i class="icon-arrow-left icon-white"></i> Volver</a></p>
                    <? }*/
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>