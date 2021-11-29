<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
$categoria = getCategoria();
$session = JFactory::getSession();
$ext = $session->get('extension');?> 
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar categoría</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
             <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-3 control-label">
                        Nombre <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="text" name="name" id="name" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" value="<?=$categoria->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-xs-12 col-sm-3 control-label">
                        Categoría Padre
                    </label>
                    <div class="col-xs-12 col-sm-9">
                        <select name="category_id" id="category_id" class="select2 form-control" data-placeholder="Seleccione una categoría">
                            <option value=""></option>
                            <?=printCategorias(0, 'option', 0, $categoria->parent_id)?>
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
                            <option value="Producto Inventariado" <?=$categoria->tipo=='Producto Inventariado'?'selected':''?>>Producto Inventariado</option>
                            <option value="Producto No Inventariado" <?=$categoria->tipo=='Producto No Inventariado'?'selected':''?>>Producto No Inventariado</option>
                            <option value="Servicio" <?=$categoria->tipo=='Servicio'?'selected':''?>>Servicio</option>
                        </select>
                    </div>
                </div>
                <? if($ext['pos']->habilitado == 1){?>
                 <label for="" class="col-xs-12 col-sm-3 control-label">
                    Adicional a un producto <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-4">
                    <label style="display:inline"><input style="display:inline" type="radio" name="adicional" id="radio" value="1" <?=$categoria->adicional==1?'checked="checked"':''?>> Si</label>
                    &nbsp;&nbsp;&nbsp;
                    <label style="display:inline"><input style="display:inline" name="adicional" type="radio" id="radio" value="0" <?=$categoria->adicional==0?'checked="checked"':''?>> No</label>
                 </div>                  
                <? }?>
                <div class="col-xs-12 col-sm-offset-3">
                    <input type="submit" name="submit" id="submit" value="Guardar" class="btn btn-success">
                    <a href="index.php?option=com_erp&view=productosadmcategorias" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
                </div>
            </form>
            <? }else{
                    editCategoria();?>
                    <h3>La categoría fue editada correctamente</h3>
                    <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=productosadmcategorias'"></p>
                    <?
              }?>
      </div>      
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>