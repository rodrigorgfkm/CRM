<?php defined('_JEXEC') or die;?>
<h3 class="heading">Libro Mayor</h3>
<? 
$cuenta = getCuenta(JRequest::getVar('id','', 'get'));?>
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