<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
 <div class="row">
  <section class="col-lg-12" style="position:absolute;">
    <div class="box box-success" style="border: 1px solid #666; border-radius: 5px; width: 420px; background: #FFFFFF;
">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Productos</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="pull-right">
        <a onClick="parent.cerrarVentana('lista_producto_0')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
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
                    <td><? //print_r($producto);?>
                    <a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->price?>')"><?=$producto->codigo?></a></td>
                    <td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->price?>')"><?=$producto->name?></a></td>
                </tr>
                <? }}?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<!-- FIN -->