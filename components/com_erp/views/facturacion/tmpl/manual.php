<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Compras y Ventas')){
	$mes = JRequest::getVar('mes', '', 'post');
	$anio = JRequest::getVar('anio', '', 'post');
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');?>
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
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_txt_manual.php');
		else
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_manual.php');
	jQuery('#export').submit();
	}
function generalExcel(tipo){
	if(tipo == 'Normal')
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_manual.php?tipo=1');
		else
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_manual.php?tipo=0');
	jQuery('#export').submit();
	}
function confirma(id){
    jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Eliminar Factura?');
    jQuery('.modal-body').html('<p>&iquest;Está Seguro de Eliminar la factura?</p>');
    jQuery('.modal-footer').html("<a href='index.php?option=com_erp&view=facturacion&layout=manualelimina&id="+id+"' class='btn btn-success'>"+
                                 '<em class="fa fa-save"></em> Confirmar</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
    jQuery('#ventanaModal').trigger('click');
}
</script>
<style>
    .alineados{
        display: flex;
    }
    .padi{
        padding-bottom: 35px;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .alineados{
        display: block;
    }
    .padi{
        padding-bottom: 0;
    }
    table.resp tbody td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
	table.resp td:nth-of-type(2){ display: none;}
    table.resp td:nth-of-type(3){ display: none;}
	table.resp td:nth-of-type(4):before { content: "Fecha:"; font-weight: bold}
	table.resp td:nth-of-type(5):before { content: "Facturado:"; font-weight: bold}
	table.resp td:nth-of-type(6):before { content: "NIT:"; font-weight: bold}
	table.resp td:nth-of-type(7):before { content: "Monto:"; font-weight: bold}
	table.resp td:nth-of-type(8):before { content: "Estado:"; font-weight: bold}
	table.resp td:nth-of-type(9):before { content: "Accciones:"; font-weight: bold}
	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Facturas de Contingecia</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <div class="col-xs-12">
              <form action="" method="post">
                Filtro: 
                <div class="alineados">
                    <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                    <select name="sucursal"  class="form-control">
                      <option value=""> -- Sucursal -- </option>
                      <? foreach(getSucursales() as $suc){?>
                      <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
                      <? }?>
                    </select>
                    <select name="usuario"  class="form-control">
                      <option value=""> -- Usuario -- </option>
                      <? foreach(getOperador() as $usuario){?>
                      <option value="<?=$usuario->id?>" <?=$u==$usuario->id?'selected':''?>><?=$usuario->name?></option>
                      <? }?>
                    </select>
                    <select name="tipo"  class="form-control">
                      <option value=""> -- Tipo -- </option>
                      <? foreach(getTipoFacturas() as $tipo){
                        $tipofac = explode('|',$tipo->factura);?>
                      <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
                      <? }?>
                    </select>
                    <select name="estado"  class="form-control">
                      <option value="" <?=$estado==''?'selected':''?>>Todos</option>
                      <option value="V" <?=$estado=='V'?'selected':''?>>Válidas</option>
                      <option value="A" <?=$estado=='A'?'selected':''?>>Anuladas</option>
                      <option value="E" <?=$estado=='E'?'selected':''?>>Extraviada</option>
                      <option value="N" <?=$estado=='N'?'selected':''?>>No utilizada</option>
                      <option value="C" <?=$estado=='C'?'selected':''?>>Emitida en contingencia</option>
                    </select>
                </div>
                <br />
                <div class="form-group padi">
                    <div class="co-xs-12 col-sm-2">
                        <label style="display:inline"><input name="campo" type="radio" value="p.nombre" style="display:inline" <?=$campo=='p.nombre'||!$_POST?'checked="checked"':''?>>
                        </label>
                        <label style="display:inline">Nombre</label>
                        <label style="display:inline"><input name="campo" type="radio" value="f.nit" <?=$campo=='f.nit'?'checked="checked"':''?> style="display:inline"> NIT</label>
                    </div>
                    <label for="" class="col-xs-12 col-sm-1">Desde</label>
                    <div class="col-xs-12 col-xs-12 col-sm-2">
                        <input type="text" id="fecha_ini" name="fecha_ini" class="form-control datepicker" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
                    </div>
                    <label for="" class="col-xs-12 col-sm-1">Hasta</label>
                    <div class="col-xs-12 col-sm-2">
                        <input type="text" id="fecha_fin" name="fecha_fin" class="form-control datepicker" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
                    </div>                    
                    <div class="col-xs-12 col-sm-4">
                        <button class="btn btn-info" type="submit">Filtrar</button>
                        <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&layout=ventas">Limpiar</a>
                    </div>
                </div>
              </form>
          </div>
          <div class="col-xs-12 text-right">
            <form action="components/com_erp/views/facturacion/tmpl/exportar_manual.php" id="export" method="post">
              <a data-toggle="modal" data-backdrop="static" href="#excel" class="btn btn-success xcel">Exportar a Excel</a>
              <button class="btn btn-info" type="button" onClick="exportaLC(1)">Exportar a Facilito</button>
              <input type="hidden" name="filtro_fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
              <input type="hidden" name="filtro_fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
              <input type="hidden" name="filtro_campo" value="<?=JRequest::getVar('campo', '', 'post')?>">
              <input type="hidden" name="filtro_estado" value="<?=JRequest::getVar('estado', '', 'post')?>">
              <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
              <input type="hidden" name="filtro_sucursal" value="<?=JRequest::getVar('sucursal', '', 'post')?>">
              <input type="hidden" name="filtro_usuario" value="<?=JRequest::getVar('usuario', '', 'post')?>">
              <input type="hidden" name="filtro_tipo" value="<?=JRequest::getVar('tipo', '', 'post')?>">
              <input type="hidden" name="filtro_formato" value="<?=JRequest::getVar('formato', '', 'post')?>">
            </form>
          </div>
        </div>
    <table class="table table-bordered table-striped table_vam resp" id="tabladinamica">
        <thead>
            <tr>
                <th width="50">N&ordm;</th>
                <th width="20">Suc.</th>
                <th width="20">Tipo</th>
                <th width="70">Fecha</th>
                <th>Facturado a</th>
                <th width="80">NIT</th>
                <th width="60">Monto</th>
                <th width="90">Estado</th>
                <th width="60">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <? 
            $total = 0;
            foreach(getFacturasManual() as $factura){
                  if($factura->estado=="V")
                    $total+= $factura->total;
                  if($factura->id_empresa == 0)
                      $cliente = $factura->per_apellido.' '.$factura->per_nombre;
                      else
                      $cliente = $factura->empresa;

                  switch($factura->estado){
                      case 'A':
                      $estadoclass = 'danger';
                      $estadolabel = 'Anulada';
                      break;
                      case 'E':
                      $estadoclass = 'inverse';
                      $estadolabel = 'Extraviada';
                      break;
                      case 'N':
                      $estadoclass = 'info';
                      $estadolabel = 'No utilizada';
                      break;
                      case 'C':
                      $estadoclass = 'warning';
                      $estadolabel = 'Contingencia';
                      break;
                      default:
                      $estadoclass = 'success';
                      $estadolabel = 'Válida';
                      break;
                      }
                  ?>
            <tr>
                <td><?=$factura->numero?></td>
                <td><span style="padding:8px" class="alert alert-info" title="<?=$factura->sucursal_nombre?>"><?=$factura->sucursal_codigo?></span></td>
                <td><span style="padding:8px" class="alert" title="<?=$factura->tipo_factura?>"><?=$factura->tipo_factura_sigla?></span></td>
                <td><?=$factura->fecha?></td>
                <td><strong><?=$factura->nombre?></strong>
                  <br />
                    <?
                    if($cliente != ' ' && $cliente != '')
                        echo '<small style="font-size:80%"><i>Cliente: "'.$cliente.'"</i></small>';
                    ?>
                </td>
                <td><?=$factura->nit?></td>
                <td><?=$factura->estado=="V"?$factura->total:0.00?></td>
                <td><a class="btn btn-<?=$estadoclass?> span12" style="cursor:default"><?=$estadolabel?></a></td>
                <td>
                    <a href="index.php?option=com_erp&view=facturacion&layout=manualedita&id=<?=$factura->id?>" data-toggle="tooltip" class="btn btn-success ttip_t" title="Editar factura"><em class="fa fa-edit"></em></a>
                    <button type="button" class="btn btn-danger" title="Eliminar factura" onclick="confirma(<?=$factura->id?>)"><em class="fa fa-trash"></em></button>
                </td>
            </tr>
            <? }?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6">Total</th>
                <th colspan="3"><?=$total?></th>                
            </tr>
        </tfoot>
    </table>
      </div>
    </div>
  </section>
</div>
            <div class="modal hide fade" id="excel">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3>Exportar a Excel</h3>
                </div>
                <div class="modal-body">
                    Indique el tipo de formato que desea generar en Excel
                </div>
                <div class="modal-footer">
                    <a onClick="generalExcel('Normal')" class="btn btn-success" data-dismiss="modal">Normal</a>
                    <a onClick="generalExcel('Facilito')" href="#" class="btn btn-info" data-dismiss="modal">Facilito</a>
                </div>
            </div>
            <!--<div class="modal hide fade" id="elimina">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3>Eliminar registro</h3>
                </div>
                <div class="modal-body">
                    ¿Esta seguro de eliminar el registro?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" id="btn_confirma"><em class="fa fa-delete"></em> Eliminar</a>
                    <a href="#" class="btn btn-success" id="btn_cancela" data-dismiss="modal"><em class="fa fa-cancel"></em> Cancelar</a>
                </div>
            </div>-->
            <style>
              #fecha_ini, #fecha_fin{
				  width:80px;
				  }
			  .input-append{
				  display: inline;
				  }
            </style>
<? }else{vistaBloqueada();}?>