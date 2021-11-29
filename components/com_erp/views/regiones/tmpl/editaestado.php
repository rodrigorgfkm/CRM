<?php defined('_JEXEC') or die;
$estado = getEstado();?>
<? if(validaAcceso('Administración POS')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Estado</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Nombre</td>
                <td><input type="text" name="nombre" id="nombre" class="form-control" value="<?=$estado->estado?>"></td>
              </tr>
              <tr>
                <td>Sigla</td>
                <td><input type="text" name="sigla" id="sigla" class="form-control" value="<?=$estado->sigla?>"></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }else{
            editEstado();?>
            <h3>El estado fue editado correctamente</h3>
            <p><a href="index.php?option=com_erp&view=regiones&layout=estados&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success">Volver</a></p>
            <?
            }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>