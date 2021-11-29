<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){
$user =& JFactory::getUser();
$id_usuario = JRequest::getVar('id_usuario','','post');
$desde = JRequest::getVar('fecha_ini','','post');
$hasta = JRequest::getVar('fecha_fin','','post');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-industry"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Logs de acciones</h3>
      </div>
      
      <div class="box-body">
          <div class="col-xs-12" style="margin-bottom:10px;">
            <form action="" method="post" name="form" id="form" class="form-horizontal" role="form">
              <div class="row-fluid">
                  <label for="" class="col-xs-12 col-sm-1">Usuario</label>
                  <div class="col-xs-12 col-sm-2">
                    <select name="id_usuario" id="id_usuario" class="chosen-select form-control obs">
                        <option value="">Usuario</option>
                        <?  foreach (getUsuarios() as $usuario){ 
                            if($usuario->id == $id_usuario){
                                $selected='selected';
                            }else{
                                $selected = '';
                            }
                            echo "<option value='".$usuario->id."' ".$selected.">".$usuario->name."</option>";
                        }?>
                    </select>
                  </div>
                  <label for="" class="col-xs-12 col-sm-1">Desde</label>       
                  <div class="col-xs-12 col-sm-2">
                    <input type="text" id="fecha_ini" name="fecha_ini" class="form-control datepicker validate[required]" value="<?=$desde?>">
                  </div>
                  <label for="" class="col-xs-12 col-sm-1">Hasta</label>
                  <div class="col-xs-12 col-sm-2">
                    <input type="text" id="fecha_fin" name="fecha_fin" class="form-control datepicker validate[required]" value="<?=$hasta?>">
                  </div>
                  <input type="hidden" name="limpia" id="limpia">
                  <button class="btn btn-info" type="submit"><em class="icon-filter icon-white"></em> Filtrar</button>
                  <button class="btn btn-warning" type="button" onclick="limpiaForm()"><em class="icon-info-sign icon-white"></em> Limpiar</button>
              </div>
            </form> 
         </div>
          <table class="table table-bordered table-striped hoverTable datatable">
            <thead>
              <tr>
                <th width="200">Usuario</th>
                <th width="100">Fecha</th>
                <th width="100">Hora</th>
                <th>Detalle</th>
              </tr>
            </thead>
            <tbody>
                <? if($_POST){
                  foreach (getLogs() as $logs){?>                   
                    <tr>
                        <td><?=$logs->name?></td>
                        <td><?=fecha($logs->fecha)?></td>
                        <td><?=$logs->hora?></td>
                        <td><?=$logs->detalle?></td>
                    </tr>
                <? }
                }?>
            </tbody>
          </table>
      </div>
        
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>

