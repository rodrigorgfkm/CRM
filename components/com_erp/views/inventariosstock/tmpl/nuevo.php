<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$ext = $session->get('extension');?>
<? if(validaAcceso('Registro de Productos')){?>  
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Producto</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td>Código</td>
                    <td><input type="text" name="codigo" id="codigo" class="form-control"></td>
                  </tr>
                  <tr>
                    <td width="200">Nombre</td>
                    <td><input type="text" name="name" id="name" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Descripción</td>
                    <td><textarea name="descripcion" id="descripcion" class="form-control"></textarea></td>
                  </tr>
                  <tr>
                    <td>Precio</td>
                    <td><input name="precio_base" type="text" id="precio_base" class="form-control" placeholder="0.00"></td>
                  </tr>
                  <tr>
                    <td>Imagen</td>
                    <td><input type="file" name="imagen" id="imagen">
                    <br>
<small><em>La imágen debe ser mayor a 300 px de alto x 300px de ancho</em></small></td>
                  </tr>
                  <tr>
                    <td>Categoría</td>
                    <td><select name="category_id" id="category_id" class="select2 form-control">
                        <option value=""></option>
                        <?=printCategorias(0, 'option', 0)?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Unidad</td>
                    <td><select name="id_unidad" id="id_unidad" class="select2 form-control">
                        <option value=""></option>
                        <? foreach(getUnidades() as $unidad){?>
                        <option value="<?=$unidad->id?>"><?=$unidad->unidad?></option>
                        <? }?>
                    </select></td>
                  </tr>
                  <? if($ext['pos']->habilitado == 1){?>
                  <tr>
                    <td>Categorías vinculadas</td>
                    <td><select name="id_vinculo" id="id_vinculo" class="select2 form-control">
                        <option value=""></option>
                        <? foreach(getVinculos() as $vinculo){?>
                        <option value="<?=$vinculo->id?>"><?=$vinculo->vinculo?></option>
                        <? }?>
                    </select></td>
                  </tr>
                  <? }?>
                  <tr>
                    <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Guardar producto</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
            <? }else{
                newProducto();?>
                <h3>El producto fue creado correctamente</h3>
                <p><input type="button" name="button" value="Volver" onClick="location.href='index.php?option=com_erp&view=productos&Itemid=802'"></p>
                <?
                }?>
                            <!-- hide elements (for later use) -->
					<div class="hide">
						<!-- actions for datatables -->
						<div class="dt_gal_actions">
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="#" class="delete_rows_dt" data-tableid="dt_gal"><i class="icon-trash"></i> Eliminar</a></li>
									<li><a href="javascript:void(0)"><i class="icon-eye-open"></i> Publicar</a></li>
									<li><a href="javascript:void(0)"><i class="icon-eye-close"></i> Despublicar</a></li>
								</ul>
							</div>
						</div>
						<!-- confirmation box -->
						<div id="confirm_dialog" class="cbox_content">
							<div class="sepH_c tac"><strong>&iquest;Está seguro de eliminar este producto?</strong></div>
							<div class="tac">
								<a href="#" class="btn btn-default confirm_yes">Si</a>
								<a href="#" class="btn confirm_no">No</a>
							</div>
						</div>
					</div>
      </div>
      <!-- /.chat -->
      <div class="box-footer">
        Contenido del pie de la vista en caso que sea necesario
      </div>
    </div>
  </section>
</div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>