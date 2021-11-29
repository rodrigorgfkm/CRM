<?php defined('_JEXEC') or die;?>
<? if(validaAcceso("Creación de facturas")){?>
<? $id = JRequest::getVar('id', '', 'post');?>
<!-- INICIO -->
<div class="row" style="width:400px">
  <section class="col-lg-12">
    <div class="box box-success" style="border:1px solid #666; border-radius: 5px">
      <div class="box-header">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Productos</h3>
        <div class="pull-right">
            <a onClick="parent.cerrarVentana('lista_producto_<?=$id?>')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th width="80">Codigo</th>
                    <th width="200">Producto</th>
                    <th width="100">Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProductosCodigo() as $producto){
                      if($producto->published == 1){
                          $n++;
                      ?>
                <tr>
                    <td><?=$producto->codigo?></td>
                    <td><?=$producto->name?></td>
                    <td>
					  <select class="form-control" id="precio_<?=$producto->id?>">
                        <? foreach(getProductoPrecios($producto->id) as $p){?>
                        <option value="<?=$p->price?>"><?=num2monto($p->price)?> (<?=$p->nombre?>)</option>
                        <? }?>
                      </select>
                    </td>
                    <td><a class="btn btn-success btn-xs" onClick="cargaProducto('<?=$id?>','<?=$producto->id?>','<?=$producto->description?>','<?=$producto->codigo?>',jQuery('#precio_<?=$producto->id?>').val(),'<?=$producto->id_ctacontable?>')">Cargar</a></td>
                </tr>
                <? }}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<!-- FIN -->
<? }else{vistaBloqueada();}?>