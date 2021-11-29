<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Facturas') or validaAcceso('Administrador Tesorería')){
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');

?>
<script>
function cierraventana(id){
	jQuery('#row_'+id+' .estado').html('<a class="btn btn-danger span12" style="cursor: default"><em class="icon-ban-circle icon-white"></em></a>');
	Shadowbox.close()
	}
function abrepopup(dirurl){
	Shadowbox.open({  
            content:    dirurl,
            player:     "iframe",
            width:      500,
            height:     200  
        });
	}
</script>
<style>
span.alert{
	text-align: center;
	padding:6px 10px;
	display:block;
	margin-bottom:0px;
	}
</style>
<style>
    .vfiltro{display:flex;}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .vfiltro{display:block;}
    /* Force table to not be like tables anymore */
    .thumbnail{
        width: 100px;
    }
	
	table.resp tbody td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
	table.resp td:nth-of-type(2){ display: none;}
	table.resp td:nth-of-type(3):before { content: "Tipo:"; font-weight: bold}
	table.resp td:nth-of-type(4):before { content: "Fecha:"; font-weight: bold}
	table.resp td:nth-of-type(5):before { content: "Facturado:"; font-weight: bold}
	table.resp td:nth-of-type(6):before { content: "NIT:"; font-weight: bold}
	table.resp td:nth-of-type(7):before { content: "Monto:"; font-weight: bold}
	table.resp td:nth-of-type(8){ display: none;}
	table.resp td:nth-of-type(9){ display: none;}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12 ">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Ingresos por tipo de Servicios</h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
          <form action="" method="post" class="vfiltro" style="margin:0px;">
            Filtro: 
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
              <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
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

            <select name="usuario" class="form-control">
              <option value=""> -- Usuario -- </option>
              <? foreach(getOperador() as $usuario){?>
              <option value="<?=$usuario->id?>" <?=$u==$usuario->id?'selected':''?>><?=$usuario->name?></option>
              <? }?>
            </select>

            <? if(countTipoFactura() > 1){?>
            <select name="tipo" class="form-control">
              <option value=""> -- Tipo -- </option>
              <? foreach(getTipoTFacturas() as $tipo){
                  $tipofac = explode('|',$tipo->factura);?>
              <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
              <? }?>
            </select>
            <? }?>
            <select name="estado" class="form-control">
              <option value="" <?=$estado==''?'selected':''?>>Todos</option>
              <option value="V" <?=$estado=='V'?'selected':''?>>Válidas</option>
              <option value="A" <?=$estado=='A'?'selected':''?>>Anuladas</option>
            </select>
            <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
            <a class="btn btn-warning" href="index.php?option=com_erp&view=tesoreria&layout=ingresoservicios"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
          </form> 
        </div>
      </div>
      <table class="table table-bordered table-striped table_vam resp" id="tabladinamica">
        <thead>
            <tr>
                <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                <th width="20">N&ordm;</th>
                <th width="20">Suc.</th>
                <th width="20">Tipo</th>
                <th width="50">Fecha</th>
                <th width="50">F. Pago</th>
                <th>Facturado a</th>
                <th width="60">NIT</th>
                <th width="100">Tot. factura</th>
                <th width="100">Tot. servicios</th>
                <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <? 
			foreach(getTFacturas('s') as $factura){
				if($factura->estado == 'V'){
                  $cliente = $factura->empresa;

                  ?>
            <tr id="row_<?=$factura->id?>">
                <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                <td><?=$factura->numero?></td>
                <td><span class="alert alert-info ttip_t" title="<?=$factura->sucursal_nombre?>"><?=$factura->sucursal_codigo?></span></td>
                <td><span class="alert ttip_t" title="<?=$factura->tipo_factura?>"><?=$factura->tipo_factura_sigla?></span></td>
              	<td><?=fecha($factura->fecha)?></td>
                <td><?=fecha($factura->fecha_pago)?></td>
                <td>
                  <strong><?=$factura->nombre?></strong>
                    <br />
                    <?
                    if($cliente != ' ' && $cliente != '')
                        echo '<small style="font-size:80%"><i>Cliente: "'.$cliente.'"</i></small>';
                    ?>
                </td>
                <td><?=$factura->nit?></td>

                <td class="text-right"><?=$factura->estado=="V"?num2monto($factura->total):0.00?></td>
                <td class="text-right"><?=$factura->estado=="V"?num2monto($factura->subtotal):0.00?></td>
                <td>
                    <? if($factura->codigo != ''){?>
                    <a href="index.php?option=com_erp&view=facturacion&layout=factura&id=<?=$factura->id?>" class="btn btn-success" title="Ver detalle de la factura"><i class="fa fa-eye"></i></a>
                    <!--<a href="index.php?option=com_erp&view=facturacion&layout=duplica&id=<?=$factura->id?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear factura</a>-->
                    <? }else{?>
                    <a href="index.php?option=com_erp&view=facturacion&layout=generacodigo&id=<?=$factura->id?>&tmpl=component" class="btn btn-warning">Generar Código de Control</a>
                    <? }?>
                </td>
            </tr>
            <? }}?>
        </tbody>
    </table>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>