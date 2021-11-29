<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Contabilidad Comprobante nuevo')){?>
<?
$campo = JRequest::getVar('campo', '', 'post');
$mes = JRequest::getVar('mes', '', 'post');
$anio = JRequest::getVar('anio', '', 'post');
$id = explode('_',$_GET['id']);?>
<script>
function carga(id_factura, cliente, total){
	id = '<?=$id[1]?>';
	window.parent.carga(id, id_factura, cliente, total, 2);
	window.parent.Shadowbox.close();
	}
</script>
<style>
    .filter_c{
        display: inline-block;
        width: 65%;
    }
    .botones{
        width: 32%;
        display: inline-block;
    }
    .filter_c>input{
        display: inline-block;
        width: auto;
    }
    .filter_c>select{
        display: inline-block;
        width: auto;
    }
@media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1023px)  {
    .filter_c{
        display: block;
        width: 100%;
    }
    .botones{
        width: 100%;
        display: block;
        padding-top: 5px;
    }
    .filter_c>input{
        display: block;
        width: 100%;
    }
    .filter_c>select{
        display: block;
        width: 100%;
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
		padding-left: 33% !important; 
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
	td:nth-of-type(1):before {content: 'Fecha: '}
	td:nth-of-type(2):before { content: "Nº Fact: "; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/	
	td:nth-of-type(3):before { content: "Suc."; font-weight: bold}
	td:nth-of-type(4):before { content: "Tipo: "; font-weight: bold}
	td:nth-of-type(5):before { content: "Razón Social: "; font-weight: bold}
	td:nth-of-type(6):before { content: "NIT: "; font-weight: bold}
	td:nth-of-type(7):before { content: "Monto: "; font-weight: bold}
	td:nth-of-type(8):before { content: "Acciones: "; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Compras</h3>
      </div>
      <div class="box-body">
        <form action="" method="post">
            <div class="filter_c">
                Filtro: <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                <select name="mes" class="form-control">
                  <option value="">Mes</option>
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
                  <option value=""></option>
                  <? for($i=2013; $i<=date('Y'); $i++){?>
                  <option value="<?=$i?>" <?=$anio==$i?'selected':''?>><?=$i?></option>
                  <? }?>
                </select>
            </div>
            <div class="botones">
                <label style="display:inline"><input name="campo" type="radio" style="display:inline" value="empresa" <?=$campo==empresa||!$_POST?'checked="checked"':''?>> Nombre</label>
                <label style="display:inline"><input type="radio" name="campo" value="nit" <?=$campo==nit?'checked="checked"':''?> style="display:inline"> NIT</label>
                <button class="btn btn-info" type="submit">Filtrar</button>
                <a class="btn btn-warning" href="index.php?option=com_erp&view=contacomprobantes&layout=listacompra&tmpl=component">Limpiar</a>
            </div>
          </form>
      </div>
    </div>

<table class="table table-bordered table-striped table_vam" id="dt_gal">
    <thead>
        <tr>
            <th width="70">Fecha</th>
            <th width="90">N&ordm; de Factura</th>
            <th>Razón Social</th>
            <th width="100">NIT</th>
            <th width="60">Monto</th>
            <th width="100">Cód de Control</th>
          <th width="80">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <? foreach(getCompras() as $factura){
              if(is_null($factura->id_compra)){
              ?>
        <tr>
            <td><?=fecha($factura->fecha_emision)?></td>
            <td><?=$factura->numero?></td>
            <td><strong><?=$factura->empresa?></strong></td>
            <td><?=$factura->nit?></td>
            <td><?=$factura->total?></td>
            <td><?=$factura->codigo?></td>
            <td>
                <!--<a onClick="carga('<?=$factura->id?>', '<?=filtroCadena($factura->empresa)?>', '<?=$factura->total?>')" class="btn btn-info span12"><i class="icon-plus icon-white"></i> Cargar</a>-->
                <a href="index.php?option=com_erp&view=contacomprobantes&layout=listacompracarga&id=<?=$factura->id?>&n=<?=JRequest::getVar('n', '', 'get');?>&tmpl=blank" class="btn btn-info btn-xs"><i class="icon-plus"></i> Cargar</a>
            </td>
        </tr>
        <? }}?>
    </tbody>
</table>
      </div>      
    </div>
  </section>
</div>
              
<? }else{vistaBloqueada();}?>