<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Facturas')){
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');?>

<script>
function cambiaBoton(id, token){
	var bot1 = '<a href="index.php?option=com_erp&view=facturacionmasiva&layout=lista&id='+id+'&token='+token+'" class="btn btn-sm btn-info ttip_t" title="Ver facturas"><i class="fa fa-eye"></i></a>';
	var bot2 = '<a class="btn btn-success btn-sm ttip_t" title="Lista de facturas impresa" style="cursor: default"><em class="fa fa-check"></em> Impreso</a>';
	var botones = bot1 + bot2
	
	jQuery('#row_'+id+' .botones').html(botones);
	}
</script>
<style>
span.alert{
	text-align: center;
	padding:6px 10px;
	display:block;
	margin-bottom:0px;
	}
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
        <h3 class="box-title">Registro de facturación masiva</h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
          <form action="" method="post" class="vfiltro" style="margin:0px;">
            Filtro: 
            <select name="mes" class="form-control" style="width:auto">
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
            <select name="anio" class="form-control" style="width:auto">
              <option value=""> -- Año -- </option>
              <? for($i=2013; $i<=date('Y'); $i++){?>
              <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
              <? }?>
            </select>

            <select name="sucursal" class="form-control" style="width:auto">
              <option value=""> -- Sucursal -- </option>
              <? foreach(getSucursales() as $suc){?>
              <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
              <? }?>
            </select>

            <select name="usuario" class="form-control" style="width:auto">
              <option value=""> -- Usuario -- </option>
              <? foreach(getOperador() as $usuario){?>
              <option value="<?=$usuario->id?>" <?=$u==$usuario->id?'selected':''?>><?=$usuario->name?></option>
              <? }?>
            </select>

            <? if(countTipoFactura() > 1){?>
            <select name="tipo" class="form-control" style="width:auto">
              <option value=""> -- Tipo -- </option>
              <? foreach(getTipoFacturas() as $tipo){
                  $tipofac = explode('|',$tipo->factura);?>
              <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
              <? }?>
            </select>
            <? }?>
            <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
            <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacionmasiva"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
          </form> 
        </div>
        <div class="col-xs-12" style="text-align:right">
        </div>
      </div>
    </div>
    <table class="table table-bordered table-striped table_vam resp" id="tabladinamica">
        <thead>
            <tr>
                <th width="20">N&ordm;</th>
                <th>Detalle.</th>
                <th width="80">Facturas</th>
                <th width="200">Tipo</th>
                <th width="50">Fecha</th>
                <th width="100">Total</th>
                <th width="100">Acciones</th>
                <th width="300">Impresiones</th>
            </tr>
        </thead>
        <tbody>
            <? 
			$n = 0;
			foreach(getFacturasMasiva() as $factura){
				  $n++;
                  if($factura->impreso == '0')
                      $boton = '<a href="index.php?option=com_erp&view=facturacionmasiva&layout=imprime&id='.$factura->id.'&token='.$factura->token.'&pag='.$factura->cant.'&tmpl=component" rel="shadowbox; width=950" class="btn btn-warning btn-sm ttip_t" title="Haga clic para imprimir las facturas de la lista" ><em class="fa fa-print"></em> Imprimir Facturas</a>';
                      else{
                      $boton = '<a class="btn btn-success btn-sm ttip_t" title="Lista de facturas impresa" style="cursor: default"><em class="fa fa-check"></em> Impreso</a>'; 
                      }

                  ?>
            <tr id="row_<?=$factura->id?>">
                <td><?=$n?></td>
                <td><?=$factura->descripcion?></td>
                <td><?=$factura->cant?></td>
                <td><?=$factura->factura?></td>
                <td><?=fecha($factura->fecha)?></td>
                <td class="text-right">Bs. <?=num2monto(sumFacturacionMasiva($factura->token))?></td>
                <td>
                  <a href="index.php?option=com_erp&view=facturacionmasiva&layout=listado&token=<?=$factura->token?>" class="btn btn-info btn-sm">
                    <em class="fa fa-files-o"></em>
                    Ver facturas
                  </a>
                </td>
                <td class="botones">
                    <!--<a href="index.php?option=com_erp&view=facturacionmasiva&layout=lista&id=<?=$factura->id?>" class="btn btn-sm btn-info ttip_t" title="Ver facturas"><i class="fa fa-eye"></i></a>-->
                    <?=$boton?>
                    <a href="index.php?option=com_erp&view=facturacionmasiva&layout=imprime_debito&id=<?=$factura->id?>&tmpl=component" rel="shadowbox; width=950" class="btn btn-info btn-sm ttip_t" title="Haga clic para imprimir las facturas de la lista" ><em class="fa fa-print"></em> Imprimir Nota Débido</a>
                </td>
            </tr>
            <? }?>
        </tbody>
    </table>
  </section>
</div>
<? }else{vistabloqueada(); }?>