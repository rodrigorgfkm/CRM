<?php defined('_JEXEC') or die;
$dolar = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10);
$desde = JRequest::getVar('ini');
$hasta = JRequest::getVar('fin');
$cob = JRequest::getVar('cob');
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
    .lineainf{
        border-bottom: 1px black solid;
    }
@media print{
    .btn-success{
        display: none;
    }
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-filetext-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title text-center">Rengel Importaciones <br>La Paz - Bolivia <br> RUC 2267071</h3>
        <h3 class="box-title pull-right">Fecha: <?=date('d/m/Y')?></h3>	
        <!-- Algunos botones si son necesarios -->
        <div class="box-body">
          <button class="btn btn-success col-xs-12" type="button" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
        </div>
      </div>
      <h2 class="box-title text-center">Reporte de Facturas por Cobrador</h2>
      <h4 class="text-center">(Detalle)</h4>
      <? if($desde!=''){?>
      <div>
          <p class="text-center">- Fecha de Reporte -</p>
          <p class="pull-right">Del: <?=$hasta?></p>
          <p class="pull-right" style="margin-right:10px;">Al: <?=$desde?></p>
      </div>
      <? }?>
      <div class="box-body">
        <table class="table table-striped table-borderded">
            <thead>
                <th width="100">Fecha</th>
                <th width="100">N° de Fac.</th>
                <th width="150">NIT</th>
                <th width="195">Detalle</th>
                <th width="150">Monto Bs.</th>
                <th width="150">Monto $us.</th>
                <th width="100">Cuenta</th>
                <th width="200">Concepto</th>                        
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="border-bottom: 6px double black">
                    <? foreach(getUsuariosext('c',1) as $usuario){
                        if($usuario->id==$cob){
                          $cobrador = $usuario->nombre;  
                        }}
                        echo 'Cobrador: '.$cobrador;
                    ?>
                    </td>
                    <td colspan="5"></td>
                </tr>
                <?
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
                foreach (getCNTReporteFacturas() as $cobranzas){
                $c++;
                ?>
                    <tr>
                        <td><?=fecha($cobranzas->fecha)?></td>
                        <td><?=$cobranzas->numero?></td>
                    <td><?=$cobranzas->nit?></td>
                        <td><?=$cobranzas->detalle?></td>
                        <td class="text-right"><?=$cobranzas->monto?></td>
                        <td class="text-right"><?
                            foreach(getFormasPago() as $forma){
                                if ($cobranzas->id_formapago == $forma->id){                                    
                                    $icono = $forma->figura;
                                }
                            }
                            switch ($cobranzas->id_formapago){
                                case '1':
                                    $sum_efec += $cobranzas->monto;
                                    break;
                                case '2':
                                    $sum_cheq += $cobranzas->monto;
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
            <? }?>
            </tbody>
        </table>
        <table class="table table-striped table-borderded">
            <tbody>
                <tr>
                    <td width="100"><b>Totales:</b></td>
                    <td width="100"><b><?=$c?> Factura(s)</b></td>
                    <td width="150"></td>
                    <td width="325"></td>
                    <td width="150"><b><?=num2monto($sum)?></b></td>
                    <td width="150"><b><?=num2monto($sum/$dolar)?></b></td>
                    <td width="70"></td>
                    <td width="200"></td>
                </tr>
            </tbody>
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
      <div class="box-body">
          <button class="btn btn-success col-xs-12" type="button" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
      </div>
    </div>
  </section>
</div>