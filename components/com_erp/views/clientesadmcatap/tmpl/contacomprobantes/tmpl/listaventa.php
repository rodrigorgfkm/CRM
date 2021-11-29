<?php 
defined('_JEXEC') or die;?>
<? if(validaAcceso('Contabilidad Comprobante nuevo')){
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');

	$id = explode('_',$_GET['id']);    
?>
<script>
function carga(id_factura, cliente, total){
	id = '<?=$id[1]?>';
	window.parent.carga(id, id_factura, cliente, total, 1);
	window.parent.Shadowbox.close();
	}
var  n_filas;
jQuery(document).on('ready',function(){
    jQuery('[type=checkbox]').on('click',function(){
        if(jQuery('[type=checkbox]:checked').length>0){
            jQuery('.cargarcuentas').removeAttr('disabled');
        }else{
            jQuery('.cargarcuentas').attr('disabled','disabled');
        }
    })
})
</script>
<style>
span.alert{
	text-align: center;
	padding:6px 10px;
	display:block;
	margin-bottom:0px;
	}
    .junto{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {    
    .junto{
        display: block;
    }
    .cod-fa{display: none !important;}
	table.resp tbody table.resp td{ min-height: 35px}
	td:nth-of-type(1):before {content: 'Marcar:            ';font-weight: bold;}
	td:nth-of-type(2):before { content: "Fecha:  "; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/	
	td:nth-of-type(3):before { display: none;}
	td:nth-of-type(4):before { display: none;}
	td:nth-of-type(5):before { content: "Cliente:  "; font-weight: bold}
	td:nth-of-type(6):before { content: "Fact. a:  "; font-weight: bold}
	td:nth-of-type(7):before { content: "NIT: "; font-weight: bold}
	td:nth-of-type(8):before { content: "Monto: "; font-weight: bold}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Facturas</h3>		
      </div>
      <div class="box-body">
        <form action="" method="post" style="margin:0px">
            Filtro: 
            <div class="junto">
                <select name="mes" class="form-control">
                  <option value=""> -- Mes -- </option>
                  <option value="01" <?=$mes=='01'?'selected':''?>>Enero</option>
                  <option value="02" <?=$mes=='02'?'selected':''?>>Febrero</option>
                  <option value="03" <?=$mes=='03'?'selected':''?>>Marzo</option>
                  <option value="04" <?=$mes=='04'?'selected':''?>>Abril</option>
                  <option value="05" <?=$mes=='05'?'selected':''?>>Mayo</option>
                  <option value="06" <?=$mes=='06'?'selected':''?>>Junio</option>
                  <option value="07" <?=$mes=='07'?'selected':''?>>Julio</option>
                  <option value="08" <?=$mes=='08'?'selected':''?>>Agosto</option>
                  <option value="09" <?=$mes=='09'?'selected':''?>>Septiembre</option>
                  <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
                  <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
                  <option value="12" <?=$mes=='12'?'selected':''?>>DiciembreS</option>
                </select>
                <select name="anio" class="form-control">
                  <option value="Año"> -- Año -- </option>
                  <? for($i=2013; $i<=date('Y'); $i++){?>
                  <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
                  <? }?>
                </select>
                <select name="sucursal" class="form-control">
                  <option value=""> -- Sucursal -- </option>
                  <? foreach(getSucursales() as $suc){?>
                  <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
                  <? }?>
                </select>
                <? if(countTipoFactura() > 1){?>
                <select name="tipo" class="form-control">
                  <option value=""> -- Tipo -- </option>
                  <? foreach(getTipoFacturas() as $tipo){?>
                  <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipo->factura?></option>
                  <? }?>
                </select>
                <? }?>
                <select name="estado" class="form-control">
                  <option value="" <?=$estado==''?'selected':''?>>Todos</option>
                  <option value="V" <?=$estado=='V'?'selected':''?>>Válidas</option>
                  <option value="A" <?=$estado=='A'?'selected':''?>>Anuladas</option>
                </select>
                <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
                <a class="btn btn-warning" href="index.php?option=com_erp&view=contacomprobantes&layout=listaventa&tmpl=component"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
            </div>
        </form>
      <form action="index.php?option=com_erp&view=contacomprobantes&layout=listaventacarga&tmpl=blank" name="enviofacturas" method="post">
        <div class="form-group">
            <button type="submit" class="btn btn-success pull-right cargarcuentas" disabled><i class="fa fa-plus"></i> Cargar a Comprobante Contable</button>
        </div>
      </div>
      <div class="box-body">
      	<table class="table table-bordered table-striped table_vam resp" id="tabladinamica">
            <thead>
                <tr>
                    <th class="table_checkbox"><!--<input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" />--></th>
                    <th width="50">Fecha</th>
                    <th width="20">Suc.</th>
                    <th width="20">Tipo</th>
                    <th>Cliente</th>
                    <th>Facturado a</th>
                    <th width="60">NIT</th>
                    <th width="50">Monto</th>
                    <!--<th width="150">Acciones</th>-->
                </tr>
            </thead>
            <tbody>
                <?
                foreach(getFacturasVentas() as $factura){
                  $cta = getCNTcuenta();
                  if($factura->estado == 'V'){
                      if(is_null($factura->id_venta)){
                          if($factura->id_empresa == 0)
                              $cliente = $factura->per_apellido.' '.$factura->per_nombre;
                              else
                              $cliente = $factura->empresa;
                      ?>
                <tr id="row_<?=$factura->id?>">
                    <td><input type="checkbox" class="checks" name="facturas[]" value="<?=$factura->id?>" class="row_sel" /></td>
                    <td><?=fecha($factura->fecha)?></td>
                    <td class="cod-fa"><span class="alert alert-info"><?=$factura->sucursal_codigo?></span></td>
                    <td class="cod-fa"><span class="alert"><?=$factura->tipo_factura_sigla?></span></td>
                    <td><?=$cliente?></td>
                    <td><strong><?=$factura->nombre?></strong></td>
                    <td><?=$factura->nit?></td>
                    <td><?=$factura->estado=="V"?$factura->total:0.00?></td>
                    <!--<td>
                        <a href="index.php?option=com_erp&view=contacomprobantes&layout=listaventacarga&id=<?=$factura->id?>&n=<?=JRequest::getVar('n', '', 'get');?>&tmpl=blank" class="btn btn-info btn-sm cargando"><i class="fa fa-plus"></i> Cargar</a>
                    </td>-->
                </tr>
                <? }}}?>
            </tbody>
        </table>
      </div>
            <input type="hidden" name="n" id="n" value="<?=JRequest::getVar('n', '', 'get');?>">
      <div class="">
            <button type="submit" class="btn btn-success pull-right cargarcuentas btn-xs" disabled><i class="fa fa-plus"></i> Cargar Cuentas</button>
      </div>
    </form>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>