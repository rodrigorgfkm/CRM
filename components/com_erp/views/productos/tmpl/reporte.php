<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<style>
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
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
		padding-left: 27% !important; 
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
	td:nth-of-type(1):before { content: "Nombre:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/	
	td:nth-of-type(2):before { content: "Categoría:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Unidad:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Precio:"; font-weight: bold}	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>
        <div class="col-xs-12">
          <div class="col-xs-12 col-sm-4">
              <form action="" method="post">
                Filtro: <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                <select name="categoria" id="categoria" class="select2 form-control">
                    <option value=""></option>
                    <?=printCategorias(0, 'option', JRequest::getVar('categoria', '', 'post'))?>
                </select>
                <button class="btn btn-info" type="submit">Filtrar</button>
                <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&layout=compras">Limpiar</a>
              </form>
          </div>
          <div class="col-xs-12 text-right">
            <form action="components/com_erp/views/productos/tmpl/exportar.php" method="post">
              <button class="btn btn-success xcel" type="submit">Exportar a Excel</button>
              <input type="hidden" name="filtro_categoria" value="<?=JRequest::getVar('categoria', '', 'post')?>">
              <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
            </form>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th width="100">Categoría</th>
                    <th width="60">Unidad</th>
                    <th width="60">Precio</th>
                    <? if($ext['pos']->habilitado == 1){?>
                    <? }?>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProductos() as $producto){
                      $terminal = getTerminalProducto($producto->id);
                      if($producto->published == 1)
                        $estado = 'open';
                        else
                        $estado = 'close';

                      if($producto->destacado == 1)
                        $destacado = 'up';
                        else
                        $destacado = 'down';
                        ?>
                <tr>
                    <td><?=$producto->name?></td>
                    <td><?=$producto->category?></td>
                    <td><?=$producto->unidad?></td>
                    <td><?=round($producto->price)?></td>
                    <? if($ext['pos']->habilitado == 1){?>
                    <? }?>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
            <style>
            	#tabladinamica_filter{ display: none}
            </style>
<? }else{
    vistaBloqueada();
}?>