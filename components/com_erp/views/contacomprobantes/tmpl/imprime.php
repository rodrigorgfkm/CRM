<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
$comprobante = getComprobante();
$empresa = getEmpresa();?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title"><?=$empresa->empresa?></h3>
        <h3 class="box-title">Detalle de <?=$comprobante->tipo?></h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable" style="width:100%">
      <tbody>
          <tr>
            <td width="20%">Número</td>
            <td width="30%"><?=$comprobante->numero?></td>
            <td width="20%">Fecha</td>
            <td width="30%"><?=fecha($comprobante->fec_creacion)?></td>
          </tr>
          <tr>
            <td><? switch($comprobante->id_tipo){
                    case '1':
                    echo 'Hemos abonado a';
                    break;
                    case '2':
                    echo 'Hemos recibido de';
                    break;
                    }?></td>
            <td colspan="3"><?=$comprobante->cliente?></td>
          </tr>
          <tr>
            <td>Por concepto de</td>
            <td colspan="3"><?=$comprobante->detalle?></td>
          </tr>
          <tr>
            <td>Tipo de cambio</td>
            <td><?=$comprobante->tipo_cambio?></td>
            <td></td>
            <td></td>
          </tr>
    </tbody>
</table>
      <table class="table table-striped" style="width:100%" id="tabla_detalle">
          <thead>
            <tr>
              <th width="90">Cuenta</th>
              <th>Cuenta Contable</th>
              <th>Detalle</th>
              <th width="100">Debe</th>
              <th width="100">Haber</th>
            </tr>
        </thead>
          <tbody>
            <? 
            $total_debe = 0;
            $total_haber = 0;
            foreach(getComprobanteDetalle() as $detalle){
                $total_debe+= $detalle->debe;
                $total_haber+= $detalle->haber;?>
            <tr id="tr_0">
              <td><?=$detalle->codigo?></td>
              <td><?=$detalle->cuenta?></td>
              <td><?=$detalle->detalle?></td>
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
            <td colspan="4"><?=num_letra($total_debe).' '.ctv($total_debe).'/100';?></td>
            </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">
              <table class="table table-striped" style="width:100%">
                <tr>
                  <td>Realizado por:</td>
                  <td>Aprobado por:</td>
                  <td>Beneficiario:</td>
                </tr>
                <tr>
                  <td style="width:33.3%; text-align:center; height:100px; vertical-align:bottom" valign="bottom">
                    ___________________
                    <br>
                    &nbsp;
                  </td>
                  <td style="width:33.4%; text-align:center; height:100px; vertical-align:bottom" valign="bottom">
                    ___________________
                    <br>
                    &nbsp;
                  </td>
                  <td style="width:33.3%; text-align:center; height:100px; vertical-align:bottom" valign="bottom">
                    ___________________
                    <br>
                    CI:
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="4" style="text-align:center">
              <a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a>
            </td>
            </tr>
          </tfoot>
</table>
      </div>      
    </div>
  </section>
</div>

<script>
function Imprime(){
	jQuery('.imprime').hide();
	window.print();
	window.parent.Shadowbox.close();
	}
</script>
<? }else{ vistaBloaqueada();}?>