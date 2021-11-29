<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
$empresa = getEmpresa();
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-university"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Sucursales</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable">
        <thead>
            <th width="200">Principal y Sucursales</th>
            <th>Dirección</th>
            <th width="100"><?=$empresa->divpolitica?></th>
            <th width="80">Acciones</th>
        </thead>
        <tbody>          
          <? foreach(getSucursales() as $sucursal){?>
          <tr>            
            <td><strong>
              <?=$sucursal->nombre?>
            </strong></td>
            <td><?=$sucursal->direccion?></td>
            <td><?=$sucursal->departamento?></td>
            <td>
                <a href="index.php?option=com_erp&view=gestionsucursales&layout=edita&id=<?=$sucursal->id?>" class="btn btn-success"><i class="fa fa-pencil icon-white"></i></a>
                <? if($sucursal->id != 1){?>
                <a href="index.php?option=com_erp&view=gestionsucursales&layout=elimina&id=<?=$sucursal->id?>" class="btn btn-danger"><i class="fa fa-trash icon-white"></i></a>
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
<? }else{vistaBloqueada();}?>