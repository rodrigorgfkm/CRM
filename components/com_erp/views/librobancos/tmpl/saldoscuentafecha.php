<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador Libro de Bancos')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Saldos de cuenta a la Fecha</h3>
      </div>
      <div class="container col-xs-12">
           <a href="components/com_erp/views/librobancos/tmpl/exportarsaldodecuenta.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
           <!--components/com_erp/views/librobancos/tmpl/exportarsaldodecuenta.php-->
      </div>
      <div class="box-body">
        <legend>Moneda Nacional</legend>
         <table class="table table-bordered table-striped table_vam datatable">
             <thead>
                 <th>Nº Cuenta</th>
                 <th>Entidad Finaciera</th>
                 <th>Saldo Inicial</th>
                 <th>Ingresos</th>
                 <th>Egresos</th>
                 <th>Saldo Final</th>
             </thead>
             <tbody>
                <? foreach(getLBflujo('N')as $cuentas){
                    $saldoini_n = getLBflujoap($cuentas->id);
                 ?>
                 <tr>
                     <td><?=$cuentas->cuenta?></td>
                     <td><?=$cuentas->banco?></td>
                     <td><?=$saldoini_n?></td>
                     <td><?=$cuentas->ingresos?></td>
                     <td><?=$cuentas->egresos?></td>
                     <td>
                         <?
                            $saldofinal_n = $saldoini_n + $cuentas->saldo;
                            echo $saldofinal_n;
                         ?>
                     </td>
                 </tr>
                 <? }?>
             </tbody>
         </table>
      </div>
      <div class="box-body">
        <legend>Moneda Extranjera</legend>
         <table class="table table-bordered table-striped table_vam datatable">
             <thead>
                 <th>Nº Cuenta</th>
                 <th>Entidad Finaciera</th>
                 <th>Saldo Inicial</th>
                 <th>Ingresos</th>
                 <th>Egresos</th>
                 <th>Saldo Final</th>
             </thead>
             <tbody>
                <? foreach (getLBflujo('E')as $cuentas_e){
                    $saldoini_e = getLBflujoap($cuentas_e->id);
                 ?>
                 <tr>
                     <td><?=$cuentas_e->cuenta?></td>
                     <td><?=$cuentas_e->banco?></td>
                     <td><?=$saldoini_e?></td>
                     <td><?=$cuentas_e->ingresos?></td>
                     <td><?=$cuentas_e->egresos?></td>
                     <td>
                         <?
                            $saldofinal_e = $saldoini_e + $cuentas_e->saldo;
                            echo $saldofinal_e;
                         ?>
                     </td>
                 </tr>
                 <? }?>
             </tbody>
         </table>
      </div>
      <div class="box-body">
         <table class="table table-bordered table-striped table_vam datatable">
            <legend>Otras Cuentas</legend>
             <thead>
                 <th>Nº Cuenta</th>
                 <th>Entidad Finaciera</th>
                 <th>Saldo Inicial</th>
                 <th>Ingresos</th>
                 <th>Egresos</th>
                 <th>Saldo Final</th>
             </thead>
             <tbody>
                <? foreach (getLBflujo('O')as $cuentas_o){
                    $saldoini_o = getLBflujoap($cuentas_o->id);
                 ?>
                 <tr>
                     <td><?=$cuentas_o->cuenta?></td>
                     <td><?=$cuentas_o->banco?></td>
                     <td><?=$saldoini_o?></td>
                     <td><?=$cuentas_o->ingresos?></td>
                     <td><?=$cuentas_o->egresos?></td>
                     <td>
                         <?
                            $saldofinal_o = $saldoini_o+ $cuentas_o->saldo;
                            echo $saldofinal_n;
                         ?>
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