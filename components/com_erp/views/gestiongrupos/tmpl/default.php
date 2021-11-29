<?php defined('_JEXEC') or die;?>
<style>
    .odd{
        background-color: #e4e4e4 !important;
    }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Extensión: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Grupo: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before { content: "Acciones: "; font-weight: bold;}
}
</style>
<? if(validaAcceso('Administrador')){
	$id_ext = JRequest::getVar('id', '', 'post');?>

    
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Roles</h3>
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-1">
                    	Filtro: 
                	</label>
                        <select name="id" id="id" class="form-control" style="width:auto; display:inline-block">
                            <option value="">Elija extensión</option>
                            <? foreach(getExtensiones() as $ext){?>
                            <option value="<?=$ext->id?>" <?=$ext->id==$id_ext?'selected':''?>><?=$ext->extension?></option>
                            <? }?>
                    	</select>
                        <button type="submit" class="btn btn-success"><em class="fa fa-filter"></em> Filtrar</button>
                        <a href="index.php?option=com_erp&view=gestiongrupos" class="btn btn-info"><em class="fa fa-eraser"></em> Limpiar</a>
                	</div>
                </form>
            </div>
        </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable resp" id="tabladinamica">
            <thead>
              <tr>                
                <th>Extensión</th>
                <th>Rol</th>
                <th width="100">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <? foreach(getGruposSistema() as $grupo){
                  if($grupo->extension != ''){?>
              <tr>                
                <td><?=$grupo->extension?></td>
                <td><?=$grupo->grupo?></td>
                <td>
                  <? if($grupo->fijo == 0){?>
                  <a href="index.php?option=com_erp&view=gestiongrupos&layout=edita&id=<?=$grupo->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                  <a href="index.php?option=com_erp&view=gestiongrupos&layout=elimina&id=<?=$grupo->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                  <? }?>
                </td>
              </tr>
              <? }}?>
            </tbody>
        </table>
      </div>
     </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>