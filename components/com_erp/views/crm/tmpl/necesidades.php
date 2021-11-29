<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Relación Empresa vs Prod.</h3>
      </div>
      <div class="box-body">
         <table class="table datatable table-striped resp">
             <thead>
                 <tr>
                     <td><b>Empresa</b></td>
                     <td><b>Servicios de Interes</b></td>
                     <td><b>Detalle</b></td>
                 </tr>
             </thead>
             <tbody>
             <? foreach (getCRMProspectos() as $empresa){?>
                 <tr>
                     <td><?=$empresa->empresa?></td>
                     <td class="linea">
                     <? foreach (getCRMProspectoInt($empresa->id) as $servicio){?>
                         <div class="alto">
                              - <?=$servicio->name?> <br class="visible-xs">
                         </div>
                     <? }?>
                     </td>
                     <td>
                         <a href="index.php?option=com_erp&view=crm&layout=empresa&id=<?=$empresa->id?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
                     </td>                     
                 </tr>
             <? }?>
             </tbody>
         </table>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>