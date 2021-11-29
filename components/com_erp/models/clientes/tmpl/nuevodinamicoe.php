<?php defined('_JEXEC') or die;?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<div class="row-fluid">
                              <a href="index.php?option=com_erp&view=clientes&layout=nuevodinamico&tmpl=component" class="btn" style="width:45%">Crear Cliente Particular</a>
                              <a class="btn btn-success" style="width:45%">Crear Empresa</a>
                            </div>
                            <h3 class="heading">Nueva Empresa</h3>
							<? if(!$_POST){?>
                            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
                              <table class="table table-striped table-bordered dataTable">
                                <tbody>
                                  <tr>
                                    <td width="200">Empresa</td>
                                    <td><input type="text" name="empresa" id="empresa"></td>
                                  </tr>
                                  <tr>
                                    <td width="200">Nombre</td>
                                    <td><input type="text" name="nombre" id="nombre"></td>
                                  </tr>
                                  <tr>
                                    <td>Apellido</td>
                                    <td><input type="text" name="apellido" id="apellido"></td>
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
                                $id = newCliente();
								$nombre = JRequest::getVar('empresa', '', 'post');
								$fono = JRequest::getVar('id_1', '', 'post');
								$celular = JRequest::getVar('id_2', '', 'post');
								$email = JRequest::getVar('id_3', '', 'post');?>
                                <h3>El cliente fue creado correctamente</h3>
                                <script>
                                	window.parent.cargaCliente('<?=$id?>', '<?=$nombre?>', '<?=$fono?>', '<?=$celular?>', '<?=$email?>', '1');
									window.parent.Shadowbox.close();
                                </script>
                                <?
                                }?>
							
						</div>
					</div>
              	  </div>
              </div>