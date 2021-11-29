<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de Negocios Ganados</h3>
      </div>
      <div class="box-body">
         <table class="table datatable table-striped resp">
             <thead>
                    <th><b>Empresa</b></th>
                    <th width="70"><b>Detalle</b></th>
             </thead>
             <tbody>
             <? foreach(getCRMProspectosInactivos(1) as $empresa){?>
                 <tr>
                     <td><?=$empresa->empresa?></td>
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