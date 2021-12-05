<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Administrador')){
?>
<script>
    $(document).ready(function() {
    $('#table').dataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
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
	table.resp td:nth-of-type(1):before { content: "<?=JText::_('COM_CRM_EMPRES')?>: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "<?=JText::_('COM_CRM_LRESPON')?>: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before {}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-secret"></i>
		<!-- Título de la vista -->
        <h3 class="box-title"><?=JText::_('COM_CRM_LRESPON')?></h3>
      </div>      
      <div class="box-body">
         <table class="table datatable resp table-striped">
             <thead>
                 <tr>
                     <td><b></b></td>
                     <td><b></b></td>
                     <td width="105"><b><?=JText::_('COM_CRM_LCAMRESPON')?></b></td>
                 </tr>
             </thead>
             <tbody>
                <? foreach (getCRMProspectos()as $resp){?>
                 <tr>
                     <td><?=$resp->empresa?></td>
                     <td><i class="fa fa-user text-blue"></i> <?=$resp->name?></td>
                     <td><a href="index.php?option=com_erp&view=crm&layout=cambiaresponsable&id=<?=$resp->id?>" class="btn btn-success"><i class="fa fa-refresh"></i> <?=JText::_('COM_CRM_BCAMBIAR')?></a></td>
                 </tr>
                 <? }?>
             </tbody>
         </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?> 