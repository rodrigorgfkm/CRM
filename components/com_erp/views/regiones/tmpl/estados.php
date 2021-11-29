<?php defined('_JEXEC') or die;
$e = getEmpresa()?>
<? if(validaAcceso('Administración POS')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">División Política</h3>
        <div class="text-right" >
          <div class="btn-group">
            <a href="index.php?option=com_erp&view=regiones&layout=nuevoestado&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success">Crear nueva región</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable" id="tabladinamica">
            <tbody>
              <tr>
                <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                <th><?=$e->divpolitica?></th>
                <th width="120">Sigla</th>
                <th width="100">Acciones</th>
              </tr>
              <? foreach(getEstados(JRequest::getVar('id', '', 'get')) as $estado){?>
              <tr>
                <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                <td><strong><?=$estado->estado?></strong></td>
                <td><?=$estado->sigla?></td>
                <td>
                  <a href="index.php?option=com_erp&view=regiones&layout=editaestado&id_estado=<?=$estado->id?>&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                  <a href="index.php?option=com_erp&view=regiones&layout=eliminaestado&id_estado=<?=$estado->id?>&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>