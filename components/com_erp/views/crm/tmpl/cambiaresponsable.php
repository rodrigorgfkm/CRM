<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Registro')){
$id = JRequest::getVar('id','','post');
$empresa = getCRMProspecto($id);
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
        <h3 class="box-title">Cambiar Responsable</h3>
      </div>      
      <div class="box-body">
        <? if(!$_POST){?> 
        <form action="" name="form" id="form" class="form-horizontal" method="post" role="form">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">Empresa: </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" class="empresa form-control validate[required]" value="<?=$empresa->empresa?>" disabled>
                     <input type="hidden" name="id" value="<?=$empresa->id?>">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">Asignar a: </label>
                 <div class="col-xs-12 col-sm-10">
                     <select name="id_asignado" id="asignado" class="form-control select2 validate[required]">
                         <? foreach (getUsuarios() as $usuario){?>
                                <option value="<?=$usuario->id?>"><?=$usuario->name?></option>                                 
                         <? }?>                             
                     </select>
                 </div>
             </div>
             <div class="col-xs-12 col-sm-offset-2">
                 <a href="index.php?option=com_erp&view=crm&layout=responsable" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Regresar</a>
                 <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Cambiar</button>
             </div>
         </form>
         <? }else{
                changeProspectoA();?>
                <h3 class="alert alert-success">Se ha cambiado correctamente de Asigando <i class="fa fa-check"></i></h3>
                <a href="index.php?option=com_erp&view=crm&layout=responsable" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Regresar</a>
            <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>