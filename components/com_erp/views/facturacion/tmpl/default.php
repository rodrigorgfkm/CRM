<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Facturas')){
	$session = JFactory::getSession();
	$user =& JFactory::getUser();

	if(JRequest::getVar('l', '', 'get') == 1){
		$session->clear('nit');
		$session->clear('numero');
		$session->clear('filtro');
		$session->clear('mes');
		$session->clear('anio');
		$session->clear('estado');
		$session->clear('s');
		$session->clear('u');
		$session->clear('t');
		}else{
		if($_POST){
			$session->set('nit', JRequest::getVar('nit', '', 'post'));
			$session->set('numero', JRequest::getVar('numero', '', 'post'));
			$session->set('filtro', JRequest::getVar('filtro', '', 'post'));
			$session->set('mes', JRequest::getVar('mes', '', 'post'));
			$session->set('anio', JRequest::getVar('anio', '', 'post'));
			$session->set('estado', JRequest::getVar('estado', '', 'post'));
			$session->set('s', JRequest::getVar('sucursal', checksucursalPred(), 'post'));
			$session->set('u', JRequest::getVar('usuario', '', 'post'));
			$session->set('t', JRequest::getVar('tipo', '', 'post'));
			}
		}
	$nit = $session->get('nit');
	$numero = $session->get('numero');
	$filtro = $session->get('filtro');
	$mes = $session->get('mes');
	$anio = $session->get('anio');
	$estado = $session->get('estado');
	$s = $session->get('s')=='' ? checksucursalPred() : $session->get('s');
	$u = $session->get('u');
	$t = $session->get('t');

	$pag = JRequest::getVar('p', 1, 'get');?>
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
    .vfiltro{display:flex; flex-wrap: wrap;}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {
    .vfiltro{display:block;}
    /* Force table to not be like tables anymore */
    .thumbnail{
        width: 100px;
    }
	
	table.resp tbody td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
	table.resp td:nth-of-type(2){ display: none;}
	table.resp td:nth-of-type(3){ display: none;}
	table.resp td:nth-of-type(4):before { content: "Fecha:"; font-weight: bold}
	table.resp td:nth-of-type(5):before { content: "F. Pago:"; font-weight: bold}
	table.resp td:nth-of-type(6):before { content: "Nombre:"; font-weight: bold}
	table.resp td:nth-of-type(7):before { content: "NIT:"; font-weight: bold}
	table.resp td:nth-of-type(8):before { content: "Monto:"; font-weight: bold}
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
        <h3 class="box-title">Facturas</h3>
      </div>
      <div class="box-body">
        <div class="col-xs-12">
          <form action="index.php?option=com_erp&view=facturacion" method="post" class="vfiltro" style="margin:0px;">
            <input type="text" name="filtro" class="form-control" value="<?=$session->get('filtro')?>" style="width:200px" placeholder="Nombre">
            <input type="text" name="numero" class="form-control" value="<?=$session->get('numero')?>" style="width:80px" placeholder="Número">
            <input type="text" name="nit" class="form-control" value="<?=$session->get('nit')?>" style="width:120px" placeholder="NIT">
            <select name="mes" class="form-control" style="width:auto !important">
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
            <select name="anio" class="form-control" style="width:auto !important">
              <option value="Año"> -- Año -- </option>
              <? for($i=2013; $i<=date('Y'); $i++){?>
              <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
              <? }?>
            </select>

            <select name="sucursal" class="form-control" style="width:auto !important">
              <option value=""> -- Sucursal -- </option>
              <? foreach(getUsuarioSucursal($user->get('id')) as $suc){?>
              <option value="<?=$suc->id?>" <?= $s == $suc->id ?'selected':'' ?>><?=$suc->nombre?></option>
              <? }?>
            </select>

            <select name="usuario" class="form-control" style="width:auto !important">
              <option value=""> -- Usuario -- </option>
              <? foreach(getOperador() as $usuario){?>
              <option value="<?=$usuario->id?>" <?=$u==$usuario->id?'selected':''?>><?=$usuario->name?></option>
              <? }?>
            </select>

            <? if(countTipoFactura() > 1){?>
            <select name="tipo" class="form-control" style="width:auto !important">
              <option value=""> -- Tipo -- </option>
              <? foreach(getTipoFacturas() as $tipo){
                  $tipofac = explode('|',$tipo->factura);?>
              <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
              <? }?>
            </select>
            <? }?>
            <select name="estado" class="form-control" style="width:auto !important">
              <option value="" <?=$estado==''?'selected':''?>>Todos</option>
              <option value="V" <?=$estado=='V'?'selected':''?>>Válidas</option>
              <option value="A" <?=$estado=='A'?'selected':''?>>Anuladas</option>
            </select>
            <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
            <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&l=1"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
          </form> 
        </div>
      </div>
      <div class="table-responsive">
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
                    <th width="50">Monto</th>
                    <!--<th width="90">Código</th>-->
                    <? if(validaAcceso('Anulación de facturas')){?>
                    <th width="20">Estado</th>
                    <? }?>
                    <th width="200">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getFacturas() as $factura){
                    /*echo '<pre>';
                    print_r($factura);
                    echo '</pre>';  */        
                      if($factura->id_empresa == 0)
                          $cliente = $factura->per_apellido.' '.$factura->per_nombre;
                          else
                          $cliente = $factura->empresa;
          
                      if($factura->estado == 'V')
                          $boton = '<a class="btn btn-info col-xs-12" title="Haga clic para anular la factura" onClick="abrepopup(\'index.php?option=com_erp&view=facturacion&layout=anula&id='.$factura->id.'&tmpl=component\')"><em class="fa fa-check-circle"></em></a>';
                          else{
                          $us_emitido = getUsuario($factura->id_usuario);
                          $us_anulado = getUsuario($factura->id_anulado);
                          $boton = '<a class="btn btn-danger col-xs-12" data-toggle="tooltip" data-html="true"  title="Factura anulada<br>Motivo: '.$factura->motivo_anulado.'<br>Emitido por: '.$us_emitido->name.'<br>Anulado por: '.$us_anulado->name.'" style="cursor: default"><em class="fa fa-window-close"></em></a>'; 
                          }
          
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
          
                    <td><?=$factura->estado=="V"?$factura->total:0.00?></td>
          
                    <!--<td><?=$factura->codigo?></td>-->
                    <? if(validaAcceso('Anulación de facturas')){?>
                    <td class="estado"><?=$boton?></td>
                    <? }?>
                    <td>
                        <? if($factura->estado == 'V'){?>
                        <? if($factura->codigo != ''){?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=factura&id=<?=$factura->id?>" class="btn btn-success" title="Ver detalle de la factura"><i class="fa fa-eye"></i></a>
                        <? if($factura->fecha_pago == '0000-00-00'){?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=consolidacion&id=<?=$factura->id?>" class="btn btn-info" title="Ver detalle de la factura"><i class="fa fa-eye"></i> Consolidar</a>
                        <? }else{?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=consolidacion&id=<?=$factura->id?>" class="btn btn-warning" title="Ver detalle de la factura"><i class="fa fa-pencil"></i> Editar</a>
						<? }?>
                        <!--<a href="index.php?option=com_erp&view=facturacion&layout=duplica&id=<?=$factura->id?>" class="btn btn-info"><i class="fa fa-plus"></i> Crear factura</a>-->
                        <? }else{?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=generacodigo&id=<?=$factura->id?>&tmpl=component" class="btn btn-warning">Generar Código de Control</a>
                        <? }
                        }?>
                    </td>
                </tr>
                <? }?>
            </tbody>
         </table>
         <?
		  $cantPages = getFacturasPaginacion();
		  $url = 'index.php?option=com_erp&view=facturacion';
		  ?>
		  <div class="row-fluid">
			<div class="span12">
			  <div  class="btn-group clearfix sepH_a">
				  <a href="<?=$url?>" class="btn ttip_t" title="Ir a la primera página">&lArr;</a>
				  <a href="<?=$url?>&p=<?=($pag-1)?>" class="btn ttip_t" title="Ir a la página anterior">&larr;</a>
				  <? 
				  for($i=1; $i<=$cantPages; $i++){
					if($pag == $i){?>
					<a class="btn btn-info"><?=$i?></a>
					<? }elseif($i < ($pag + 5) && $i > ($pag - 5)){?>
					<a href="<?=$url?>&p=<?=$i?>" class="btn ttip_t" title="Ir a la página <?=$i?>"><?=$i?></a>
				  <? }
				  }?>
				  <a href="<?=$url?>&p=<?=($pag+1)?>" class="btn ttip_t" title="Ir a la página siguiente">&rarr;</a>
				  <a href="<?=$url?>&p=<?=$cantPages?>" class="btn ttip_t" title="Ir a la última página">&rArr;</a>
			  </div>
			</div>
		  </div>
         
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>