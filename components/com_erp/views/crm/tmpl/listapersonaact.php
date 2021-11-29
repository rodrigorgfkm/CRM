<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
	$id_usuario = JRequest::getVar('id_usuario','','post');
	$nombre = JRequest::getVar('usuario','','post');
function icono($tipo){
  switch ($tipo){
      case 'Llamada':
          $icon_color = "fa-phone";
          break;
      case 'Reunión':
          $icon_color = "fa-users";
          break;
      case 'Tarea':
          $icon_color = "fa-clock-o";
          break;
      case 'Plazo':
          $icon_color = "fa-hourglass-o";
          break;
      case 'Correo Electrónico':
          $icon_color = "fa-envelope";
          break;
      case 'Almuerzo':
          $icon_color = "fa-cutlery";
          break;
  }
  return $icon_color;
}
function color($tipo){
  switch ($tipo){
      case 'Llamada':
          $icon_color = "bg-maroon";
          break;
      case 'Reunión':
          $icon_color = "bg-yellow";
          break;
      case 'Tarea':
          $icon_color = "bg-purple";
          break;
      case 'Plazo':
          $icon_color = "bg-orange";
          break;
      case 'Correo Electrónico':
          $icon_color = "bg-blue";
          break;
      case 'Almuerzo':
          $icon_color = "bg-red";
          break;
  }
  return $icon_color;
}
?>
<style>
    .alto{
        height: 25px;
        border-top: 1px #e4e4e4 solid;
    }   
    .linea .alto:first-child{
        border-top: none;        
    }
    .odd{
        background-color: #e4e4e4 !important;
    }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1023px){
    .edit{
        display: block;
    }
    .alto{
        height: 40px;
    }
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Empresa: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { }
	table.resp td:nth-of-type(3):before { content: "Detalle: "}
}
</style>
<script>
jQuery(document).on('ready',function(){
    jQuery('#id_user').on('change',function(){        
        jQuery('[name=usuario]').val(jQuery('#id_user option:selected').html());
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Actividades por Vendedor</h3>
      </div>
      <div class="container-fluid">
          <div class="col-xs-12">
              <form action="" class="form-inline" method="post">
                  <label for="" class="col-xs-12 col-sm-1"> Vendedor</label>
                  <select name="id_usuario" id="id_user" class="form-control">
                    <option value="">Sin Asignar</option>
                     <? foreach (getUsuarios() as $usuario){
                        $usuario
                       ?>
                         <option value="<?=$usuario->id?>" <?=$id_usuario==$usuario->id?'selected':''?>><?=$usuario->name?></option>
                     <? }?>
                  </select>
                  <input type="hidden" name="usuario">
                  <button type="submit" class="btn btn-info"><i class="fa fa-filter"></i> Filtrar</button>
              </form>
          </div>
      </div>
      <div class="box-body">
         <table class="table datatable table-striped resp">
             <thead>
                 <th><b>Nombre</b></th>
                 <th><b>Actividad (Fecha)</b></th>
                 <th width="80"><b>Detalle</b></th>
             </thead>
             <tbody>
                 <? if($_POST){
                        foreach(getCRMResponactividad($id_usuario) as $actividad){
                        ?>
                         <tr>
                             <td><?=$nombre?></td>
                             <td class="linea">
                                 <div class="alto">
                                 <span><?=$actividad->empresa?></span> - <button type="button" class="btn <?=color($actividad->tipo)?> btn-xs"><i class="fa <?=icono($actividad->tipo);?>"></i></button> <?=$actividad->titulo?> <br class="visible-xs">(<?=fecha($actividad->	fecha_registro)?>)
                                 </div>
                             <td>
                                 <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$actividad->id?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
                             </td>                     
                         </tr>
                     <? }
                    }?>
             </tbody>
         </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 