<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<style>
    @media print{
        .imp{
            display: none;
        }
    }
</style>
<?
$postbanco = JRequest::getvar('id','','get');
$del = JRequest::getvar('del','','get');
$al = JRequest::getvar('al','','get');
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Concilicación Bancaria</h3>
      </div>           
      <div class="box-body">
          <table class="table table-bordered table-striped table_vam">
              <thead>
                  <th>Fecha</th>
                  <th>Nº de Cheque</th>
                  <th>Nombre</th>
                  <th>Detalle</th>
                  <th>Debe</th>
                  <th>Haber</th>
                  <th>Saldo</th>
                  <th>Conciliar</th>
              </thead>
              <tbody>
                  <? 
                         $cont = 0;
                         foreach(getLBingeg($postbanco) as $libro){
                  //print_r($libro);?>
                          <tr>
                              <td class="fecha"><?=fecha($libro->fecha)?></td>
                              <td><?=$libro->numero?></td>
                              <td><?=$libro->nombre?></td>
                              <td><?=$libro->detalle?></td>
                              <td><?=$libro->debe?></td>
                              <td><?=$libro->haber?></td>
                              <? if($cont!=0){
                                    $saldo = $saldo - $libro->haber;
                                    $saldo = $saldo + $libro->debe;                                    
                                }else{
                                    $saldo = $libro->debe+0;
                                }    
                              ?>
                              <td><?=round($saldo)?></td>
                              <td>
                                 <?
                                  if($libro->conciliado==0){
                                    $texto = 'Sin Conciliar';
                                  }else{
                                    $texto = 'Conciliado';
                                  }
                                  ?>
                                  <?=$texto;?>
                              </td>
                          </tr>
                      <? $cont++;
                         }
                    ?>
              </tbody>
          </table>
          <button type="button" class="btn btn-success col-xs-12 imp" onclick="window.print()"><i class="fa-fa-print"></i> Imprimir</button>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>