<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Productos')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-remove"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Anular Factura</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form" onSubmit="return verificarFormu(this);">
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Motivo <i class="fa fa-asterisk text-red"></i>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <textarea name="motivo" class="form-control validate[required]" width="400px"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-offset-2">
                <button class="btn btn-warning col-xs-12 col-sm-3" type="submit"><i class="fa fa-remove"></i> Anular factura</button>
            </div>
        </form>
        <? }else{
            anulaFactura();?>
            <h3>La factura fue anulada</h3>
          <script>
            setTimeout(function(){
              window.parent.cierraventana('<?=JRequest::getVar('id', '', 'get')?>');
            }, 2000);
          </script>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>