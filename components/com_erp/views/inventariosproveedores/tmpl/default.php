<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Proveedores</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th width="250">Correo-e</th>
                    <th width="100">Teléfono</th>
                    <th width="100">Celular</th>
                    <th width="100">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getProveedores() as $proveedor){
                      $com = getClientesCom($proveedor->id);?>
                <tr>
                    <td><input type="checkbox" name="row_sel" class="row_sel" /></td>
                    <td>
                        <strong>
                        <?=$proveedor->empresa?>
                        </strong>
                    </td>
                    <td>
                        <strong>
                        <?=$proveedor->apellido.' '.$proveedor->nombre?>
                        </strong>
                    </td>
                    <td><?=$com->email?></td>
                    <td><?=$com->fono_domicilio?></td>
                    <td><?=$com->celular?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=inventariosproveedores&layout=edita&id=<?=$proveedor->id?>&Itemid=802" class="sepV_a" title="Edit"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=inventariosproveedores&layout=elimina&id=<?=$proveedor->id?>&Itemid=802" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>