<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
?>
<style>
    @media print{
        .imprim,.main-footer, form{
            display: none;
        }
        
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asociados con Pagos Anticipados</h3>
      </div>
      <?  if($_POST){?>
      <div class="imprim">
          <button type="button" class="btn btn-success pull-right" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</a>
      </div>
      <? }?>
      <form action="" class="form" name="form" id="form" method="POST">
        <label for="" style="display:inline-block;">Razón Social</label>
        <input type="text" name="empresa" id="empresa" class="form-control" value="<?=JRequest::getVar('empresa','','post')?>" placeholder="Razon Social o Empresa" style="display:inline-block;width:auto">
        <button type="submit" class="btn btn-success" style="display:inline-block;"><i class="fa fa-filter"></i> Filtrar</button>
      </form>
      <div class="box-body">
        <? if($_POST){?>
        <table class="table table-striped">
            <thead>
                <th>Reg. CNC</th>
                <th>Razón Social</th>
                <th>Cat</th>
                <th>Cobrador</th>
                <th>Mensajero</th>
                <th>Pago Hasta</th>
            </thead>
            <tbody>
                <? foreach(getRepPagosAnticipados() as $anticipo){?>
                <tr>
                    <td><?=$anticipo->registro?></td>
                    <td><?=$anticipo->empresa?></td>
                    <td><?=$anticipo->categoria?></td>
                    <td><?
                        $cob = getUsuarioext($anticipo->id_usuario_cobrador);
                        echo $cob->nombre;
                        ?>
                    </td>
                    <td><?
                        $msj = getUsuarioext($anticipo->id_usuario_mensajero);
                        echo $mjs->nombre;
                        ?>
                    </td>
                    <td><?=$anticipo->pago_hasta?></td>
                </tr>
               <? }?>
            </tbody>
        </table>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>