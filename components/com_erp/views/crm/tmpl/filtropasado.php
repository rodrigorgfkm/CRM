<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
$tipo = JRequest::getVar('tipo','','post');
$id = JRequest::getVar('id_empresa','','post');
//echo "TIPO: ".$tipo." ID DEL PROSPECTO: ".$id;
function icolor($tipo){
  switch ($tipo){
      case 'Llamada':
          $icon_color = "fa-phone bg-maroon";
          break;
      case 'Reunión':
          $icon_color = "fa-users bg-yellow";
          break;
      case 'Tarea':
          $icon_color = "fa-clock-o bg-purple";
          break;
      case 'Plazo':
          $icon_color = "fa-hourglass-o bg-orange";
          break;
      case 'Correo Electrónico':
          $icon_color = "fa-envelope bg-blue";
          break;
      case 'Almuerzo':
          $icon_color = "fa-cutlery bg-red";
          break;
  }
  return $icon_color;
}
?>
<? foreach (getCRMActividades(0, $id, $tipo) as $pasadas){?>
    <li class="time-label">
        <span class="bg-aqua">
            <?=fechaLiteral($pasadas->fecha)?>
        </span>
    </li>
    <li>
        <!-- icono -->
        <i class="fa <?=$tipo!=''?icolor($tipo):icolor($pasadas->tipo);?>"></i>
        <div class="timeline-item">
            <!--Titulo y hora-->
            <h3 class="timeline-header"><?=$pasadas->titulo?></h3>
            <div class="timeline-header"><span class="time"><i class="fa fa-clock-o"></i> <?=$pasadas->hora?></span></div>
            <div class="timeline-body">
               <!--comentario-->
                <?=$pasadas->comentario?>
            </div>
        </div>
    </li>
<? }?>
<? }else{vistaBloqueada();}?>