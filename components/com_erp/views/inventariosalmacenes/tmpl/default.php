<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Almacenes</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable" id="tabladinamica">
        <thead>
          <tr>
            <th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
            <th>Almacen</th>
            <th width="100">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getAlmacenes() as $almacen){?>
          <tr>
            <td><input type="checkbox" name="row_sel" class="row_sel" /></td>
            <td><strong>
              <?=$almacen->almacen?>
            </strong></td>
            <td>
                <a href="index.php?option=com_erp&view=inventariosalmacenes&layout=edita&id=<?=$almacen->id?>" class="sepV_a" title="Edit"><i class="fa fa-pencil"></i></a>
                <a href="index.php?option=com_erp&view=inventariosalmacenes&layout=elimina&id=<?=$almacen->id?>" title="Delete"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>