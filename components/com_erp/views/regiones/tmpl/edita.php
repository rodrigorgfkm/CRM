<?php defined('_JEXEC') or die;
$pais = getPais();?>
<? if(validaAcceso('Administración POS')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar País</h3>
      </div>
      <div class="box-body">
          <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Nombre</td>
            <td><input type="text" name="nombre" id="nombre" class="form-control" value="<?=$pais->pais?>"></td>
          </tr>
          <tr>
            <td>Sigla</td>
            <td><input type="text" name="sigla" id="sigla" class="form-control" value="<?=$pais->sigla?>"></td>
          </tr>
          <tr>
            <td>Nombre Doc Identidad</td>
            <td><input type="text" name="docid" id="docid" class="form-control" value="<?=$pais->docid?>"></td>
          </tr>
          <tr>
            <td>Impuesto</td>
            <td><input type="text" name="impuesto" id="impuesto" class="form-control"value="<?=$pais->impuesto?>">
              %</td>
          </tr>
          <tr>
            <td>Precio incluye impuesto</td>
            <td>
            	<label><input style="display:inline" type="radio" name="incluye" value="1" <?=$pais->impuesto_incluye==1?'checked':''?>> Si</label> 
                &nbsp;&nbsp;&nbsp; 
                <label><input style="display:inline" type="radio" name="incluye" value="0" <?=$pais->impuesto_incluye==0?'checked':''?>> No</label> 
            </td>
          </tr>
          <tr>
            <td>Div. Política</td>
            <td><input type="text" name="divpolitica" id="divpolitica" class="form-control" value="<?=$pais->divpolitica?>"></td>
          </tr>
          <tr>
            <td>Moneda</td>
            <td><input type="text" name="moneda" id="moneda" class="form-control" value="<?=$pais->moneda?>"></td>
          </tr>
          <tr>
            <td>Cant. decimales moneda</td>
            <td><input type="text" name="moneda_decimal" id="moneda_decimal" class="form-control" value="<?=$pais->moneda_decimal?>"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		editPais();?>
		<h3>El pais fue editado correctamente</h3>
        <p><a href="index.php?option=com_erp&view=regiones" class="btn btn-success">Volver</a></p>
		<?
		}?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>