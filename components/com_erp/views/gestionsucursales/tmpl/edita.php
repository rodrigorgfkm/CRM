<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
$empresa = getEmpresa();
$sucursal = getSucursal();?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Edita Sucursal</h3>
      </div>
      <div class="box-body">
      <?
        $lim_nom = 50;
        $lim_cod = 10;
        $lim_dir = 50;
        $lim_tel = 10;
       ?>
       <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200"><?=$empresa->divpolitica?></td>
                <td><select name="departamento" id="departamento" class="form-control">
                  <? foreach(getEstados($empresa->id_pais) as $estado){?>
                  <option value="<?=$estado->estado?>" <?=$sucursal->departamento==$estado->estado?'selected':''?>><?=$estado->estado?></option>
                  <? }?>
                </select></td>
              </tr>
              <tr>
                <td>Nombre</td>
                <td><input type="text" name="nombre" id="nombre" class="form-control validate[required,maxSize[<?=$lim_nom?>]]" value="<?=$sucursal->nombre?>"></td>
              </tr>
              <tr>
                <td>Código</td>
                <td><input name="codigo" type="text" id="codigo" class="form-control validate[required,maxSize[<?=$lim_cod?>]]" value="<?=$sucursal->codigo?>" size="3" maxlength="3"></td>
              </tr>
              <tr>
                <td>Dirección</td>
                <td><input type="text" name="direccion" id="direccion" class="form-control validate[required,maxSize[<?=$lim_dir?>]]" value="<?=$sucursal->direccion?>"></td>
              </tr>
              <tr>
                <td>Teléfono</td>
                <td><input type="text" name="telefono" id="telefono" class="form-control validate[required,maxSize[<?=$lim_tel?>]]" value="<?=$sucursal->telefono?>"></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="submit" class="btn btn-success" id="submit" value="Enviar"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            editSucursal();?>
            <h3>La sucursal fue editada correctamente</h3>
            <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestionsucursales'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>