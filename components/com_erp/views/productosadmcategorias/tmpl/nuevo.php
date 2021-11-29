<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Categoría</h3>		
      </div>
      <?
         $lim_nom = 25;
      ?>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-3 control-label">
                        Nombre <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="text" name="name" id="name" class="form-control validate[required, maxSize[<?=$lim_nom?>]]">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-3 control-label">
                        Categoría Padre
                    </label>
                    <div class="col-xs-12 col-sm-9">
                        <select name="category_id" id="category_id" class="select2 form-control" data-placeholder="Seleccione una categoría">
                            <option value=""></option>
                            <?=printCategorias(0, 'option', 0)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-3 control-label">
                        Tipo <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-9">
                        <select name="tipo" id="tipo" class="form-control validate[required]">
                            <option value=""></option>
                            <option value="Producto de inventario">Producto  Inventariado</option>
                            <option value="Producto no inventariado">Producto No Inventariado</option>
                            <option value="Servicio">Servicio</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-offset-3">
                    <input type="submit" name="submit" id="submit"  class="btn btn-success" value="Guardar">
                </div>
            </form>
            <? }else{
                    newCategorias();?>
                    <h3>La categoría fue creada correctamente</h3>
                    <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=productosadmcategorias'"></p>
                    <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>