<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
 <div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Productos</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>
        </div>
      </div>
     <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th width="80">Codigo</th>
                    <th width="200">Producto</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProductosCodigo() as $producto){
                      if($producto->published == 1){
                          $n++;
                      ?>
                <tr>
                    <td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->precio?>')"><?=$producto->codigo?></a></td>
                    <td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->precio?>')"><?=$producto->name?></a></td>
                </tr>
                <? }}?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>