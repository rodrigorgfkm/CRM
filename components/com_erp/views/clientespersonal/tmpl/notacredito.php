<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Recibos')){?>
<?
$producto = getProducto()?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-sticky-note-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear nota de crédito</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                 Cliente <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <select name="id_cliente" class="select2 form-control validate[required]">
                        <option value=""></option>
                        <? foreach(getClientes() as $cliente){?>
                        <option value="<?=$cliente->id?>">
                            <?=$cliente->empresa==''?$cliente->apellido.' '.$cliente->nombre:$cliente->empresa?>
                        </option>
                        <? }?>
                    </select>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                 Monto de crédito <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <input name="monto" type="text" id="monto" class="form-control validate[required]" placeholder="0">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2">
                 Detalle <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                  <textarea name="detalle" class="form-control validate[required]"></textarea>
              </div>
          </div>
          <div class="col-xs-12 col-sm-offset-2">
              <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Crear nota de crédito</button>
          </div>
        </form>
        <? }else{
            addClienteNotacredito();?>
            <h3>La nota de crédito fue creada correctamente</h3>
            <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=clientes&layout=estadocuenta&Itemid=802'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>