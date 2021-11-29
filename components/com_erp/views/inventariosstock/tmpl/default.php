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
        <h3 class="box-title">Stock de Productos</h3>
      </div>
      <div class="box-body">
        <div class="row-fluid" style="margin-bottom:10px; padding:4px; border:1px solid #CCC; border-radius:4px">
            <div class="col-xs-6"> 
            </div>
            <div class="span6" style="text-align:right">
              <a href="index.php?option=com_erp&view=clientes&layout=destacados" class="btn btn-success"><em class="fa fa-plus"></em> Orden de commpra</a>
              <a href="index.php?option=com_erp&view=clientes&layout=destacados" class="btn btn-success"><em class="fa fa-plus"></em> Solicitud de productos</a>
              <a href="index.php?option=com_erp&view=clientes&layout=destacados" class="btn btn-success"><em class="fa fa-plus"></em> Solicitud de productos</a>
            </div>
        </div>
        <table class="table table-bordered table-striped table_vam" id="tabladinamicaordenada">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th width="100">Categoría</th>
                    <th width="60">Unidad</th>
                    <th width="60">Precio</th>
                    <th width="70">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProductos() as $producto){?>
                <tr>
                    <td><?=$producto->name?></td>
                    <td><?=$producto->category?></td>
                    <td><?=$producto->unidad?></td>
                    <td><?=round($producto->price)?></td>
                    <td style="text-align:center">
                        <a class="btn btn-info" href="index.php?option=com_erp&view=productos&layout=publica&estado=<?=$producto->published?>&id=<?=$producto->id?>"><i class="icon-list icon-white"></i> Detalle</a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
        <div class="row-fluid" style="margin-top:10px; padding:4px; border:1px solid #CCC; border-radius:4px">
            <div class="col-xs-6"> 
            </div>
            <div class="span6" style="text-align:right">
              <a href="index.php?option=com_erp&view=clientes&layout=destacados" class="btn btn-success"><em class="fa fa-plus"></em> Orden de commpra</a>
            </div>
        </div>
    </div>
    </div>

    <!-- hide elements (for later use) -->
    <div class="hide">
    <!-- actions for datatables -->
    <div class="dt_gal_actions">
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="#" class="delete_rows_dt" data-tableid="dt_gal"><i class="icon-trash"></i> Eliminar</a></li>
                <li><a href="javascript:void(0)"><i class="icon-eye-open"></i> Publicar</a></li>
                <li><a href="javascript:void(0)"><i class="icon-eye-close"></i> Despublicar</a></li>
            </ul>
        </div>
    </div>
    <!-- confirmation box -->
    <div id="confirm_dialog" class="cbox_content">
        <div class="sepH_c tac"><strong>&iquest;Está seguro de eliminar este producto?</strong></div>
        <div class="tac">
            <a href="#" class="btn btn-default confirm_yes">Si</a>
            <a href="#" class="btn confirm_no">No</a>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>