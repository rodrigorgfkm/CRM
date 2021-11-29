<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Compras y Ventas')){
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
	$detalle = JRequest::getVar('detalle', '', 'post');?>
    <script>

// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
function exportaLC(t){
	if(t == 1)
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_txt_ventas.php');
		else
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_ventas.php');
	jQuery('#export').submit();
	}
function generalExcel(tipo){
	if(tipo == 'Normal')
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_ventas.php?tipo=1');
		else
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_ventas.php?tipo=0');
	jQuery('#export').submit();
	}
function rangoFecha(){
	if(jQuery('#rango').prop('checked') ) {
		jQuery("#fecha_ini").removeAttr("disabled");
		jQuery("#fecha_fin").removeAttr("disabled");
		jQuery("#mes").attr('disabled', 'disabled');
		jQuery("#anio").attr('disabled', 'disabled');
		jQuery("#mes").val('');
		jQuery("#anio").val('');
		}else{
		jQuery("#fecha_ini").attr('disabled', 'disabled');
		jQuery("#fecha_fin").attr('disabled', 'disabled');
		jQuery("#fecha_ini").val('');
		jQuery("#fecha_fin").val('');
		jQuery("#mes").removeAttr("disabled");
		jQuery("#anio").removeAttr("disabled");
		}
	}
</script>
<style>
    .filter_comparativo{
        display: flex;
    }
@media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
    .filter_comparativo{
        display: block;
    }
}
</style>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Comparativo Compras - Ventas</h3>       
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <div class="col-xs-12">
              <form action="" method="post">
                <div class="filter_comparativo">
                    <select name="mes" id="mes"  class="form-control">
                      <option value="">-- Mes --</option>
                      <option value="01">Enero</option>
                      <option value="02">Febrero</option>
                      <option value="03">Marzo</option>
                      <option value="04">Abril</option>
                      <option value="05">Mayo</option>
                      <option value="06">Junio</option>
                      <option value="07">Julio</option>
                      <option value="08">Agosto</option>
                      <option value="09">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                    <select name="anio" id="anio"  class="form-control">
                      <option value="">-- Año --</option>
                      <? for($i=2014; $i<=date('Y'); $i++){?>
                      <option value="<?=$i?>"><?=$i?></option>
                      <? }?>
                    </select>
                    <select name="sucursal"  class="form-control">
                      <option value=""> -- Sucursal -- </option>
                      <? foreach(getSucursales() as $suc){?>
                      <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
                      <? }?>
                    </select>
                    <select name="detalle" class="form-control">
                      <option value="0" <?=$detalle==0?'selected':''?>>General</option>
                      <option value="1" <?=$detalle==1?'selected':''?>>Detalle</option>
                    </select>
                    <button class="btn btn-info" type="submit">Filtrar</button>
                    <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&layout=comparativo">Limpiar</a>
                </div>
                <br />
                <label style="display: inline"><input type="checkbox" onClick="rangoFecha()" name="rango" id="rango" value="1" style="display: inline"> Elegir rango de fechas: </label> <br>
                Desde
                <input type="text" id="fecha_ini" disabled name="fecha_ini" class="form-control datepicker" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
                Hasta
                <input type="text" id="fecha_fin" disabled name="fecha_fin" class="form-control datepicker" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
              </form>
          </div>
          <div class="span4" style="text-align:right"></div>
        </div>

    <h4>Ventas</h4>
    <table class="table table-bordered table-striped table_vam">
        <thead>
            <tr>
                <th width="50">N&ordm;</th>
                <th width="20">Suc.</th>
                <th width="70">Fecha</th>
                <th>Facturado a</th>
                <th width="60">Monto</th>
            </tr>
        </thead>
        <? if($_POST){?>
        <tbody>
            <? 
            $total = 0;
            foreach(getFacturas() as $factura){
                  if($factura->estado=="V")
                    $total+= $factura->total;
                  if($factura->id_empresa == 0)
                      $cliente = $factura->per_apellido.' '.$factura->per_nombre;
                      else
                      $cliente = $factura->empresa;

                  if($factura->estado == 'V'){
                      $estadoclass = 'success';
                      $estadolabel = 'Válida';
                      }else{
                      $estadoclass = 'danger';
                      $estadolabel = 'Anulada';
                      }
            if($detalle == 1){
                  ?>
            <tr>
                <td><?=$factura->numero?></td>
                <td><span style="padding:8px" class="alert alert-info" title="<?=$factura->sucursal_nombre?>"><?=$factura->sucursal_codigo?></span></td>
                <td><?=fecha($factura->fecha)?></td>
                <td><strong><?=$factura->nombre?></strong>
                  <br />
                    <?
                    if($cliente != ' ' && $cliente != '')
                        echo '<small style="font-size:80%"><i>Cliente: "'.$cliente.'"</i></small>';
                    ?>
                </td>
                <td style="text-align:right"><?=$factura->estado=="V"?$factura->total:0.00?></td>
            </tr>
            <? }}?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td>Total</td>
                <td style="text-align:right"><?=$total?></td>
            </tr>
        </tfoot>
        <? }?>
    </table>
    <? $total_ventas = $total;?>

    <h4>Compras</h4>
    <table class="table table-bordered table-striped table_vam">
        <thead>
            <tr>
                <th width="90">N&ordm; de Factura</th>
                <th width="70">Fecha</th>
                <th>Razón Social</th>
                <th width="60">Monto</th>
                <th width="60">Importe CF</th>
            </tr>
        </thead>
        <? if($_POST){?>
        <tbody>
            <? 
            $total = 0;
            $totalcf = 0;
            foreach(getCompras() as $factura){
                $nombre = explode(' ', $factura->name);
                $nom = '';
                foreach($nombre as $n)
                    $nom.= $n[0];
                $nom = ucwords($nom);
                $total+= $factura->total;
                $totalcf+= $factura->total - $factura->nocredito;
            if($detalle == 1){
            ?>
            <tr>
                <td><?=$factura->numero?></td>
                <td><?=fecha($factura->fecha_emision)?></td>
                <td><strong><?=$factura->empresa?></strong></td>
                <td style="text-align:right"><?=number_format($factura->total, 2, ',', '.')?></td>
                <td style="text-align:right"><?=number_format($factura->total-$factura->nocredito, 2, ',', '.')?></td>
            </tr>
            <? }}?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>Total</td>
                <td style="text-align:right"><?=number_format($total, 2, ',', '.')?></td>
                <td style="text-align:right"><?=number_format($totalcf, 2, ',', '.')?></td>
            </tr>
        </tfoot>
        <? }?>
    </table>
    <? $total_compras = $total;?>
    <? if($_POST){?>
    <h3 style="text-align:center"><?=$total_ventas?> - <?=$total_compras?> = <?=($total_ventas - $total_compras)?></h3>
    <? }?>
      </div>
    </div>
  </section>
</div>
            <style>
              #fecha_ini, #fecha_fin{
				  width:80px;
				  }
			  .input-append{
				  display: inline;
				  }
            </style>
<? }else{vistaBloqueada();}?>