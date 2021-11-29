<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-building"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Empresas</h3>
      </div>
      <div class="box-body">
          <table class="table table-striped table-bordered datatable">
              <thead>                  
                      <th width="30">N&ordm;</th>
                      <th width="150">Logo</th>
                      <th>Empresa</th>
                      <th width="150">Razón Social</th>
                      <th width="150">Nit</th>
                      <th width="80">Acciones</th>
              </thead>
              <tbody>
                  <? 
				  $n = 1;
				  foreach(getMainEmpresas() as $emp){?>
                  <tr>
                      <td><?=$n?></td>
                      <td>
                      	<? if($emp->logo != ''){?>
                        <img src="media/com_erp/<?=$emp->logo?>" width="150px">
                        <? }?>
                      </td>
                      <td><?=$emp->empresa?></td>
                      <td><?=$emp->razon?></td>
                      <td><?=$emp->nit?></td>
                      <td>
                      	<a href="index.php?option=com_erp&view=multiempresa&layout=edita&id=<?=$emp->id?>" class="btn btn-success"><em class="fa fa-pencil"></em></a>
                        <a href="index.php?option=com_erp&view=multiempresa&layout=elimina&id=<?=$emp->id?>" class="btn btn-danger"><em class="fa fa-ban"></em></a>
                      </td>
                  </tr>
                  <? $n++;}?>
              </tbody>
          </table>
      </div>
    </div>
  </section>  
</div>
<? }else{
    vistaBloqueada();
}?>