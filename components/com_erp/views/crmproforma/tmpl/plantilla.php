<?php defined('_JEXEC') or die;?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Plantillas</h3>		
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
                    <th>Nombre</th>
                    <th width="120">Predeterminado</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getPlantillas(3) as $plantilla){
                    if($plantilla->predeterminado == 1)
                        $star = 'star';
                        else
                        $star = 'star-empty';
                      ?>
                <tr>
                    <td><input type="checkbox" name="row_sel" class="row_sel" /></td>
                    <td><strong><?=$plantilla->nombre?></strong></td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientesproforma&layout=predetermina&v=<?=$plantilla->predeterminado?>&id=<?=$plantilla->id?>" class="btn col-xs-12"><i class="fa fa-<?=$star?>"></i></a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
</div>      
  </section>
</div>