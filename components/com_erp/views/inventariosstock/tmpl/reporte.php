<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reportes</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid">
          <div class="col-xs-9">
              <form action="" method="post">
                Filtro: <input type="text" name="filtro" class="form-control" value="<?=JRequest::getVar('filtro', '', 'post')?>">
                <select name="categoria" id="categoria" class="seleect2 form-control">
                    <option value=""></option>
                    <?=printCategorias(0, 'option', JRequest::getVar('categoria', '', 'post'))?>
                </select>
                <button class="btn btn-info" type="submit">Filtrar</button>
                <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacion&layout=compras">Limpiar</a>
              </form>
          </div>
          <div class="col-xs-3" style="text-align:right">
            <form action="components/com_erp/views/productos/tmpl/exportar.php" method="post">
              <button class="btn btn-success" type="submit">Exportar a Excel</button>
              <input type="hidden" name="filtro_categoria" value="<?=JRequest::getVar('categoria', '', 'post')?>">
              <input type="hidden" name="filtro_cadena" value="<?=JRequest::getVar('filtro', '', 'post')?>">
            </form>
          </div>
        </div>
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
<? }else{vistaBloqueada(); }?>