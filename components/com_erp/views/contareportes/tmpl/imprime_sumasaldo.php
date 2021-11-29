<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes')){
	$id_gestion = JRequest::getVar('id_gestion', getGestionAc(), 'post');
    $gestion = JRequest::getVar('gesti','','get');
    $desde = JRequest::getVar('fi','','get');
    //echo JRequest::getVar('r','','get');
    $hasta = JRequest::getVar('ff','','get');
    if($desde!=''){
        $msj = 'Fecha Del '.$desde.' Al '.$hasta;
    }elseif($hasta!=''){
        $msj = 'Balance de Sumas y Saldos Al '.$hasta;
    }
?>
<style>
    @media print{
        .btn-block{display: none;}
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
		<!-- Título de la vista -->
        <h3 class="box-title">Balance de Sumas y Saldos <br> Gestión: <?=$gestion?><br><?=$msj?></h3>
      </div>
      <div class="box-body">
        <button type="button" class="btn btn-block btn-success" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
        <div class="table-responive">
            <table class="table table-bordered table-striped table_vam" id="dt_gal">
                <thead>
                    <tr>
                        <th width="90" rowspan="2">Código</th>
                        <th rowspan="2">Cuentas</th>
                        <th colspan="2" style="text-align:center">Sumas</th>
                        <th colspan="2" style="text-align:center">Saldos</th>
                    </tr>
                    <tr>
                      <th width="90">Debe</th>
                      <th width="90">Haber</th>
                      <th width="90">Deudor</th>
                      <th width="90">Acreedor</th>
                    </tr>
                </thead>
                <tbody>
                	<? 
					$grantotal_debe = 0;
					$grantotal_haber = 0;
					$grantotal_deudor = 0;
					$grantotal_acreedor = 0;
					
					foreach(getCNTcuentas($id_gestion) as $cta){
						
						$total_debe = 0;
						$total_haber = 0;
						
						foreach(getCuentasComprobante($cta->id) as $detalle){
                            /*echo '<pre>';
                            print_r($detalle);
                            echo '</pre>';*/
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
							}
						if($saldo_debe != '0' || $saldo_haber != '0' || $total_haber != '0'){
						?>
					<tr>
                    	<td><?=codigoRename($cta->codigo)?></td>
                        <td><?=$cta->nombre?></td>
                        <td style="text-align: right"><?=number_format($total_debe, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($total_haber, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($saldo_debe, 2, ',', ' ')?></td>
                        <td style="text-align: right"><?=number_format($saldo_haber, 2, ',', ' ')?></td>
                    </tr>
					<? }}?>
                </tbody>
                <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th style="text-align:right"><?=number_format($grantotal_debe, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_haber, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_deudor, 2, ',', ' ')?></th>
                      <th style="text-align:right"><?=number_format($grantotal_acreedor, 2, ',', ' ')?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>