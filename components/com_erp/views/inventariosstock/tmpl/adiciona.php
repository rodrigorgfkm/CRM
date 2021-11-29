<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<?
$producto = getProducto()?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Adiciona Cantidad de Producto</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td width="200">Nombre</td>
                    <td><input type="text" name="name" id="name" class="form-control" value="<?=$producto->name?>" readonly></td>
                  </tr>
                  <tr>
                    <td>Existencia diaria</td>
                    <td><input name="cantidad" type="text" id="cantidad" class="form-control" placeholder="0"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Adicionar cantidad</a>
                    </td>
                  </tr>
                </tbody>
              </table>
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
<? }else{vistaBloqueada(); }?>