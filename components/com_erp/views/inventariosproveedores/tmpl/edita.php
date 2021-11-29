<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
$cliente = getCliente();
$nit = getNit($cliente->id);?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Proveedor</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Empresa</td>
                <td><input type="text" name="empresa" id="empresa" class="form-control" value="<?=$cliente->empresa?>"></td>
              </tr>
              <tr>
                <td>NIT</td>
                <td><input type="text" name="nit" id="nit" class="form-control" value="<?=$nit->nit?>"></td>
              </tr>
              <? foreach(getCampos(1) as $campo){?>
              <tr>
                <td><?=$campo->tipo?></td>
                <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control" value="<?=getCampoValor($campo->id)?>"></td>
              </tr>
              <? }?>
              <tr>
                <td>Dirección</td>
                <td><input type="text" name="direccion" id="direccion" class="form-control" value="<?=$cliente->direccion?>"></td>
              </tr>
              <tr>
                <td>Estado</td>
                <td>
                  <select name="id_estado" class="select2 form-control">
                  <? foreach(getPaises() as $pais){?>
                        <option value=""></option>
                        <optgroup label="<?=$pais->pais?>">
                        <? foreach(getEstados($pais->id) as $e){?>
                            <option value="<?=$e->id?>" <?=$e->id==$cliente->id_estado?'selected':''?>><?=$e->estado?></option>
                            <? }
                            }?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Localidad</td>
                <td><input type="text" name="localidad" id="localidad" class="form-control" value="<?=$cliente->localidad?>"></td>
              </tr>
              <tr>
                <th colspan="2">Datos de Contacto</th>
              </tr>
              <tr>
                <td>Nombre</td>
                <td><input type="text" name="nombre" id="nombre" class="form-control" value="<?=$cliente->nombre?>"></td>
              </tr>
              <tr>
                <td>Apellido</td>
                <td><input type="text" name="apellido" id="apellido" class="form-control" value="<?=$cliente->apellido?>"></td>
              </tr>
              <? foreach(getCampos() as $campo){?>
              <tr>
                <td><?=$campo->tipo?></td>
                <td><input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control" value="<?=getCampoValor($campo->id)?>"></td>
              </tr>
              <? }?>

              <tr>
                <td>Detalle</td>
                <td><textarea name="detalle" id="detalle" class="form-control"><?=$cliente->detalle?></textarea></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><a onClick="document.form1.submit()" class="btn btn-success btn-sm">Guardar cliente</a></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            editCliente();
            editNitEmpresa()?>
            <h3>El proveedor fue editado correctamente</h3>
            <p><input type="button" name="button" value="Volver" class="btn btn-success" onClick="location.href='index.php?option=com_erp&view=inventariosproveedores'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>