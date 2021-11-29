<?php defined('_JEXEC') or die;
if(validaAcceso('Registro de Productos')){
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asigna Terminal</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Tipo</td>
            <td>
              <select name="terminal" id="terminal" class="form-control">
                <option value=""></option>
                <? foreach(getTerminales() as $terminal){?>
                <option value="<?=$terminal->id?>"><?=$terminal->terminal?></option>
                <? }?>
              </td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		assignedTerminal();?>
		<h3>El producto fue asignado a la terminal correctamente</h3>
        <p><a href="index.php?option=com_erp&view=productos" class="btn btn-success">Volver</a></p>
		<?
		}?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();} ?>