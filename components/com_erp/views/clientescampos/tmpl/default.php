<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Clientes')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Camposd e Contacto</h3>		
        <!-- Algunos botones si son necesarios -->        
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable" id="tabladinamica">
            <tbody>
              <tr>
                <th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
                <th>Nombre del campo</th>
                <th width="110">Obligatorio</th>
                <th width="190">Acciones</th>
              </tr>
              <? foreach(getCampos() as $campo){
                    if($campo->obligatorio == 1){
                        $star = 'star';
                        $label = 'Obligatorio';
                        $o = 0;
                        }else{
                        $star = 'star-empty';
                        $label = 'Opcional';
                        $o = 1;
                        }?>
              <tr>
                <td><input type="checkbox" name="row_sel" class="row_sel" /></td>
                <td><strong>
                  <?=$campo->tipo?>
                </strong></td>
                <td><a href="index.php?option=com_erp&view=clientescampos&layout=obligatorio&id=<?=$campo->id?>&o=<?=$o?>" class="btn btn-small span12"><i class="fa fa-<?=$star?>"></i> <?=$label?></a></td>
                <td>
                  <? if($campo->fijo == 0){?>
                  <a href="index.php?option=com_erp&view=clientescampos&layout=edita&id=<?=$campo->id?>" class="btn btn-smalls span6"><i class="fa fa-pencil"></i> Editar</a>
                  <a href="index.php?option=com_erp&view=clientescampos&layout=elimina&id=<?=$campo->id?>" class="btn btn-small span6"><i class="fa fa-trash"></i> Eliminar</a>
                  <? }?>
                </td>
              </tr>
              <? }?>
            </tbody>
          </table>
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