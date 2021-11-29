<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
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
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-list"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Empresas</h3>
      </div>      
      <div class="box-body">          
         <table class="table datatable table-striped resp">
             <thead>
                 <tr>
                     <td><b>Empresa</b></td>
                     <td><b>Actividad (Fecha)</b></td>
                     <td><b>Detalle</b></td>
                 </tr>
             </thead>
             <tbody>
             <? foreach (getCRMProspectos('',2) as $empresa){
                 if(count(getCRMActividades(1, $empresa->id))>0){?>
                 <tr>
                     <td><?=$empresa->empresa?></td>
                     <td class="linea">
                     <? foreach (getCRMActividades(1, $empresa->id) as $actividad){?>
                         <div class="alto">
                             <button type="button" class="btn <?=color($actividad->tipo)?> btn-xs"><i class="fa <?=icono($actividad->tipo);?>"></i></button> <?=$actividad->titulo?> <br class="visible-xs">(<?=fecha($actividad->fecha)?>)
                         </div>
                     <? }?>
                     </td>
                     <td>
                         <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$empresa->id?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
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