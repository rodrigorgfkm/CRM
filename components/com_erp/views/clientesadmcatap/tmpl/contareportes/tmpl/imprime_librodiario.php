<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Impresion')){

$gestion = getGestion(JRequest::getVar('id_gestion', '', 'get'));
?>
<h3 class="heading">Libro Diario</h3>
<? if(JRequest::getVar('r', '0', 'get') == '0'){?>
<h4>Gestión: <?=$gestion->gestion?> | Mes: <?=mes(JRequest::getVar('mes', '', 'get'));?></h4>
<? }else{?>
<h4>Desde: <?=JRequest::getVar('fi', '', 'post')?> | Hasta: <?=JRequest::getVar('ff', '', 'post')?></h4>
<? }?>
<p style="text-align:center"><a class="btn btn-block btn-success imprime" onClick="Imprime()">Imprimir</a></p>
<table class="table table-bordered table-striped table_vam" id="dt_gal">
    <tbody>
        <?php 
    foreach(getComprobantes() as $c){
        ?>
        <tr>
          <td colspan="4" style="background:#e0e0e0">
            <div class="row-fluid">
              <div class="span2">
                <strong>Comprobante N&ordm; <?=$c->numero?></strong>
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
          <th style="background:#ececec" width="80">Código</th>
          <th style="background:#ececec">Cuenta</th>
          <th style="background:#ececec" width="120">Debe</th>
          <th style="background:#ececec" width="120">Haber</th>
        </tr>
        <?php 
        $total_debe = 0;
        $total_haber = 0;
        foreach(getComprobantesDetalle($c->id) as $d){
            $total_debe+=$d->debe;
            $total_haber+=$d->haber?>
        <tr>
          <td><?=$d->codigo?></td>
          <td><?=$d->cuenta?></td>
          <td style="text-align:right"><?=number_format($d->debe,2,",",".")?></td>
          <td style="text-align:right"><?=number_format($d->haber,2,",",".")?></td>
        </tr>
        <? }?>
        <tr>
          <td style="border-top: 1px solid #333"></td>
          <td style="border-top: 1px solid #333; text-align:right">Total</td>
          <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_debe,2,",",".")?> Bs.</td>
          <td style="border-top: 1px solid #333; text-align:right"><?=number_format($total_haber,2,",",".")?> Bs.</td>
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
<? }else{vistaBloqueada();}?>