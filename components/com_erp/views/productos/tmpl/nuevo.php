<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<? if(validaAcceso('Registro de Productos')){?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listaproductos&tmpl=component', width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html, id_aux){
	jQuery('#cuenta_debe').val(nombre);
	jQuery('#cuenta_debe_id').val(id);
	jQuery('#cuenta_aux_id').val(id_aux);
	}
</script>
<style>
    .precio{
        width: 40%;
    }
    .pdes{
        display: flex;
        padding-left: 8px;
    }
    @media
only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
    .precio{
        width: 100%;
    }
    .pdes{
        display: block;
    }     
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa  fa-cart-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Producto</h3>
      </div>
      
	  <?
      $lim_cod = 10;
      $lim_nombre = 50;
      $lim_descrip = 250;
      $lim_p_desc = 50;
      $lim_prec = 60;      
      if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
              <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Código <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input type="text" name="codigo" id="codigo" class="form-control validate[required, maxSize[<?=$lim_cod?>]]" style="text-transform:uppercase">
                   </div>              
                   <label for="" class="col-xs-12 col-sm-2">
                       Nombre <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input type="text" name="name" id="name" class="form-control validate[required, maxSize[<?=$lim_nombre?>]]">
                   </div>
               </div>
              <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Descripción
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                   </div>
                   <label for="" class="col-xs-12 col-sm-2">
                       Imagen
                   </label>
                   <div class="col-xs-12 col-sm-4">
                      <input type="file" name="imagen" id="imagen"><br>
                      <small><em>La imágen debe ser mayor a 300 px de alto x 300px de ancho</em></small>
                   </div>
               </div>
              <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Categoría <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <select name="category_id" id="category_id" class="select2 form-control validate[required]">
                          <option value=""></option>
                          <?=printCategorias(0, 'option', 0, $producto->category_id)?>
                      </select>
                   </div>
                   <label for="" class="col-xs-12 col-sm-2">
                       Unidad
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <select name="id_unidad" id="id_unidad" class="select2 form-control">
                          <option value=""></option>
                          <? foreach(getUnidades() as $unidad){?>
                              <option value="<?=$unidad->id?>"><?=$unidad->unidad?></option>
                          <? }?>
                      </select>
                   </div>
               </div>
              <!-- <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Cuenta contable <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-4">
                       <input name="cuenta_debe" type="text" id="cuenta_debe" readonly style="cursor:pointer; background:#fff" class="form-control validate[required]" placeholder="" onClick="popup(this.id)">
                       <input name="cuenta_debe_id" type="hidden" id="cuenta_debe_id">
                       <input name="cuenta_aux_id" type="hidden" id="cuenta_aux_id">
                   </div>
              </div> -->
              <div class="form-group">
                    <div class="col-xs-12 col-sm-6">
                        <label for="" class="col-xs-12 col-sm-4">
                            Precio <i class="fa fa-asterisk text-red"></i>
                        </label>
                        <div class="col-xs-12 col-sm-8 pdes">
                            <input name="p_descripcion[]" type="text" id="p_descipcion" class="form-control validate[required, maxSize[<?=$lim_p_desc?>]]" placeholder="Nombre o Descripción">
                            <input name="precio_base[]" type="number" step="any" id="precio_base" class="precio form-control validate[required, maxSize[<?=$lim_prec?>]]" placeholder="0.00">
                        </div>
                        <div class="col-xs-12">
                            <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarprecionom"><i class="fa fa-plus"></i> Agregar</button>
                        </div>
                   </div>                  
              </div>
          </div>
          <div class="box-footer">
              <a href="index.php?option=com_erp&view=productos" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Productos</a>
              <button type="reset" class="btn btn-warning"><em class="fa fa-refresh"></em> Reestablecer datos</button>
              <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Crear Producto</button>
          </div>
      </form>
      <? }else{?>
      <div class="box-body">
          <? newProducto();?>
          <h3>El producto fue creado correctamente</h3>
          <p>
              <a class="btn btn-info" href="index.php?option=com_erp&view=productos">
                  <em class="fa fa-arrow-left"></em>
                  Volver
              </a>
          </p>
      </div>
	  <? }?>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>