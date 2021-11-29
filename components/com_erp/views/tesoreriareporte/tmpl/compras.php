<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Compras y Ventas') or validaAcceso('Administrador Tesorería')){?>
<?
$campo = JRequest::getVar('campo', '', 'post');
$mes = JRequest::getVar('mes', '', 'post');
$anio = JRequest::getVar('anio', '', 'post');?>
<script>
function confirmar(url){ 
	pregunta = confirm(""); 
	if (pregunta)
		location.href = url;
	else 
		return false;
	}
function confirma(id){
    var url = 'index.php?option=com_erp&view=tesoreriareporte&layout=compraelimina&id='+id;
    jQuery('.modal-title').html('<i class="icon-ban-circle"></i> ¿Está seguro de eliminar este registro?');
    jQuery('.modal-body').html(''
                               );
    jQuery('.modal-footer').html('<a class="btn btn-success" href="'+url+'"><em class="fa fa-check"></em> Retirar Suspensión</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
    jQuery('#ventanaModal').trigger('click');
}


// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
        changeYear: true,
        maxDate: "+1y",
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
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar_txt.php');
		else
		jQuery('#export').attr('action', 'components/com_erp/views/facturacion/tmpl/exportar.php');
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
    .alineado{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    .alineado{
        display: block;
    }
    .exel{
        display: none;
    }
    /* Force table to not be like tables anymore */
    .thumbnail{
        width: 100px;
    }
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 49% !important; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: "Fecha:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Nº Factura:"; font-weight: bold;}
	td:nth-of-type(3):before { content: ""; font-weight: bold;}
	td:nth-of-type(4):before { content: "Razón Social:"; font-weight: bold;}
	td:nth-of-type(5):before { content: "NIT:"; font-weight: bold;}
	td:nth-of-type(6):before { content: "Nº Autorización:"; font-weight: bold;}
	td:nth-of-type(7):before { content: "Monto:"; font-weight: bold;}
	td:nth-of-type(8):before { content: "Importe CF:"; font-weight: bold;}
	td:nth-of-type(9):before { content: "Cod. Control:"; font-weight: bold;}
	td:nth-of-type(10):before { content: "Acciones:"; font-weight: bold;}
}    
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-opencart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Compras</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <div class="col-xs-12">
              <form action="" method="post">
                <br />
                Filtro: 
                <span class="alineado">
                <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                     <select name="mes" id="mes" class="form-control">
                      <option value="">-- Mes --</option>
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
                    <select name="anio" id="anio" class="form-control">
                      <option value="">-- Año --</option>
                      <? for($i=2014; $i<=date('Y'); $i++){?>
                      <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
                      <? }?>
                    </select>
                    <select name="sucursal" class="form-control">
                      <option value=""> -- Sucursal -- </option>
                      <? foreach(getSucursales() as $suc){?>
                      <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
                      <? }?>
                    </select>
                </span>
                <span class="col-xs-12 col-sm-4">
                    <label style="display: inline"><input type="checkbox" onClick="rangoFecha()" name="rango" id="rango" value="1" style="display: inline"> Elegir rango de fechas: </label> <br>
                    <div class="col-xs-12">
                        Desde: <input type="text" id="fecha_ini" disabled name="fecha_ini" class="form-control datepicker" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>" style="display: inline-block;">
                        Hasta: <input type="text" id="fecha_fin" disabled name="fecha_fin" class="form-control datepicker" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>" style="display: inline-block; margin-left: 2px;">
                    </div>
                </span>
                <div class="col-xs-12 col-sm-2">
                    <label style="display:inline"><input name="campo" type="radio" style="display:inline" value="empresa" <?=$campo==empresa||!$_POST?'checked="checked"':''?>> Nombre</label>
                    <label style="display:inline"><input type="radio" name="campo" value="nit" <?=$campo==nit?'checked="checked"':''?> style="display:"> NIT</label>
                </div>
                <br />
                <div class="col-xs-12 col-sm-4">
                    <button class="btn btn-info" type="submit">Filtrar</button>
                    <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&layout=compras">Limpiar</a>
                </div>
              </form>
          </div>
          <div class="span3" style="text-align:right">
            <form action="components/com_erp/views/tesoreriareporte/tmpl/reporte_compra.php" id="export" method="post">
              <input type="hidden" name="f_rango" value="<?=JRequest::getVar('rango', '', 'post')?>">
              <input type="hidden" name="f_mes" value="<?=JRequest::getVar('mes', '', 'post')?>">
              <input type="hidden" name="f_anio" value="<?=JRequest::getVar('anio', '', 'post')?>">
              <input type="hidden" name="f_sucursal" value="<?=JRequest::getVar('sucursal', '', 'post')?>">
              <input type="hidden" name="f_fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>">
              <input type="hidden" name="f_fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
              <input type="hidden" name="f_campo" value="<?=JRequest::getVar('campo', '', 'post')?>">
              <input type="hidden" name="f_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
              <button class="btn btn-success" type="submit"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
              <button class="btn btn-info" type="button" onClick="exportaLC(1)">Exportar a Facilito</button>
            </form>
          </div>
        </div>
	  </div>
    <table class="table table-bordered table-striped table_vam" id="tabladinamica">
        <thead>
            <tr>
                <th width="70">Fecha</th>
                <th width="100">N&ordm; de Factura</th>
                <th>Razón Social</th>
                <th width="100">NIT</th>
                <th width="120">N&ordm; Autorización</th>
                <th width="100">Monto</th>
              <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <? 
            $total = 0;
            $totalcf = 0;
            foreach(getCompras() as $factura){
                /*echo '<pre>';
                print_r($factura);
                echo '</pre>';*/
                $nombre = explode(' ', $factura->name);
                $nom = '';
                foreach($nombre as $n)
                    $nom.= $n[0];
                $nom = ucwords($nom);
                $total+= $factura->total;
                $totalcf+= $factura->total - $factura->nocredito?>
            <tr>
                <td><?=fecha($factura->fecha_emision)?></td>
                <td><?=$factura->numero?></td>
                <td><strong><?=$factura->empresa?></strong></td>
                <td><?=$factura->nit?></td>
                <td><?=$factura->autorizacion?></td>
                <td class="text-right"><?=num2monto($factura->total)?></td>
                <td>
                    <a href="index.php?option=com_erp&view=tesoreriareporte&layout=compraedita&id=<?=$factura->id?>" data-toggle="tooltip" class="btn btn-success" title="Editar compra"><em class="fa fa-pencil"></em></a>
                    <button data-backdrop="static" type="button" onClick="confirma('<?=$factura->id?>')" class="btn btn-danger" title="Eliminar compra"><em class="fa fa-trash"></em></button>
                </td>
            </tr>
            <? }?>
        </tbody>
        <tfoot>
            <tr>                
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>Total</th>
                <th class="text-right"><?=num2monto($total)?></td>
              </td>                      <th>                
            </tr>
        </tfoot>
    </table>
      
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
<? }else{
    vistaBloqueada();
}?>