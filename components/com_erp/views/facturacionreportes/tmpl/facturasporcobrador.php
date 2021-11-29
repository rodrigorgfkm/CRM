<?php defined('_JEXEC') or die;
$id_cobrador = JRequest::getVar('id_cobrador','','post');
$fecha_ini = JRequest::getVar('fecha_ini', '', 'post');
$fecha_fin = JRequest::getVar('fecha_fin', '', 'post');
$dolar = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10);
?>
<style>
.i{
        text-align: left;
        margin-right: 25px;
        display: inline-block;
        width: 20px;
    }
    .d,.c{
        text-align: right;
        width: 150px;
        display: inline-block;
    }
    center>.parrafo>div{
        display: inline-block;
    }
    .lineas{
        border-bottom: 3px black solid !important;
        border-top: 3px black solid !important;
    }
    #firma{
        margin-top: 250px;
        text-align: center;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-filetext-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte de Facturas por Cobrador</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="box-body"  data-toggle="tooltip" title="Filtros">
          <!--<div class="btn-group" data-toggle="btn-toggle">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>-->
          <form action="" name="form" method="post">
              <select name="id_cobrador" id="id_cobrador" class="form-control" style="display:inline-block;width:auto;">
                <option value="">Seleccionar Cobrador</option>
                <? foreach(getUsuariosext('c',1) as $usuario){?>
                    <option value="<?=$usuario->id?>" <?=$usuario->id==$id_cobrador?'selected':'';?>><?=$usuario->nombre?></option>
                <? }?>
              </select>
              <input type="text" name="fecha_ini" class="datepicker form-control" value="<?=$fecha_ini?>" placeholder="Desde" style="display:inline-block;width:auto;">
              <input type="text" name="fecha_fin" class="datepicker form-control" value="<?=$fecha_fin?>" placeholder="Hasta" style="display:inline-block;width:auto;">
              <button type="submit" id="enviar" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>
          </form>
        </div>
      </div>
      <? if($_POST){
        $cob = $id_cobrador!=''?'&cob='.$id_cobrador:'';
        $ini = $fecha_ini!=''?'&ini='.$fecha_ini:'';
        $fin = $fecha_fin!=''?'&fin='.$fecha_fin:'';
        ?>
      <div class="box-body">
          <a href="index.php?option=com_erp&view=facturacionreportes&layout=imprimecobrador&tmpl=component<?=$cob.$ini.$fin?>" class="btn btn-success pull-right" rel="shadowbox"><i class="fa fa-print"></i> Imprimir</a>
      </div>
      <? }?>
      <div class="box-body">
        <table class="table table-striped table-borderded datatable">
            <thead>
                <th>Fecha</th>
                <th>N° de Fac.</th>
                <th>NIT</th>
                <th width="200">Detalle</th>
                <th>Monto Bs.</th>
                <th>Monto $us.</th>
                <th>Cuenta</th>
                <th width="200">Concepto</th>                        
            </thead>
            <tbody>
                <? if($_POST){
                $c = 0;
                $sum = 0;
                $sum_cheq = 0;
                $sum_efec = 0;
                $sum_cobrar = 0;
                $sum_compen = 0;
                $sum_incob = 0;
                $sum_antper = 0;
                $sum_otros = 0;
                $sum_directo = 0;
                $sum_incob = 0;
                $sum_pers = 0;
                $sum_otros = 0;
                $sum_directo = 0;
                foreach(getCNTReporteFacturas() as $cobranzas){
                $c++;
                /*echo '<pre>';
                print_r($cobranzas);
                echo '</pre>';*/
                ?>
                    <tr>
                        <td><?=fecha($cobranzas->fecha)?></td>
                        <td><?=$cobranzas->numero?></td>
                    <td><?=$cobranzas->nit?></td>
                        <td><?=$cobranzas->detalle?></td>
                        <td><?=$cobranzas->monto?></td>
                        <td><?
                            foreach(getFormasPago() as $forma){
                                if ($cobranzas->id_formapago == $forma->id){
                                    $icono = $forma->figura;
                                }
                            }
                            switch ($cobranzas->id_formapago){
                                case '1':
                                    $sum_efec += $cobranzas->monto;
                                    /*echo '</br>';
                                    echo $sum_efec;*/
                                    break;
                                case '2':
                                    $sum_cheq += $cobranzas->monto;
                                    //echo $sum_cheq;
                                    break;
                                case '12':
                                    $sum_cobrar += $cobranzas->monto;
                                    break;
                                case '13':
                                    $sum_compen += $cobranzas->monto;
                                    break;
                                case '14':
                                    $sum_incob += $cobranzas->monto;
                                    break;
                                case '16':
                                    $sum_anteper += $cobranzas->monto;
                                    break;
                                case '15':
                                    $sum_otros += $cobranzas->monto;
                                    break;
                                case '17':
                                    $sum_directo += $cobranzas->monto;
                                    break;
                            }
                            $sum = $sum + $cobranzas->monto;
                            $sum_dolar = num2monto($cobranzas->monto/$dolar);
                            echo $sum_dolar.' '.$icono;
                        ?></td>
                        <td><?=$cobranzas->cuenta?></td>
                    <td><?=$cobranzas->concepto?></td>
                    </tr>
                <? }
                }?>
            </tbody>
            <tfoot>
                <tr>
                    <td><b>Totales:</b></td>
                    <td><b><?=$c?> Factura(s)</b></td>
                    <td></td>
                    <td></td>
                    <td><b><?=num2monto($sum)?></b></td>
                    <td><b><?=num2monto($sum/$dolar)?></b></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="col-md-12">
            <center>
                <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Efectivo:</b></div> <div class="d"><?=num2monto($sum_efec)?></div></div>
                <div class="parrafo"><div class="i"><b>(*)</b></div> <div class="c"><b>Cheques:</b></div> <div class="d lineainf"><?=num2monto($sum_cheq)?></div></div>
                <? $suma_ch = num2monto($sum+$sum_cheq)?>
                <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Total Deposito (Bs):</b></div> <div class="d"><?=num2monto($sum_efec+$suma_cheq)?></div></div>
                <div class="parrafo"><div class="i"><b>(**)</b></div><div class="c"><b>p/ Cobrar:</b></div> <div class="d"><?=num2monto($sum_cobrar)?></div></div>
                <div class="parrafo"><div class="i"><b>(+)</b></div><div class="c"><b>Compensación:</b></div> <div class="d"><?=num2monto($sum_compen)?></div></div>
                <div class="parrafo"><div class="i"><b>(++)</b></div><div class="c"><b>Incobrables:</b></div> <div class="d"><?=num2monto($sum_incob)?></div></div>
                <div class="parrafo"><div class="i"><b>(&amp;)</b></div><div class="c"><b>Dep. Directo:</b></div> <div class="d"><?=num2monto($sum_directo)?></div></div>
                <div class="parrafo"><div class="i"><b>(#)</b></div><div class="c"><b>Ant Personal:</b></div> <div class="d"><?=num2monto($sum_anteper)?></div></div>
                <div class="parrafo"><div class="i"><b>(##)</b></div><div class="c"><b>Otros:</b></div> <div class="d lineainf"><?=num2monto($sum_otros)?></div></div>
                <? $total_total = num2monto($sum_efec+$sum_cheque+$sum_cobrar+$sum_compen+$sum_incob+$sum_directo+$sum_anteper+$sum_otros)?>
                <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Total Reporte (Bs): </b></div> <div class="d"><?=$total_total?></div></div>
            </center>
        </div>
        <center id="firma"><b>Victoria Fanola Pinell<br>Registro de Asociados</b></center>
      </div>
    </div>
  </section>
</div>