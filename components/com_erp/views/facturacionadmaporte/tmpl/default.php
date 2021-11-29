<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){
	$ap = getAporteCta();?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=lista&tmpl=component&id='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	jQuery('#'+id_html).val(nombre);
	jQuery('#'+id_html+'_id').val(id);
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
        <h3 class="box-title">Relacionar Aportes con Cuenta Contable</h3>
      </div>
      <? if(!$_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
              <div class="form-group">
              	<label for="" class="col-xs-12 col-sm-2">
                    Cuenta contable
                </label>
                <div class="col-xs-12 col-sm-10">
                	<input name="cuenta_debe" type="text" id="cuenta_debe" readonly style="cursor:pointer; background:#fff" class="form-control" placeholder="" onClick="popup(this.id)" value="<?=$ap->nombre?>">
                    <input name="cuenta_debe_id" type="hidden" id="cuenta_debe_id" value="<?=$ap->id?>">
                </div>
              </div>
          </div>
          <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Modificar</button>
          </div>
      </form>
      <? }else{
		  changeAporteCta();?>
      <div class="box-body">
      	<h3>El producto fue creado correctamente</h3>
          <p>
              <a class="btn btn-info" href="index.php?option=com_erp&view=facturacionadmaporte">
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