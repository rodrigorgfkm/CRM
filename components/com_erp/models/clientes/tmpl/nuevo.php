<?php defined('_JEXEC') or die;

?>
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

              <div id="contentwrapper">
                <div class="main_content">
                    <!--<nav>
                        <div id="jCrumbs" class="breadCrumb module">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-home"></i></a>
                                </li>
                                <li>
                                    <a href="#">Clientes</a>
                                </li>
                                <li>
                                    Crear cliente
                                </li>
                            </ul>
                        </div>
                    </nav>-->
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Nuevo cliente</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Empresa</td>
                                    <td>
                                    	<select name="id_empresa" id="id_empresa" class="chosen-select">
                                        	<option value="">Particular</option>
                                            <? foreach(getEmpresasCliente() as $empresa){?>
											<option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
											<? }?>
                                        </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td width="200">Nombre</td>
                                    <td><input type="text" name="nombre" id="nombre" onKeyUp="buscaCliente()"></td>
                                  </tr>
                                  <tr>
                                    <td>Apellido</td>
                                    <td>
                                    	<input type="text" name="apellido" id="apellido" onKeyUp="buscaCliente()">
                                        <img src="components/com_erp/images/loading.gif" width="20px" style="display:none" id="loading_cliente">
                                        <div id="lista_cliente" style=" height:0px; overflow:visible; z-index:10000; position:relative"></div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>NIT</td>
                                    <td><input type="text" name="nit" id="nit"></td>
                                  </tr>
                                  <? foreach(getCampos() as $campo){?>
                                  <tr>
                                    <td><?=$campo->tipo?></td>
                                    <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>"></td>
                                  </tr>
                                  <? }?>
                                  <tr>
                                    <td>Dirección</td>
                                    <td><input type="text" name="direccion" id="direccion"></td>
                                  </tr>
                                  <tr>
                                    <td>Estado</td>
                                    <td>
                                      <select name="id_estado" id="id_estado" class="chosen-select">
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
                                    <td>Ciudad</td>
                                    <td><input type="text" name="localidad" id="localidad"></td>
                                  </tr>
                                  <tr>
                                    <td>Detalle</td>
                                    <td><textarea name="detalle" id="detalle"></textarea></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Guardar cliente</a></td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                            <? }else{
                                newCliente();?>
                                <h3>El cliente fue creado correctamente</h3>
                                <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=clientes&Itemid=802'"></p>
                                <?
                                }?>
							
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientes.php' );?>
			</div>