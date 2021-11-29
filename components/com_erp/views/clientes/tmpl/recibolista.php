<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Recibos</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th width="30">N&ordm;</th>
                    <th>Nombre</th>
                    <th width="80">A cuenta</th>
                    <th width="80">Fecha</th>
                    <th width="80">Hora</th>
                    <th width="90">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? $n = 0;
                foreach(getRecibos() as $recibo){
                      $fh = explode(' ', $recibo->fecha);
                      $n++;
                      ?>
                <tr>
                    <td><?=$n?></td>
                    <td><strong><?=$recibo->nombre?></strong></td>
                    <td style="text-align:right"><?=$recibo->acuenta?></td>
                    <td><?=$fh[0]?></td>
                    <td><?=$fh[1]?></td>
                    <td><a href="index.php?option=com_erp&view=clientes&layout=recibodetalle&id=<?=$recibo->id?>" class="btn btn-success"><em class="fa fa-eye-open"></em> Ver detalle</a></td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>			

<? }else{vistaBloqueada();}?>