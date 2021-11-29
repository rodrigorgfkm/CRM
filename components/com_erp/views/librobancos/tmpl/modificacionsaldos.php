<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Modificación de saldos</h3>
      </div>
      <div class="box-body">
          <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Banco</th>
                  <th>Nro. de Cuenta</th>
                  <th>Tipo de Moneda</th>
                  <th>Saldo Inicial</th>
                  <th width="120">Acciones</th>
              </thead>
              <tbody>
                 <? 
                  foreach(getLBcuentas() as $banco){?>
                      <tr>
                          <td><?=$banco->banco?></td>
                          <td><?=$banco->cuenta?></td>
                          <td><?=$banco->moneda=="E"?'Extranjera':'Nacional'?></td>
                          <td><?=$banco->saldo?></td>
                          <td class="text-center">                             
                                <a href="index.php?option=com_erp&view=librobancos&layout=cambiarsaldo&id=<?=$banco->id?>" class="btn btn-success"><i class="fa fa-edit"></i> Modificar Saldo</a>
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