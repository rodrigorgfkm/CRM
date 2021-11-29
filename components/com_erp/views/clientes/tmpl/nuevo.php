<?php defined('_JEXEC') or die;?>
            <? if(validaAcceso('Registro de Clientes')){?>
<script>
checkC = 0;
function buscaCliente() {
	if(jQuery('#nombre').val() != '' && jQuery('#apellido').val() != ''){
		checkC++;
		setTimeout(function(){
			var nombre = jQuery('#nombre').val();
			var apellido = jQuery('#apellido').val();
			if(checkC > 1){
				checkC--;
				return false;
			}
			jQuery('#loading_cliente').fadeIn();
			jQuery('#lista_cliente').fadeOut();
			jQuery('#lista_cliente').html('');
			
			jQuery.post( "index.php?option=com_erp&view=clientes&layout=sugierepersona&tmpl=component", {nombre:nombre, apellido:apellido}, function(data) {
			  var respuesta = data.split('<!-- INICIO -->');
			  var contenido = respuesta[1].split('<!-- FIN -->');
			  jQuery('#lista_cliente').html(contenido[0]);
			  jQuery('#loading_cliente').fadeOut();
			  jQuery('#lista_cliente').fadeIn();
			});
			checkC = 0;
			}, 500);
		return false;
		}
	}
function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	jQuery('#'+id).html('');
	}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-secret"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Particular</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <!--<div class="row-fluid" style="margin-bottom:10px; padding:4px; border:1px solid #CCC; border-radius:4px">
            <div class="col-xs-12 col-sm-6"> 
            </div>
            <div class="col-xs-12 col-sm-6" style="text-align:right">
              <button type="submit" class="btn btn-success"><em class="fa fa-ok"></em> Guardar cliente</button>
              <a href="index.php?option=com_erp&view=clientes" class="btn btn-danger"><em class="fa fa-remove"></em> Cancelar</a>
            </div>
          </div>-->
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Empresa <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <select name="id_empresa" id="id_empresa" class="select2 form-control validate[required]">
                        <option value="">Particular</option>
                        <? foreach(getEmpresasCliente() as $empresa){?>
                        <option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
                        <? }?>
                    </select>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Nombre <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]" onKeyUp="buscaCliente()">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Apellido <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="apellido" id="apellido" onKeyUp="buscaCliente()" class="form-control validate[required]">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                    <div id="lista_cliente" style=" height:0px; overflow:visible; z-index:10000; position:relative"></div>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  NIT <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nit" id="nit" class="form-control validate[required]">
              </div>
          </div>
          <? foreach(getCampos() as $campo){?>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  <?=$campo->tipo?> <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control validate[required]"></td>
              </div>
          </div>          
          <? }?>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Dirección <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required]">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Estado <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required]">
              </div>
          </div>
         <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Ciudad <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <input type="text" name="ciudad" id="ciudad" class="form-control validate[required]">
              </div>
          </div>
          <div class="form-group">
              <label for="" class="col-xs-12 col-sm-2 control-label">
                  Detalle <i class="fa fa-asterisk text-red"></i>
              </label>
              <div class="col-xs-12 col-sm-10">
                    <textarea name="detalle" id="detalle" class="form-control validate[required]"></textarea>
              </div>
          </div>
          <div class="col-xs-12 col-sm-offset-2">
             <button type="submit" class="btn btn-success col-xs-6 col-sm-3"><em class="fa fa-floppy-o"></em> Guardar cliente</button>
             <a href="index.php?option=com_erp&view=clientes" class="btn btn-danger col-xs-6 col-sm-3"><em class="fa fa-remove"></em> Cancelar</a> 
          </div>          
        </form>
        <? }else{
            newCliente();?>
            <h3>El cliente fue creado correctamente</h3>
            <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes&Itemid=802'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>      
<? }else{
    vistaBloqueada();
}?>