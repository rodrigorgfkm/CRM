<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Compras y Ventas')){
    $session = JFactory::getSession();
	$estado = JRequest::getVar('estado', '', 'post');
	$s = JRequest::getVar('sucursal', '', 'post');
	$t = JRequest::getVar('tipo', '', 'post');
	$u = JRequest::getVar('usuario', '', 'post');
    if(JRequest::getVar('rango', '', 'post') == 1){
		$fecha_ini = $session->set('fecha_ini', JRequest::getVar('fecha_ini', '', 'post'));
		$fecha_fin = $session->set('fecha_fin', JRequest::getVar('fecha_fin', '', 'post'));
        $session->clear('mes');
        $session->clear('anio');
        $session->set('rango',JRequest::getVar('rango', '', 'post'));
    }else{
        $mes = $session->set('mes',JRequest::getVar('mes', '', 'post'));
        $anio = $session->set('anio', JRequest::getVar('anio', '', 'post'));
        $session->clear('fecha_ini');
        $session->clear('fecha_fin');
        $session->clear('rango');
    }
?>
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
		jQuery('#export').attr('action', 'index.php?option=com_erp&view=facturacion&layout=exportar_txt_ventas&tmpl=blank');
		else
		jQuery('#export').attr('action', 'index.php?option=com_erp&view=facturacion&layout=exportar_ventas&tmpl=blank');
	jQuery('#export').submit();
	}
function generalExcel(tipo){
	if(tipo == 'Normal')
		jQuery('#export').attr('action', 'index.php?option=com_erp&view=facturacion&layout=exportar_ventas&tmpl=blank&tipo=1');
		else
		jQuery('#export').attr('action', 'index.php?option=com_erp&view=facturacion&layout=exportar_ventas&tmpl=blank&tipo=0');
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
    .junto{ 
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .dentro{
        align-content: center;
        flex-grow: 1;
        padding: 5px;
    }
    .desdehasta{
        width: 200px;
    }
    @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1023px){
            .junto{
                display: block;
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
		padding-left: 30% !important; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 15px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 25px}
	td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/	
	td:nth-of-type(2){ display:none}
	td:nth-of-type(3){ display:none}	
	td:nth-of-type(4):before { content: "Fecha:"; font-weight: bold}	
	td:nth-of-type(5):before { content: "Facturado:"; font-weight: bold}	
	td:nth-of-type(6):before { content: "NIT"; font-weight: bold}	
	td:nth-of-type(7):before { content: "Monto:"; font-weight: bold}	
	td:nth-of-type(8){ margin-left:-27%;}
	td:nth-of-type(9){ margin-left:-27%;}
    th:nth-of-type(10):before { content: "total:"; font-weight: bold}	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte</h3>
      </div>
      <div class="box-body">
        <div class="row filtros-tablas">
          <div class="col-md-12">
              <form action="" method="post" style="width:100%; margin-bottom: 30px;">                
                    Filtro: 
                    <div class="junto">
                        <div class="dentro">
                            <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                        </div>
                        <div class="dentro">
                            <select name="mes" id="mes" class="form-control">
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
                        </div>
                        <div class="dentro">
                            <select name="anio" id="anio" class="form-control">
                              <option value="Año"> -- Año -- </option>
                              <? for($i=2013; $i<=date('Y'); $i++){?>
                              <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
                              <? }?>
                            </select>
                        </div>                        
                        <div class="dentro">
                            <select name="sucursal" class="form-control">
                              <option value=""> -- Sucursal -- </option>
                              <? foreach(getSucursales() as $suc){?>
                              <option value="<?=$suc->id?>" <?=$s==$suc->id?'selected':''?>><?=$suc->nombre?></option>
                              <? }?>
                            </select>
                        </div>
                        <div class="dentro">
                            <select name="usuario" class="form-control">
                              <option value=""> -- Usuario -- </option>
                              <? foreach(getOperador() as $usuario){?>
                              <option value="<?=$usuario->id?>" <?=$u==$usuario->id?'selected':''?>><?=$usuario->name?></option>
                              <? }?>
                            </select>
                        </div>
                        <div class="dentro">
                            <select name="estado" class="form-control">
                              <option value="" <?=$estado==''?'selected':''?>>Todos</option>
                              <option value="V" <?=$estado=='V'?'selected':''?>>Válidas</option>
                              <option value="A" <?=$estado=='A'?'selected':''?>>Anuladas</option>
                            </select>
                        </div>
                        <div class="dentro">
                            <div class="junto">
                                <label style="display:inline" class="dentro"><input name="campo" type="radio" value="p.nombre" style="display:inline" <?=$campo=='p.nombre'||!$_POST?'checked="checked"':''?>> Cliente</label>
                                <label style="display:inline" class="dentro"><input name="campo" type="radio" value="f.nombre" style="display:inline" <?=$campo=='f.nombre'||!$_POST?'checked="checked"':''?>> A nombre de</label>
                                <label style="display:inline" class="dentro"><input name="campo" type="radio" value="f.nit" <?=$campo=='f.nit'?'checked="checked"':''?> style="display:inline"> NIT</label>
                            </div>
                        </div>
                    </div>
                <br/>
                <div class="junto desdehasta">
                    <div class="dentro">
                        <label style="display: inline"><input type="checkbox" onClick="rangoFecha()" name="rango" id="rango" value="1" style="display: inline"> Elegir rango de fechas: </label> 
                        <div class="junto">
                            <span class="dentro">Desde
                                <input type="text" disabled id="fecha_ini" class="form-control datepicker" name="fecha_ini" value="<?=JRequest::getVar('fecha_ini', '', 'post')?>"></span>                                    
                            </span>                                
                            <span class="dentro">Hasta
                                <input type="text" disabled id="fecha_fin" class="form-control datepicker" name="fecha_fin" value="<?=JRequest::getVar('fecha_fin', '', 'post')?>">
                            </span>
                        </div>                            
                    </div>
                </div>
                <div style="padding-bottom:20px;">
                    <button class="btn btn-info col-xs-12 col-sm-3" type="submit"><i class="fa fa-filter"></i> Filtrar</button>
                    <a class="btn btn-warning col-xs-12 col-sm-3" href="index.php?option=com_erp&view=facturacion&layout=ventas"><i class="fa fa-eraser"></i> Limpiar</a>
                </div>
                <br>
              </form>
          </div>
          <div class="col-md-4">
            <form action="components/com_erp/views/facturacion/tmpl/exportar_ventas.php" id="export" method="post">
              <a  data-toggle="modal" data-target=".borratipoasdsoc" href="#easd_xcel" class="btn btn-success pull-right _xcel">Exportar a Excel</a>
              <button class="btn btn-info pull-right" type="button" onClick="exportara_LC(1)">Exportar a Facilito</button>
              <input type="hidden" name="filtro_mes" value="<?=JRequest::getVar('mes', '', 'post')?>">
              <input type="hidden" name="filtro_anio" value="<?=JRequest::getVar('anio', '', 'post')?>">
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
        <div class="row-fluid">
            <table class="table table-bordered table-striped table_vam datatable" id="tabladinamica">
                <thead>
                    <tr>
                        <th width="50">N&ordm;</th>
                        <th width="20">Suc.</th>
                        <th width="70">Fecha</th>
                        <th>Facturado a</th>
                        <th width="80">NIT</th>
                        <th width="60">Monto</th>
                        <th width="60">Estado</th>
                        <th width="120">Acciones</th>
                    </tr>
                </thead>
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
            
                          ?>
                    <tr>
                        <td><?=$factura->numero?></td>
                        <td><span style="padding:8px" class="alert alert-info" title="<?=$factura->sucursal_nombre?>"><?=$factura->sucursal_codigo?></span></td>                        
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
                        <td><a class="btn btn-<?=$estadoclass?> col-xs-12 btn-sm" style="cursor:default"><?=$estadolabel?></a></td>
                        <td>
                            <a class="btn btn-primary btn-sm col-xs-12" href="index.php?option=com_erp&view=facturacion&layout=factura&id=<?=$factura->id?>"><i class="fa fa-eye"></i> Ver factura</a>
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
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade borratiposoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Exportar a Excel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="" name="form" id="form" class="form-horizontal col-xs-12" role="form" method="get">
            <div class="col-xs-12">
            	Indique el tipo de formato que desea generar en Excel
            </div>
            <div class="col-xs-12 text-right">
                <a onClick="generalExcel('Normal')" class="btn btn-success" id="btn_confirma" data-dismiss="modal">Normal</a>
                <a onClick="generalExcel('Facilito')" href="#" class="btn btn-info" id="btn_cancela" data-dismiss="modal">Facilito</a>
            </div>
          </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
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