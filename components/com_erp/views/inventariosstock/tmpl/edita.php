<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$producto = getProducto();?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Producto</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td>Código</td>
                    <td><input type="text" name="codigo" id="codigo" class="form-control" value="<?=$producto->codigo?>"></td>
                  </tr>
                  <tr>
                    <td width="200">Nombre</td>
                    <td><input type="text" name="name" id="name" class="form-control"value="<?=$producto->name?>"></td>
                  </tr>
                  <tr>
                    <td>Descripción</td>
                    <td><textarea name="descripcion" id="descripcion" class="form-control"><?=$producto->description?></textarea></td>
                  </tr>
                  <tr>
                    <td>Precio</td>
                    <td><input name="precio_base" type="text" id="precio_base" class="form-control" value="<?=$producto->price?>" placeholder="0.00"></td>
                  </tr>
                  <tr>
                    <td>Imagen</td>
                    <td>
                        <img src="media/com_erp/productos/<?=$producto->image?>" width="90" />
                        <input type="file" name="imagen" id="imagen"><br>
                        <small><em>La imágen debe ser mayor a 300 px de alto x 300px de ancho</em></small>
                    </td>
                  </tr>
                  <tr>
                    <td>Categoría</td>
                    <td><select name="category_id" id="category_id" class="chosen-select">
                        <option value=""></option>
                        <?=printCategorias(0, 'option', 0, $producto->category_id)?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Unidad</td>
                    <td><select name="id_unidad" id="id_unidad" class="select2 form-control">
                        <option value=""></option>
                        <? foreach(getUnidades() as $unidad){?>
                        <option value="<?=$unidad->id?>" <?=$producto->id_unidad==$unidad->id?'selected':''?>><?=$unidad->unidad?></option>
                        <? }?>
                    </select></td>
                  </tr>
                  <? if($ext['pos']->habilitado == 1){?>
                  <tr>
                    <td>Categorías vinculadas</td>
                    <td><select name="id_vinculo" id="id_vinculo" class="select2 form-control">
                        <option value=""></option>
                        <? foreach(getVinculos() as $vinculo){?>
                        <option value="<?=$vinculo->id?>" <?=$producto->id_vinculo==$vinculo->id?'selected':''?>><?=$vinculo->vinculo?></option>
                        <? }?>
                    </select></td>
                  </tr>
                  <? }?>
                  <tr>
                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm"><i class="fa fafloppy-o"></i> Guardar producto</a>
                    <a onClick="history.back(-1)" class="btn btn-info btn-sm">Volver</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
            <? }else{
                editProducto();?>
                <h3>El producto fue editado correctamente</h3>
                <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=productos&Itemid=802'"></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>