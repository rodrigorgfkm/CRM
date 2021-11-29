<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Cambio')){
$moneda = getMoneda()?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Hist&oacute;rico de tipo de cambio del <?=$moneda->moneda?> (<?=$moneda->simbolo?>)</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <a href="index.php?option=com_erp&view=contacambio&layout=nuevo&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success">Nuevo tipo de cambio</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th width="20">#</th>
              <th>Fecha</th>
              <th>Cambio</th>
            </tr>
          </thead>
          <tbody>
            <?php $n = 0;
        foreach(getTipoCambio() as $cambio){
            $n++;?>
            <tr>
              <td><?=$n?></td>
              <td><?=$cambio->fecha?></td>
              <td><?=$cambio->cambio?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>