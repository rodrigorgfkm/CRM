<?php defined('_JEXEC') or die;
if(validaAcceso("Ver factura")){
$session = JFactory::getSession();
$ext = $session->get('extension');

$empresa = getEmpresa();
$f = getFactura();
?>
<style>
    .table-responsive{
        overflow-x: hidden;
    }
@media (max-width: 767px){
    .table-responsive{
        overflow-x: scroll;
    }
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Factura Nro. <?=$f->numero?></h3>
      </div>
      <div class="box-body table-responsive">
         <? if(!$_POST){
          ?>
          <form action="" name="form" id="form" class="form-horizontal" method="post">
          <table class="table table-striped table-bordered dataTable">
            <tbody>
              <tr>
                <td>A nombre de</td>
                <td><?=$f->nombre?></td>
                <td>NIT</td>
                <td><?=$f->nit?></td>
              </tr>
              <tr>
                <td>Fecha</td>
                <td><?=$f->fecha?></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
          <div class="form-group">
              <label for="" class="col-sm-2">Tipo de pago</label>
              <div class="col-sm-10">
                  <select name="id_formapago" id="id_formapago" class="form-control">
                    <option value=""></option>
                    <? foreach(getFormasPago() as $forma){?>
                        <? if($forma->id==$f->id_formapago){?>
                            <option value="<?=$forma->id?>" selected><?=$forma->forma?></option>
                        <? }else{?>
                        <option value="<?=$forma->id?>"><?=$forma->forma?></option>
                    <?     }
                       }?>
                  </select>
              </div>
          </div>
          <? if($f->cheque_nro != '' and $f->cheque_nro != 1)?>
          <div class="form-group">
              <label for="" class="col-sm-2">Cheque</label>
              <div class="col-sm-10">
                  <input type="text" name="cheque_numero" class="form-control" value="<?=$f->cheque_nro?>">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-sm-2">Banco</label>
              <div class="col-sm-10">
                  <input type="text" name="cheque_banco" class="form-control" value="<?=$f->cheque_banco?>">
              </div>
          </div>
          <? }?>
          <? if($f->motivo_anulado != ''){
              $us_emitido = getUsuario($f->id_usuario);
              $us_anulado = getUsuario($f->id_anulado);
              ?>
          <div class="alert alert-warning">
            <strong>Factura anulada:</strong> <?=$f->motivo_anulado?>
            <br>
            <strong>Emitida por:</strong> <?=$us_emitido->name?>
            <br>
            <strong>Anulada por:</strong> <?=$us_anulado->name?>
          </div>
          <? }?>
          <table class="table table-striped table-bordered dataTable" id="detalle_lista">
            <thead>
              <tr>
                <td width="50">Ítem</td>
                <td width="100">Código</td>
                <td width="80">Cantidad</td>
                <td>Detalle</td>
                <td width="100">P. Unitario</td>
                <td width="100">P. Total</td>
              </tr>
            </thead>
            <tbody>
              <? $total = 0;
              $n = 1;
              foreach(getFacturaDetalle() as $det){
                  $total+= $det->precio * $det->cantidad;?>
              <tr id="tr_0">
                <td><?=$n?></td>
                <td><?=$det->codigo?></td>
                <td><?=$det->cantidad?></td>
                <td><?=$det->detalle?></td>
                <td style="text-align:right"><?=number_format($det->precio,2,",",".")?></td>
                <td style="text-align:right"><?=number_format(($det->precio * $det->cantidad),2,",",".")?></td>
              </tr>
              <? 
              $n++;
              }?>
            </tbody>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <th>&nbsp;</th>
                <th>Total</th>
                <td style="text-align:right"><?=number_format($total,2,",",".")?></td>
              </tr>
              <tr>
                <td colspan="6" style="text-align:center">
                  <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Editar Factura</button>
                </td>
              </tr>
            </tfoot>
          </table>
          </form>
          <? }else{
                  editFactura();
                  echo '<script>
                            location.href = "index.php?option=com_erp&view=facturacion&layout=factura&id='.$f->id.'";
                        </script>';
              }?>
      </div>
    </div>
  </section>
</div>
<?}else{vistaBloqueada();}?>