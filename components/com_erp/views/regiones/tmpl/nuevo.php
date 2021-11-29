<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración POS')){?>

<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear País</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <form method="post" enctype="multipart/form-data" name="form1" id="form1">
          <table class="table table-striped table-bordered datatable">
            <tbody>
              <tr>
                <td width="200">Nombre</td>
                <td><input type="text" name="nombre" id="nombre" class="form-control"></td>
              </tr>
              <tr>
                <td>Sigla</td>
                <td><input type="text" name="sigla" id="sigla" class="form-control"></td>
              </tr>
              <tr>
                <td>Nombre Doc Identidad</td>
                <td><input type="text" name="docid" id="docid" class="form-control"></td>
              </tr>
              <tr>
                <td>Impuesto</td>
                <td><input type="text" name="impuesto" id="impuesto" class="form-control">
                  %</td>
              </tr>
              <tr>
                <td>Precio incluye impuesto</td>
                <td>
                    <label><input style="display:inline" type="radio" name="incluye" value="1"> Si</label> 
                    &nbsp;&nbsp;&nbsp; 
                    <label><input style="display:inline" type="radio" name="incluye" value="0"> No</label> 
                </td>
              </tr>
              <tr>
                <td>Div. Política</td>
                <td><input type="text" name="divpolitica" id="divpolitica" class="form-control"></td>
              </tr>
              <tr>
                <td>Moneda</td>
                <td><input type="text" name="moneda" id="moneda" class="form-control"></td>
              </tr>
              <tr>
                <td>Cant. decimales moneda</td>
                <td><input type="text" name="moneda_decimal" id="moneda_decimal" class="form-control"></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
              </tr>
            </tbody>
          </table>
        </form>
    <? }else{
		newPais();?>
		<h3>El país fue creado correctamente</h3>
        <p><a href="index.php?option=com_erp&view=regiones" class="btn btn-success">Volver</a></p>
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