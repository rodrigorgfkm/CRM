<?php defined('_JEXEC') or die;
if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){
$id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
<div class="row">
  <section class="col-md-5">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px;width:350px;">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Productos</h3>
        <div class="text-right">
            <a onClick="parent.cerrarVentana('lista_producto_<?=$id?>')" class="btn btn-danger btn-mini"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped">
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
                        <td><a style="cursor:pointer" onClick="parent.cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->name?>','<?=$producto->codigo?>','<?=$producto->price?>')"><?=$producto->codigo?></a></td>
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
<?
    }else{ vistaBloqueada();}
?>