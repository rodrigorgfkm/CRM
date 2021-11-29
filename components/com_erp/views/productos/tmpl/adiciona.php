<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$producto = getProducto()?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-cart-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Adiciona Cantidad de Productos</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2">
                      Nombre <i class="fa fa -asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="name" id="name" class="form-control validate[required]" value="<?=$producto->name?>" readonly>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2">
                      Existencia Diaria <i class="fa fa -asterisk text-red"></i>
                  </label>
                  <div class="col-xs-12 col-sm-10">
                      <input name="cantidad" type="text" id="cantidad" class="form-control validate[required]" placeholder="0">
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-plus"></i> Adicionar cantidad</button>
              </div>               
            </form>
            <? }else{
                addProducto();?>
                <h3>La cantidad fue adicionada al producto correctamente</h3>
                <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=productos&Itemid=802'"></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>