<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración POS')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Paises</h3>
      </div>
      <div class="box-body">                            
            <table class="table table-striped table-bordered datatable" id="tabladinamica">
                <tbody>
                  <tr>
                    <!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
                    <th>País</th>
                    <th width="120">Sigla</th>
                    <th width="120">Doc. Id.</th>
                    <th width="100">Moneda</th>
                    <th width="140">Div Política</th>
                    <th width="100">Acciones</th>
                  </tr>
                  <? foreach(getPaises() as $pais){?>
                  <tr>
                    <!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
                    <td><strong><?=$pais->pais?></strong></td>
                    <td><?=$pais->sigla?></td>
                    <td><?=$pais->docid?></td>
                    <td><?=$pais->moneda?></td>
                    <td><a href="index.php?option=com_erp&view=regiones&layout=estados&id=<?=$pais->id?>" class="btn btn-info span12"><i class="fa fa-globe icon-white"></i> <?=$pais->divpolitica?></a></td>
                    <td>
                      <a href="index.php?option=com_erp&view=regiones&layout=edita&id=<?=$pais->id?>" class="btn btn-success"><i class="fa fa-pencil icon-white"></i></a>
                      <a href="index.php?option=com_erp&view=regiones&layout=elimina&id=<?=$pais->id?>" class="btn btn-danger"><i class="fa fa-trash icon-white"></i></a>
                    </td>
                  </tr>
                  <? }?>
                </tbody>
          </table>
      </div>
      <!-- /.chat -->
      <div class="box-footer">
        Contenido del pie de la vista en caso que sea necesario
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>