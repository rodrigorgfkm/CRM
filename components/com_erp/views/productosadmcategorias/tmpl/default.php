<?php defined('_JEXEC') or die;
if(validaAcceso('Administracion Productos')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Categorías</h3>
		
        <!-- Algunos botones si son necesarios -->        
      </div>
      <div class="box-body">
        <?
        if($_POST)
			ordenaCategoria();
		?>
      <form action="" method="post" name="formulario">
      <table class="table table-striped table-bordered datatable" id="tabladinamica">
        <thead>
          <tr>            
            <th>Categoría</th>            
            <th>Categoría padre</th>
            <th width="150">Tipo</th>
            <th width="100">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getCategorias() as $cat){
                if($cat->published == 1){
                    $estado = '';
                    $color= 'info';
                }else{
                    $estado = '-slash';
                    $color= 'default';
                }?>
          <tr>            
            <td><strong>
              <?=$cat->name?>
            </strong></td>            
            <td><?=$cat->padre?></td>
            <td><?=$cat->tipo?></td>
            <td>
                <a href="index.php?option=com_erp&view=productosadmcategorias&layout=edita&id=<?=$cat->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                <a href="index.php?option=com_erp&view=productosadmcategorias&layout=publica&estado=<?=$cat->published?>&id=<?=$cat->id?>" class="btn btn-<?=$color?>"><i class="fa fa-eye<?=$estado?>"></i></a>
                <a href="index.php?option=com_erp&view=productosadmcategorias&layout=elimina&id=<?=$cat->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <? }?>
        </tbody>
      </table>
      </form>
      </div>
      <!-- /.chat -->
      <div class="box-footer">
        <div class="hide">
            <!-- actions for datatables -->
            <div class="dt_gal_actions">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="delete_rows_dt" data-tableid="dt_gal"><i class="fa fa-trash"></i> Eliminar</a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-eye-open"></i> Publicar</a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-eye-close"></i> Despublicar</a></li>
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