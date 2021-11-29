<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Reportes Registro')){
$tipo = getTipoComp();?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Tipo de Comprobante</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">
                        Tipo de Commprobante <i class="fa fa-asterisk text-red"></i>
                    </label>
                    <div class="col-sx-12 col-sm-10">
                        <input type="text" name="tipo" id="tipo" class="form-control validate[required]" value="<?=$tipo->tipo?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-offset-2">
                    <button type="submit" name="submit" id="submit"  class="btn btn-success btn-sm col-xs-12 col-sm-3" -><i class="fa fa-check"></i> Enviar</button>
                </div>             
            </form>
            <? }else{
                editTipoComprobante();?>
                <h3>El tipo de comprobante fue editado correctamente</h3>
                <p><a class="btn btn-success" href="index.php?option=com_erp&view=contatipos">Volver</a></p>
                <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>