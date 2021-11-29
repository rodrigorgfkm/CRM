<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');
?>
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
<?
$id = JRequest::getVar('id','','get');
$producto = getProducto();
$lim_cod = 10;
$lim_nombre = 50;
$lim_descrip = 250;
$lim_p_desc = 50;
$lim_prec = 60;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Producto</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Código <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                 <input type="text" name="codigo" id="codigo" class="form-control validate[required,maxSize[<?=$lim_cod?>]]" value="<?=$producto->codigo?>">
             </div>
             <label for="" class="col-xs-12 col-sm-2">
                 Nombre <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                 <input type="text" name="name" id="name" class="form-control validate[required, maxSize[<?=$lim_nombre?>]]"value="<?=$producto->name?>">
             </div>
         </div>
         <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Descripción <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                 <textarea name="descripcion" id="descripcion" class="form-control validate[required, maxSize[<?=$lim_descrip?>]]"><?=$producto->description?></textarea>
             </div>
             <label for="" class="col-xs-12 col-sm-2">
                 Imagen <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                <? if($producto->image != ''){?>
                <img src="media/com_erp/productos/<?=$producto->image?>" width="90" />
                <? }?>
                <input type="file" name="imagen" id="imagen"><br>
                <small><em>La imágen debe ser mayor a 300 px de alto x 300px de ancho</em></small>
             </div>
             <label for="" class="col-xs-12 col-sm-2">
                 Precio <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
                 <input name="precio_base" type="text" id="precio_base" class="form-control validate[required]" value="<?=$producto->price?>" placeholder="0.00">
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
                        <option value="<?=$unidad->id?>" <?=$producto->id_unidad==$unidad->id?'selected':''?>><?=$unidad->unidad?></option>
                    <? }?>
                </select>
             </div>
         </div>
         <!-- <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
               Cuenta contable <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-4">
              <? 
			  $cta = getCNTcuenta($producto->id_ctacontable);
			  $aux = getCNTcuenta($producto->id_auxiliar);
			  $nombrecta = $cta->nombre;
			  if($producto->id_auxiliar != 0)
			  	$nombrecta.= '('.$aux->nombre.')';
			  ?>
               <input name="cuenta_debe" type="text" id="cuenta_debe" value="<?=$nombrecta?>" readonly style="cursor:pointer; background:#fff" class="form-control validate[required]" placeholder="" onClick="popup(this.id)">
               <input name="cuenta_debe_id" type="hidden" id="cuenta_debe_id" value="<?=$producto->id_ctacontable?>">
               <input name="cuenta_aux_id" type="hidden" id="cuenta_aux_id" value="<?=$producto->id_auxiliar?>">
             </div>
         </div> -->
         <div class="form-group">
                <div class="col-xs-12 col-sm-6">
                   <? foreach (getProductoPrecios($id) as $price){?>
                    <label for="" class="col-xs-12 col-sm-4">
                        Precio <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-xs-12 col-sm-8 pdes">
                        <input name="p_descripcion[]" type="text" id="p_descipcion" class="form-control validate[required, maxSize[<?=$lim_p_desc?>]]" placeholder="Nombre o Descripción" value="<?=$price->nombre?>">
                        <input name="precio_base[]" type="number" step="any" id="precio_base" class="precio form-control validate[required, maxSize[<?=$lim_prec?>]]" placeholder="0.00" value="<?=$price->price?>">
                    </div>
                    <div class="col-xs-12">
                        <button type="button" class="btn bg-purple btn-sm col-xs-12 col-sm-3 pull-right" id="agregarprecionom"><i class="fa fa-plus"></i> Agregar</button>
                    </div>
                   <? }?>
               </div>                  
          </div>
         <div class="col-xs-12 col-sm-offset-2">
             <a onClick="history.back(-1)" class="btn btn-info btn-sm col-xs-6 col-sm-3"><i class="fa fa-arrow-left"></i> Volver</a>
             <button type="submit" class="btn btn-success btn-sm col-xs-6 col-sm-3"><i class="fa fa-refresh"></i> Actualizar producto</button>
         </div>
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
<? }else{
    vistaBoqueada();
 }?>