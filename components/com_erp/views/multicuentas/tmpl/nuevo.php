<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Nuevo Base')){?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=multicuentas&layout=listacuentas&tmpl=component&id='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, codigo_sug){
	jQuery('#id_padre_nombre').html(nombre);
	jQuery('#id_padre').val(id);
	jQuery('#codigo_padre').html(codigo);
	jQuery('#codigopadre').val(codigo);
	jQuery('#codigo').val(codigo_sug);
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Cuenta</h3>
      </div>
      <div class="box-body">
       <? $lim_cuenta = 30;?>
        <?php if(!$_POST){?>
            <form class="form-horizontal" method="post" name="form" id="form" class="form-horizontal" role="form">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Nombre de la cuenta <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                       <input name="nombre" type="text" class="form-control validate[required, maxSize[<?=$lim_cuenta?>]]" id="focusedInput">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Cuenta padre <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                       <span class="form-control uneditable-input" id="id_padre_nombre" onClick="popup(this.id)" style="cursor:pointer"></span>
                       <input type="hidden" name="id_padre" id="id_padre">
                   </div>
               </div>
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2">
                       Código <i class="fa fa-asterisk text-red"></i>
                   </label>
                   <div class="col-xs-12 col-sm-10">
                      <div class="input-group">
                      	<span class="input-group-addon" id="codigo_padre"></span>
                        <input type="text" name="codigo" id="codigo" class="form-control validate[required]" value="<?=getCNTcuentacodMAIN()?>">
                      </div>
                      <input type="hidden" name="codigopadre" id="codigopadre">
                   </div>
               </div>
               <div class="col-xs-12 col-sm-offset-2">
                   <button class="btn btn-success btn-sm col-xs-12 col-sm-3" type="submit"><span class="fa fa-floppy-o"></span> Guardar</button>
               </div>
          </form>
          <?php }else{
              $val = newCNTcuentaMAIN();

              if($val == 1){
              ?>
              <h3>La cuenta fue creada correctamente</h3>
              <p><a href="index.php?option=com_erp&view=multicuentas" class="btn btn-success">Volver</a></p>
              <?
              }else{?>
              <h3>Ya existe una cuenta con el mismo código, intente nuevamente</h3>
              <p><a onclick="javascript:history.back()" class="btn btn-success">Volver</a></p>
              <? }
          }?>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>