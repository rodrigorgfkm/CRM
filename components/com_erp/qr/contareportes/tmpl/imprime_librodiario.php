<?php defined('_JEXEC') or die;?>
<h3 class="heading">Libro Diario</h3>
<p style="text-align:center"><a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a></p>
<table class="table table-bordered table-striped table_vam" id="dt_gal">
    <thead>
        <tr>
            <th width="80">Fecha</th>
            <th>Concepto</th>
            <th width="50" style="">Debe</th>
            <th width="50">Haber</th>
        </tr>
    </thead>
    <tbody>
        <?php 
    foreach(getComprobantes() as $c){
        ?>
        <tr>
          <th colspan="5" style="text-align:center; border-top: 2px solid #000">
            <strong><?=$c->id?></strong>
          </th>
        </tr>
        <tr>
          <td style="text-align:center; border-top: 1px dashed #000"><?=$c->fec_creacion?></td>
          <td style="text-align:center; border-top: 1px dashed #000">
            <?='<strong>'.$c->tipo.':</strong> '.$c->detalle?>
            <? if($c->cliente!='')
                echo '<br><strong>Nombre:</strong> '.$c->cliente;
            ?>
          </td>
          <td style="text-align:center; border-top: 1px dashed #000"></td>
          <td style="text-align:center; border-top: 1px dashed #000"></td>
        </tr>
        <?php 
        $total_debe = 0;
        $total_haber = 0;
        foreach(getComprobantesDetalle($c->id) as $d){
            $total_debe+=$d->debe;
            $total_haber+=$d->haber?>
        <tr>
          <td></td>
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
        <? }?>
    </tbody>
</table>
<p style="text-align:center"><a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a></p>
<script>
function Imprime(){
	jQuery('.imprime').hide();
	window.print();
	window.parent.Shadowbox.close();
	}
</script>