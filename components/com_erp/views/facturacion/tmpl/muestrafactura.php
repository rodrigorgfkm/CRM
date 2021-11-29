<?php defined('_JEXEC') or die;
if (validaAcceso('Ver factura')){
	 $f = getFactura();
?>
<script>
function nuevaFactura(){
	location.href='index.php?option=com_erp&view=facturacion&layout=nuevo';
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Factura Creada</h3>
      </div>
      <div class="box-body table-responsive">
            <h3>La factura número <?=$f->numero?> se generó correctamente</h3>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       A nombre de
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=$f->nombre?>
                   </div>
               </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       NIT
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=$f->nit?>
                   </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       Fecha
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=fecha($f->fecha)?>
                   </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       Forma de Pago
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=$f->forma?>
                   </div>
                </div>
            </div>
            <? if($f->cheque_nro != ''){?>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       Número de cheque
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=$f->cheque_nro?>
                   </div>
                </div>
            </div>
            <? }
			if($f->cheque_banco != ''){?>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-4">
                       Banco
                   </label>
                   <div class="col-xs-12 col-sm-8">                    
                        <?=$f->cheque_banco?>
                   </div>
                </div>
            </div>
            <? }?>
          <table class="table table-striped table-bordered">
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
              foreach(getFacturaDetalle() as $det){
              //for($i=0; $i<count($_POST['cantidad']); $i++){
                  $total+= $_POST['precio'][$i] * $_POST['cantidad'][$i];?>
              <tr id="tr_0">
                <td><?=$det->codigo?></td>
                <td><?=$det->cantidad?></td>
                <td><?=$det->detalle?></td>
                <td><?=$det->precio?></td>
                <td><?=number_format(($det->cantidad*$det->precio),2)?></td>
              </tr>
              <? }?>
            </tbody>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <th>Total</th>
                <td><?=$f->total?></td>
              </tr>
              <tr>
                <td colspan="6" style="text-align:center">
                  <a class="btn btn-info col-xs-12" rel="shadowbox" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=imprime&id=<?=$f->id?>&tmpl=component">Imprimir</a>
                </td>
              </tr>
            </tfoot>
          </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistabloqueada();}?>