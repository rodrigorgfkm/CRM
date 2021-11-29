<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Partidas presupuestarias</h3>
      </div>
      <? if(!$_POST){?>
      <form  method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="20">#</th>
                  <th width="100">Presupuesto</th>
                  <th width="80">C&oacute;digo</th>
                  <th>Nombre</th>
                </tr>
              </thead>
              <tbody>
                <? $n = 1;
                foreach(getCNTcuentasMAIN() as $cta){?>
                <tr>
                  <td><?=$n?></td>
                  <td class="text-center">
                      <input type="checkbox" <?=$cta->presupuesto==1?'checked':''?> data-toggle="toggle" name="id_cuenta[]" id="id_cuenta[]" value="<?=$cta->id?>">
                  </td>
                  <td><?=codigoRename($cta->codigo)?></td>
                  <td><?=$cta->nombre_completo?></td>
                </tr>
                <? $n++;}?>
              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Guardar cambios</button>
          </div>
      </form>
      <? }
	  else{
		  saveCNTctapresupuesto();
		  ?>
	  <div class="box-body">
      	<h3>Los cambios se realizaron correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=multicuentas&layout=presupuesto" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver
            </a>
        </p>
      </div>
	  <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>