<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-key"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Llaves de Dosificación</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th width="100">Autorización</th>
                    <th width="60">F. Límite</th>
                    <th>Llave</th>
                    <th width="150">Sucursal</th>
                    <th width="100">Tipo</th>
                    <th width="50">Activa</th>
                    <th width="50">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getLlaves() as $llave){
                    if($llave->estado == 1 && $llave->fecha_limite >= date('Y-m-d')){
                        $star = 'star';
                        $starboton = 'btn-success';
                        $title = 'Llave activa';
                        }else{
                        $star = 'star-empty';
                        $starboton = 'btn-warning';
                        $title = '';
                        }
                      ?>
                <tr>
                    <td><strong><?=$llave->autorizacion?></strong></td>
                    <td><?=fecha($llave->fecha_limite)?></td>
                    <td><?=$llave->llave?></td>
                    <td><?=$llave->nombre?></td>
                    <td><?=$llave->factura?></td>
                    <td><a class="btn col-xs-12 <?=$starboton?>" style="cursor:default" data-toggle="tooltip" title="<?=$title?>"><em class="fa fa-<?=$star?>"></em></a></td>
                    <td>
                        <? if($llave->estado == 0 && verifyFactura($llave->id) == ''){?>
                        <a href="index.php?option=com_erp&view=facturacion&layout=llaveelimina&id=<?=$llave->id?>" data-toggle="tooltip" title="Eliminar llave" class="btn col-xs-12 btn-danger"><i class="fa fa-trash"></i></a>
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
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>