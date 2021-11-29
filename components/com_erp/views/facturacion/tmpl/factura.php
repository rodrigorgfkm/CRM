<?php defined('_JEXEC') or die;
if(validaAcceso("Ver factura")){
$session = JFactory::getSession();
$ext = $session->get('extension');

$empresa = getEmpresa();
$f = getFactura();
/*echo '<pre>';
    print_r($f);
echo '</pre>';*/
/* $tcambio = readXML("http://www.bcb.gob.bo/rss_bcb.php", 10); */
$tcambio =6.96;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Factura Nro. <?=$f->numero?></h3>
      </div>
      <div class="col-xs-12 btn-group">
        <button type="button" class="btn btn-info pull-right" onclick="history.back()"><i class="fa fa-arrow-left"></i> Volver</button>
        <!--<a href="index.php?option=com_erp&view=tesoreria&layout=ingresoservicios" class="btn btn-primary pull-right"><i class="fa fa-arrow-right"></i> Ir Ingresos a por Tipo</a>
        <a href="index.php?option=com_erp&view=tesoreria&layout=ingresocuotas" class="btn bg-orange pull-right"><i class="fa fa-arrow-right"></i> Ir Ingresos a por Cuotas</a>-->
      </div>
      <div class="box-body">
         <?
          if($f->codigo != ''){
          ?>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   NIT
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->nit?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                   Asociado
               </div>
               <div class="col-xs-12 col-sm-4">
                   <?=$f->empresa?>
               </div>
           </div>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   Facturar a nombre de
               </div>
               <div class="col-xs-12 col-sm-4">                   
                    <?=$f->nombre?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                   Fecha
               </div>
               <div class="col-xs-12 col-sm-4">
                    <?=$f->fecha_pago=='0000-00-00'?fecha($f->fecha):fecha($f->fecha_pago)?>
               </div>
           </div>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   Forma de pago
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->forma?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                   Tipo de cambio
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->tipo_cambio?>
               </div>
           </div>
           <? if($f->cheque_nro != '' and $f->cheque_nro != '1'){?>
           <div class="row">
           	   <div class="col-xs-12 col-sm-2 control-label">
                   Cheque Nro. 
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->cheque_nro?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                   Banco
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->cheque_banco?>
               </div>
            </div>
           <? }
		   $us_emitido = getUsuario($f->id_usuario);
		   $us_consolidado = getUsuario($f->id_usconsolida);
		   ?>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   Emisión Factura
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$us_emitido->name?>
               </div>
               <!--<div class="col-xs-12 col-sm-2 control-label">
                   Recibí conforme
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$us_consolidado->name?>
               </div>-->
           </div>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   Número de registro CNC
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->registro?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                   Categoría
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->categoria?>
               </div>
           </div>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                   Estado
               </div>
               <div class="col-xs-12 col-sm-4">                    
                    <?=$f->cliente_estado?>
               </div>
           </div>
           <? if($f->motivo_anulado != ''){
              	$us_anulado = getUsuario($f->id_anulado);
			  ?>
           <div class="row">
               <div class="col-xs-12 col-sm-2 control-label">
                  Factura anulada
               </div>
               <div class="col-xs-12">                   
               		<?=$f->motivo_anulado?>
               </div>
               <div class="col-xs-12 col-sm-2 control-label">
                 Anulada por
               </div>
               <div class="col-xs-12">                   
               		<?=$us_anulado->name?>
               </div>
           </div>
          <? }?>
          <table class="table table-striped table-bordered dataTable" id="detalle_lista">
            <thead>
              <tr>
                <td width="50">Ítem</td>
                <td width="100">Código</td>
                <td width="80">Cantidad</td>
                <td>Detalle</td>
                <td width="100" class="text-right">P. Unitario</td>
                <td width="100" class="text-right">P. Total</td>
                <td width="100" class="text-right">P. Total $us</td>
              </tr>
            </thead>
            <tbody>
              <? $total = 0;
              $n = 1;
              $descuento = 0;
              foreach(getFacturaDetalle() as $det){
                  if($det->codigo!='DESC-001'){
                    $total+= $det->precio * $det->cantidad;
                  }else{
                    $descuento = $det->precio;
                  }
              ?>
              <tr id="tr_0">
                <td><?=$n?></td>
                <td><?=$det->codigo?></td>
                <td><?=$det->cantidad?></td>
                <td><?=$det->detalle?></td>
                <td style="text-align:right"><?=number_format($det->precio,2,",",".")?></td>
                <td style="text-align:right"><?=number_format(($det->precio * $det->cantidad),2,",",".")?></td>
                <td style="text-align:right"><?=number_format((($det->precio * $det->cantidad)/$tcambio),2,",",".")?></td>
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
                <td style="text-align:right"><?=number_format($total-$descuento,2,",",".")?></td>
                <td style="text-align:right"><?=number_format((($total-$descuento)/$tcambio),2,",",".")?></td>
              </tr>
              <tr>
                <td colspan="6" style="text-align:center">
                  <? if(validaAcceso('Revierte Original') || validaAcceso('Administrador')){?>
                  <div class="col-md-6">
                  	<a class="btn btn-warning btn-block" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=original&id=<?=JRequest::getVar('id', '', 'get')?>">Revertir a Original</a>
                  </div>
                  <div class="col-md-6">
                  	<a class="btn btn-info btn-block" rel="shadowbox; width=950" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=blank">Imprimir</a>
                  </div>
                  <? }else{?>
                  <div class="col-md-12">
                  	<a class="btn btn-info btn-block" rel="shadowbox; width=950" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=facturacion&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=blank">Imprimir</a>
                  </div>
                  <? }?>
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
          <? }else{?>
          <h3>Antes de continuar debe generar el código de control de la factura</h3>  
          <p><a href="index.php?option=com_erp&view=facturacion&layout=generacodigo&id=<?=$f->id?>&tmpl=component" class="btn btn-warning">Generar Código de Control</a></p>
          <!--<p><a href="index.php?option=com_erp&view=facturacion" class="btn btn-warning">Generar Código de Control</a></p>-->
          
          <? }?>
      </div>
    </div>
  </section>
</div>
<?}else{vistaBloqueada();}?>