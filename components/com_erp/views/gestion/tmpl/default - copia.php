<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
$empresa = getEmpresa();
$usuario = getUsuario($user->get('id'));
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
          <h3 class="box-title">Datos de la Empresa</h3>
      </div>
      <div class="box-body">
        <? if($usuario->group_id == 8){
		if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Nombre</td>
            <td><input type="text" name="empresa" id="empresa" class="form-control" value="<?=$empresa->empresa?>"></td>
          </tr>
          <tr>
            <td>Razón social</td>
            <td><input type="text" name="razon" id="razon" class="form-control" value="<?=$empresa->razon?>"></td>
          </tr>
          <tr>
            <td>Logo</td>
            <td>
            	<? if($empresa->logo != '')
					echo '<img src="media/com_erp/'.$empresa->logo.'">'?>
            	<input type="file" name="logo" id="logo">
            </td>
          </tr>
          <tr>
            <td>País</td>
            <td>
            	<select name="id_pais" class="form-control">
                	<? foreach(getPaises() as $pais){?>
                	<option value="<?=$pais->id?>" <?=$pais->id==$empresa->id_pais?'selected':''?>><?=$pais->pais?></option>
                    <? }?>
                </select>
            </td>
          </tr>
          <!--
          <tr>
            <td colspan="2">Otros impuestos</td>
            </tr>
          <tr>
            <td>Nombre impuesto</td>
            <td><input type="text" name="impuesto2"> Porcentaje
              <input type="text" name="impuesto3" placeholder="0%"></td>
          </tr>-->
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" class="btn btn-success" value="Enviar"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		editEmpresa();?>
		<h3>Los datos de la empresa fueron modificados correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestion&Itemid=802'"></p>
		<?
		}}else{?>
		<h3>No tiene privilegios para ver este contenido</h3>
		<? }?>
      </div>
    </div>
  </section>
</div>