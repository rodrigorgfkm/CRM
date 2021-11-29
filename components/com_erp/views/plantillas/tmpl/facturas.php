<?php defined('_JEXEC') or die;
if(validaAcceso('Plantillas')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Plantillas</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>                    
                    <th>Nombre</th>
                    <th width="120">Predeterminado</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getPlantillas(6) as $plantilla){
                    if($plantilla->predeterminado == 1){
                        $star = 'star';
                        $btn = 'btn-success';
                        }else{
                        $star = 'star-o';
                        $btn = 'btn-warning';
                        }
                      ?>
                <tr>                    
                    <td><strong><?=$plantilla->nombre?></strong></td>
                    <td>
                        <a href="index.php?option=com_erp&view=plantillas&layout=predetermina&id_extension=6&v=<?=$plantilla->predeterminado?>&id=<?=$plantilla->id?>" class="btn <?=$btn?> span12"><i class="fa fa-<?=$star?>"></i></a>
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