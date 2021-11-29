<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
?>
<script>
checkC = 0;
function buscaCliente() {
		checkC++;
		setTimeout(function(){
			var empresa = jQuery('#empresa').val();
			if(checkC > 1){
				checkC--;
				return false;
			}
			jQuery('#loading_cliente').fadeIn();
			jQuery('#lista_cliente').fadeOut();
			jQuery('#lista_cliente').html('');
			
			jQuery.post( "index.php?option=com_erp&view=clientes&layout=sugiereempresa&tmpl=component", {empresa:empresa}, function(data) {
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
function cerrarVentana(id){
	jQuery('#'+id).fadeOut();
	jQuery('#'+id).html('');
	}
</script>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Proveedor</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Empresa</td>
                <td>
                    <input type="text" name="empresa" id="empresa" class="form-control" onKeyUp="buscaCliente()">
                    <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                    <div id="lista_cliente" style=" height:0px; overflow:visible; z-index:10000; position:relative"></div>
                </td>
              </tr>
              <tr>
                <td>NIT</td>
                <td><input type="text" name="nit" id="nit" class="form-control"></td>
              </tr>
              <? foreach(getCampos(1) as $campo){?>
              <tr>
                <td><?=$campo->tipo?></td>
                <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control"></td>
              </tr>
              <? }?>
              <tr>
                <td>Dirección</td>
                <td><input type="text" name="direccion" id="direccion" class="form-control"></td>
              </tr>
              <tr>
                <td>Estado</td>
                <td>
                  <select name="id_estado" id="id_estado" class="select2 form-control">
                    <? foreach(getPaises() as $pais){?>
                        <option value=""></option>
                        <optgroup label="<?=$pais->pais?>">
                        <? foreach(getEstados($pais->id) as $e){?>
                            <option value="<?=$e->id?>"><?=$e->estado?></option>
                            <? }
                            }?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Localidad</td>
                <td><input type="text" name="localidad" id="localidad" class="form-control"></td>
              </tr>
              <tr>
                <th colspan="2">Datos de Contacto</th>
              </tr>
              <tr>
                <td width="200">Nombre</td>
                <td><input type="text" name="nombre" id="nombre" class="form-control"></td>
              </tr>
              <tr>
                <td>Apellido</td>
                <td><input type="text" name="apellido" id="apellido" class="form-control"></td>
              </tr>
              <? foreach(getCampos() as $campo){?>
              <tr>
                <td><?=$campo->tipo?></td>
                <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control"></td>
              </tr>
              <? }?>
              <tr>
                <td>Detalle</td>
                <td><textarea name="detalle" id="detalle" class="form-control"></textarea><input type="hidden" name="proveedor" value="1"></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Guardar proveedor</a></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            newCliente();?>
            <h3>El proveedor fue creado correctamente</h3>
            <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=inventariosproveedores'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>