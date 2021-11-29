<?php defined('_JEXEC') or die;
$session = JFactory::getSession();
$desde = JRequest::getVar('desde','','post');
$hasta = JRequest::getVar('hasta','','post');

?>
<script>
jQuery(document).ready(function(){
    jQuery('.estado').on('click', function(){
        var estado = jQuery(this).attr('data-estado');
        var id = jQuery(this).attr('id');
        location.href = 'index.php?option=com_erp&view=presupuestoadm&layout=changearea&id='+id+'&estado='+estado;
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Áreas de Presupuesto</h3>        
      </div>
        <div class="box-body">
            <a href="index.php?option=com_erp&view=presupuestoadm&layout=nuevoarea" class="pull-right btn bg-purple"><i class="fa fa-plus"></i> Nueva Area de Presupuesto</a>
        </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable">
          <thead>
                <tr>
                  <th width="15">Nro.</th>
                  <th width="100">Estado</th>
                  <th width="100">Codigo</th>
                  <th>Área</th>
                  <th width="50">Acciones</th>
                </tr>
          </thead>
          <tbody>
          <? $cont = 1;
            foreach(getAreasPresupuestoAdm() as $area){?>
                <tr>
                    <td><?=$cont?></td>
                    <td>
                    <?
                        if($area->estado==1){
                            $color = 'btn-success';
                            $icono = 'fa-check';
                            $texto = 'Habilitado';
                        }else{
                            $color = 'btn-warning';
                            $icono = 'fa-square';
                            $texto = 'Deshabilitado';
                        }
                    ?>
                        <button type="button" id="<?=$area->id?>" class="btn <?=$color?> btn-sm estado" data-estado="<?=$area->estado?>"><i class="fa <?=$icono?>"></i> <?=$texto?></button>
                    </td>
                    <td><?=codigoRename($area->codigo)?></td>
                    <td><?=$area->area?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=presupuestoadm&layout=editarea&id=<?=$area->id?>" class="btn btn-success"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                </tr>
        <? $cont++;
           }
          ?>
          </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<style>
#fecha_ini, #fecha_fin{
      width:80px;
      }
    .input-append{
      display: inline;
      }
</style>