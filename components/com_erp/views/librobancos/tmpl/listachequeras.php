<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Libro de Bancos Cheques')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-credit-card"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cheques</h3>
      </div>
      <div class="box-body">
         <table class="table table-striped table-bordered datatable">
              <thead>
                  <th>Banco</th>
                  <th>Nro. de Cuenta</th>
                  <th>Desde</th>
                  <th>Hasta</th>
                  <th width="100">Acciones</th>
              </thead>
              <tbody>
                 <? foreach(getLBchequeras() as $cheque){
                        $cuentabanco = getLBcuenta($cheque->id_cuenta);
                  ?>
                      <tr>
                          <td><?=$cuentabanco->banco?></td>
                          <td><?=$cuentabanco->cuenta?></td>
                          <td><?=$cheque->desde?></td>
                          <td><?=$cheque->hasta?></td>
                          <td>
                              <? if($cheque->activo == 0 && getLBchequescant($cheque->id) == 0){?>
                              <a href="index.php?option=com_erp&view=librobancos&layout=editacheque&id=<?=$cheque->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                              <? }?>
                          </td>
                      </tr>
                 <? }?>
              </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>