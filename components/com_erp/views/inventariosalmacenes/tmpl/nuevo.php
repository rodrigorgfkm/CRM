<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
$conf = getPosConfiguracion();
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Almacen</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Almacén</td>
            <td><input type="text" name="terminal" id="terminal" class="form-control"></td>
          </tr>
          <tr>
            <td>Estado / Región / Departamento</td>
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
            <td>Ciudad</td>
            <td><input type="text" name="localidad" id="localidad" class="form-control"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		newAlmacen();?>
		<h3>El almacén fue correctamente</h3>
        <p><a href="index.php?option=com_erp&view=posterminal" class="btn btn-success">Volver</a></p>
		<?
		}?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>