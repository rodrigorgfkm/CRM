<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Unidades</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable" id="dt_gal">
            <thead>
                <tr>                    
                    <th>Unidad</th>
                    <th width="100">Simbolo</th>
                    <th width="100">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getUnidades() as $unidad){
                      if($unidad->published == 1)
                        $estado = 'open';
                        else
                        $estado = 'close';?>
                <tr>                    
                    <td><?=$unidad->unidad?></td>
                    <td><?=$unidad->simbolo?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=productosadmunidades&layout=edita&id=<?=$unidad->id?>&Itemid=802" class="sepV_a btn btn-success" title="Edit"><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=productosadmunidades&layout=elimina&id=<?=$unidad->id?>&Itemid=802" title="Borrrar" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <? }?>
            </tbody>
        </table>
        <!-- hide elements (for later use) -->
        <div class="hide">
            <!-- actions for datatables -->
            <div class="dt_gal_actions">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="delete_rows_dt"  class="btn btn-danger" data-tableid="dt_gal"><i class="fa fa-trash"></i> Eliminar</a></li>
                        <li><a href="javascript:void(0)" class="btn btn-success" ><i class="fa fa-eye-open"></i> Publicar</a></li>
                        <li><a href="javascript:void(0)" class="btn btn-warning" ><i class="fa fa-eye-close"></i> Despublicar</a></li>
                    </ul>
                </div>
            </div>
            <!-- confirmation box -->
            <div id="confirm_dialog" class="cbox_content">
                <div class="sepH_c tac"><strong>&iquest;Está seguro de eliminar este producto?</strong></div>
                <div class="tac">
                    <a href="#" class="btn btn-default confirm_yes">Si</a>
                    <a href="#" class="btn confirm_no">No</a>
                </div>
            </div>
        </div>
      </div>
      
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>