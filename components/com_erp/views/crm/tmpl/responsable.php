<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Administrador')){
?>
<style>
    .odd{
        background-color: #e4e4e4 !important;
    }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
    .edit{
        display: block;
    }
    .alto{
        height: 40px;
    }
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Empresa: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Responsable: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before {}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-secret"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Responsable</h3>
      </div>      
      <div class="box-body">
         <table class="table datatable resp table-striped">
             <thead>
                 <tr>
                     <td><b>Empresa</b></td>
                     <td><b>Responsable</b></td>
                     <td width="105"><b>Cambiar Responsable</b></td>
                 </tr>
             </thead>
             <tbody>
                <? foreach (getCRMProspectos()as $resp){?>
                 <tr>
                     <td><?=$resp->empresa?></td>
                     <td><i class="fa fa-user text-blue"></i> <?=$resp->name?></td>
                     <td><a href="index.php?option=com_erp&view=crm&layout=cambiaresponsable&id=<?=$resp->id?>" class="btn btn-success"><i class="fa fa-refresh"></i> Cambiar</a></td>
                 </tr>
                 <? }?>
             </tbody>
         </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 