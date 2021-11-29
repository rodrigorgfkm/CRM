<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Compras y Ventas') or validaAcceso('Administrador Tesorería')){
    $session = JFactory::getSession();
    $pag = JRequest::getVar('p', 1, 'get');
?>
<script>
// Setter
jQuery(function () {
	
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
    jQuery('#rango').on('click', function(){
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
})
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
    @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px){
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
<?
if(JRequest::getVar('l', '', 'get') == 1){
		$session->clear('filtro');
		$session->clear('mes');
		$session->clear('anio');
		$session->clear('estado');
		$session->clear('s');
		$session->clear('u');
		$session->clear('t');
        $session->clear('rango');
        $session->clear('fecha_ini');
        $session->clear('fecha_fin');
        $session->clear('campo');
    echo '<script>
        location.href= "index.php?option=com_erp&view=tesoreriareporte&layout=ventas"
    </script>';
    }else{
        if($_POST){
            $session->set('filtro', JRequest::getVar('filtro', '', 'post'));
            $session->set('mes', JRequest::getVar('mes', '', 'post'));
            $session->set('anio', JRequest::getVar('anio', '', 'post'));
            $session->set('estado', JRequest::getVar('estado', '', 'post'));
            $session->set('rango', JRequest::getVar('rango', '', 'post'));
            $session->set('s', JRequest::getVar('sucursal', checksucursalPred(), 'post'));
            $session->set('u', JRequest::getVar('usuario', '', 'post'));
            $session->set('t', JRequest::getVar('tipo', '', 'post'));
            $session->set('fecha_ini', JRequest::getVar('fecha_ini', '', 'post'));
            $session->set('fecha_fin', JRequest::getVar('fecha_fin', '', 'post'));
            $session->set('campo', JRequest::getVar('campo', '', 'post'));
        }
    }
	$filtro = $session->get('filtro');
	$mes = $session->get('mes');
	$anio = $session->get('anio');
	$estado = $session->get('estado');
	$s = $session->get('s')=='' ? checksucursalPred() : $session->get('s');
	$u = $session->get('u');
	$t = $session->get('t');
	$rango = $session->get('rango');
	$desde = $session->get('fecha_ini');
	$hasta = $session->get('fecha_fin');
	$campo = $session->get('campo');
    
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>
      </div>
      <div class="box-body">
        <div class="row filtros-tablas">
          <div class="col-md-12">
              <form action="" method="post" style="width:100%; margin-bottom: 30px;">                
                    <div class="junto">
                        <div class="dentro">Filtro:</div> 
                        <div class="dentro">
                            <input type="text" name="filtro" class="form-control" value="<?=$filtro?>">
                        </div>
                        <div class="dentro">
                            <select name="mes" id="mes" class="form-control" <?=$rango=='1'?'disabled':''?>>
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
                            <select name="anio" id="anio" class="form-control"<?=$rango=='1'?'disabled':''?>>
                              <option value=""> -- Año -- </option>
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
                            <select name="tipo"  class="form-control">
                              <option value=""> -- Tipo -- </option>
                              <? foreach(getTipoFacturas() as $tipo){
                                $tipofac = explode('|',$tipo->factura);?>
                              <option value="<?=$tipo->id?>" <?=$t==$tipo->id?'selected':''?>><?=$tipofac[0]?></option>
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
                    </div>
                    <div class="col-md-4">   
                            <label style="display:inline" class="dentro"><input name="campo" type="radio" value="p.nombre" style="display:inline" <?=$campo=='p.nombre'||!$_POST?'checked="checked"':''?>> Cliente</label>
                            <label style="display:inline" class="dentro"><input name="campo" type="radio" value="f.nombre" style="display:inline" <?=$campo=='f.nombre'||!$_POST?'checked="checked"':''?>> A nombre de</label>
                            <label style="display:inline" class="dentro"><input name="campo" type="radio" value="f.nit" <?=$campo=='f.nit'?'checked="checked"':''?> style="display:inline"> NIT</label>
                            <br>                            
                    </div>
                    <div class="col-md-8">
                        <label for="" style="margin-right:40px;"><input type="checkbox" name="rango" id="rango" value="1" <?=$rango=='1'?'checked':''?>> Por Rango</label><i></i>
                        <label for="" style="display:inline-block">Desde
                            <input type="text" <?=$rango!='1'?'disabled':''?> id="fecha_ini" class="form-control datepicker" name="fecha_ini" value="<?=$desde?>" style="margin-left: 5px; display:inline-block;width:auto;"></label>
                        <label for="" style="display:inline-block">Hasta
                            <input type="text" <?=$rango!='1'?'disabled':''?> id="fecha_fin" class="form-control datepicker" name="fecha_fin" value="<?=$hasta?>" style="margin-left: 5px; display:inline-block;width:auto;"></label>
                        <button class="btn btn-info" type="submit" style="margin-left: 5px;">Filtrar</button>
                        <a class="btn btn-warning" href="index.php?option=com_erp&view=tesoreriareporte&layout=ventas&l=1"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
                    </div>
                  </div>
                <br>
              </form>
          </div>
          <div class="col-md-12">
            <? if($_POST){?>
            <!--<form action="index.php?option=com_erp&view=tesoreriareporte&layout=exportarventas&tmpl=blank" id="export" method="post">-->
            <form action="components/com_erp/views/tesoreriareporte/tmpl/exportarventas.php" id="export" method="post">
              <!--<a  data-toggle="modal" data-target=".borratiposoc" href="#excel" class="btn btn-success pull-right xcel pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>-->
              <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
              <button class="btn btn-info pull-right" type="button" onClick="exportaLC(1)">Exportar a Facilito</button>
              <input type="hidden" name="f_filtro" value="<?=$filtro?>">
              <input type="hidden" name="f_mes" value="<?=$mes?>">
              <input type="hidden" name="f_anio" value="<?=$anio?>">
              <input type="hidden" name="f_estado" value="<?=$estado?>">
              <input type="hidden" name="f_sucursal" value="<?=$s?>">
              <input type="hidden" name="f_usuario" value="<?=$u?>">
              <input type="hidden" name="f_tipo" value="<?=$t?>">
              <input type="hidden" name="f_rango" value="<?=$rango?>">
              <input type="hidden" name="f_desde" value="<?=$desde?>">
              <input type="hidden" name="f_hasta" value="<?=$hasta?>">
              <input type="hidden" name="filtro_campo" value="<?=$campo?>">
              <input type="hidden" name="filtro_formato" value="<?=JRequest::getVar('formato', '', 'post')?>">
            </form>
            <? }?>
          </div>
        </div>        
        <div class="row-fluid">
            
           <!-- <table class="table table-bordered table-striped table_vam datatable" id="tabladinamica">-->
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
            <?
		  $cantPages = getFacturasPaginacion();
		  $url = 'index.php?option=com_erp&view=tesoreriareporte&layout=ventas';
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
      </div>
    </div>
  </section>
  
  

<!-- Modal -->
<!--<div class="modal fade borratiposoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>-->
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