<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Tipo Registro')){
$tipo = getTipoComp();?>   
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar tipo de Comprobante</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form1" id="form1">
              <table class="table table-striped table-bordered datatable">
                <tbody>
                  <tr>
                    <td width="200">Tipo de comprobante</td>
                    <td><input type="text" name="tipo" id="tipo" class="form-control" value="<?=$tipo->tipo?>"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
                  </tr>
                </tbody>
              </table>
            </form>
            <? }else{
                    editTipoComprobante();?>
                    <h3>El tipo de comprobante fue editado correctamente</h3>
                    <p><a class="btn btn-success" href="index.php?option=com_erp&view=contatipos">Volver</a></p>
                    <?
                }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>