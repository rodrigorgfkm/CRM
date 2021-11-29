<?php defined('_JEXEC') or die;?>  
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Vehículos</h3>        		
      </div>
      <div class="box-body">
           <table class="table table-bordered table-striped table_vam" id="tabladinamica">
                <thead>
                    <tr>
                        <th width="200">Vehículo</th>
                        <th width="150">N&ordm; de Chasis</th>
                        <th width="150">N&ordm; de Motor</th>
                        <th width="100">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach(getVehículos(JRequest::getVar('id', '', 'get')) as $vehiculo){?>
                    <tr>
                        <td><?=$vehiculo->marca.' '.$vehiculo->modelo.' '.$vehiculo->fabricacion?></td>
                        <td><?=$vehiculo->chasis?></td>
                        <td><?=$vehiculo->motor?></td>
                        <td>
                            <a href="index.php?option=com_erp&view=vehiculos&layout=edita&id=<?=$vehiculo->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="index.php?option=com_erp&view=vehiculos&layout=elimina&id=<?=$vehiculo->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <? }?>
                </tbody>
            </table>   
      </div>
      <
    </div>
  </section>
</div>