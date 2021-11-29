<?php 
defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Gestion')){
?>
<style>
    .alineado{
        display: flex;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    table.resp tbody table.resp td{ min-height: 35px}
	table.resp td:nth-of-type(1):before { content: "Gestión: "; font-weight: bold;}
	table.resp td:nth-of-type(2):before { content: "Vigente: "; font-weight: bold;}
	table.resp td:nth-of-type(3):before { content: "Acciones: "; font-weight: bold;}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-calendar"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de  Gestiones</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered resp" id="tabladinamica">
            <thead>
              <tr>
                <th>Gestión</th>
                <th width="60">Vigente</th>
                <th width="100">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <? foreach(getGestiones() as $gestion){
                    if($gestion->activa == 1){
                        $btn = ' btn-warning';
                        $ico = 'fa fa-star';
                        }else{
                        $btn = 'btn-default';
                        $ico = 'fa fa-star-o';
                        }
                    ?>
              <tr>
                <td><?=$gestion->gestion?></td>
                <td><a href="index.php?option=com_erp&view=contaadmgestion&layout=cambiagestion&id=<?=$gestion->id?>" class="btn <?=$btn?> btn-sm cambio"><i class="<?=$ico?>"></i></a></td>
                <td>
                    <a class="btn btn-success btn-sm ttip_t" title="Editar registro" href="index.php?option=com_erp&view=contaadmgestion&layout=edita&id=<?=$gestion->id?>" ><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-sm ttip_r" title="Eliminar Registro" href="index.php?option=com_erp&view=contaadmgestion&layout=elimina&id=<?=$gestion->id?>"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>