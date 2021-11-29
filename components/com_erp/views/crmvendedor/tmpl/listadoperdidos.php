<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Estadisticas')){
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-bar-chart"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Listado de Usuarios de Negocios Perdidos</h3>
      </div>
      <div class="box-body">
          <table class="table datatable striped">
              <thead>
                  <tr>
                      <td><b>Usuario</b></td>
                      <td width="100"><b>Detalles</b></td>
                  </tr>
              </thead>
              <tbody>
                  <? foreach (getUsuarios() as $usuario){?>                     
                      <tr>
                          <td><?=$usuario->name?></td>
                          <td>
                            <a href="index.php?option=com_erp&view=crmestadisticas&layout=clientesperdidos&id=<?=$usuario->id?>" class="btn btn-danger"><i class="fa fa-bar-chart"></i> <span class="hidden-xs">Ver Estadísticas</span></a>
                          </td>
                      </tr>
                    <? }?>
              </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>