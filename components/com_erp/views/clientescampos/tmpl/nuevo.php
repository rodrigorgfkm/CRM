<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Clientes')){?>
<?
$conf = getPosConfiguracion();
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Campo</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Campo</td>
                <td><input type="text" name="campo" id="campo"></td>
              </tr>
              <tr>
                <td>Obligatorio</td>
                <td>
                    <label style="display:inline"><input style="display:inline" type="radio" name="obligatorio" value="1"> Si</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="display:inline"><input style="display:inline" type="radio" name="obligatorio" value="0" checked> No</label>
                </td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            newCampo();?>
                <h3>El campo fue creado correctamente</h3>
                <p><a href="index.php?option=com_erp&view=clientescampos" class="btn btn-success">Volver</a></p>
                <?
            }?>
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