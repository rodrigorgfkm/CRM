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
<? if(validaAcceso('Administrador')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Grupos</h3>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable resp" id="tabladinamica">
            <thead>
              <tr>                
                <th>Extensión</th>
                <th>Grupo</th>
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
                  <a href="index.php?option=com_erp&view=grupos&layout=edita&id=<?=$grupo->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                  <!--<a href="index.php?option=com_erp&view=grupos&layout=elimina&id=<?=$grupo->id?>" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>-->
                </td>
              </tr>
              <? }}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<?}else{vistaBloqueada();}?>