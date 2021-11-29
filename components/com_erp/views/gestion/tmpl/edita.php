<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<?
$unidad = getUnidad();
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Unidad</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Unidad</td>
                <td><input type="text" name="unidad" id="unidad" class="form-control" value="<?=$unidad->unidad?>"></td>
              </tr>
              <tr>
                <td>Simbolo</td>
                <td><input type="text" name="simbolo" id="simbolo" class="form-control"value="<?=$unidad->simbolo?>"></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            editUnidad();?>
            <h3>La unidad fue editada correctamente</h3>
            <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=unidades&Itemid=802'"></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>