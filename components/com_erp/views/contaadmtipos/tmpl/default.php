<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Tipo')){
?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Tipos de Comprobantes</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th>Tipo de comprobante</th>
                    <th width="100">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getTipoComprobantes() as $tipo){?>
                <tr>
                    <td><?=$tipo->tipo?></td>
                    <td>
                        <? if($tipo->fijo == 0){?>
                        <a href="index.php?option=com_erp&view=contatipos&layout=edita&id=<?=$tipo->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=contatipos&layout=elimina&id=<?=$tipo->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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