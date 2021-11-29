<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Impresion')){
?>
<h3 class="heading">Libro Mayor</h3>
<h4>
	Desde: <?=JRequest::getVar('fi', '', 'get')?>
    <br />
    Hasta: <?=JRequest::getVar('ff', '', 'get')?>
</h4>
<? 
$cuenta = getCuenta(JRequest::getVar('id','', 'get'));?>
<p style="text-align:center"><a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a></p>
<table class="table table-bordered table-striped table_vam" id="dt_gal">
    <thead>
        <tr>
          <th colspan="6"><?=$cuenta->nombre?></th>
        </tr>
        <tr>
            <th width="80">Fecha</th>
            <th>Tipo</th>
            <th>Comp</th>
            <th>Nombre</th>
            <th>Concepto</th>
            <th width="110">Debe</th>
            <th width="110">Haber</th>
            <th width="110">Saldo</th>
        </tr>
    </thead>
    <tbody>
        <? 
        $total_debe = 0;
        $total_haber = 0;
        foreach(getCuentasComprobante($cuenta->id, 1) as $detalle){
            $total_debe+= $detalle->debe;
            $total_haber+= $detalle->haber;
            
            $saldo = $total_debe - $total_haber;
            ?>
        <tr>
          <td><?=$detalle->fec_creacion?></td>
          <td><?=$detalle->tipo?></td>
          <td><?=$detalle->numero?></td>
          <td><?=$detalle->cliente?></td>
          <td><?=$detalle->detalle?></td>
          <td style="text-align:right"><?=number_format($detalle->debe,2,",",".")?></td>
          <td style="text-align:right"><?=number_format($detalle->haber,2,",",".")?></td>
          <td style="text-align:right"><?=number_format($saldo,2,",",".")?></td>
        </tr>
        <? }?>
    </tbody>
    <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><strong>Total</strong></td>
          <td style="text-align:right"><?=number_format($total_debe,2,",",".")?> Bs.</td>
          <td style="text-align:right"><?=number_format($total_haber,2,",",".")?> Bs.</td>
          <td style="text-align:right"><?=number_format($saldo,2,",",".")?> Bs.</td>
        </tr>
    </tfoot>
</table>
<p style="text-align:center"><a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a></p>
<script>
function Imprime(){
	jQuery('.imprime').hide();
	window.print();
	window.parent.Shadowbox.close();
	}
</script>
<? }else{vistaBloqueada();}?>