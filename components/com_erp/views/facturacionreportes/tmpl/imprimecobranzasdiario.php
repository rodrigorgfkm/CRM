<?php defined('_JEXEC') or die;
$tipo_f = JRequest::getVar('tipo_f','','get');
$desde = JRequest::getVar('fi_f', JRequest::getVar('fi_p','','get'),'get');
$hasta = JRequest::getVar('ff_f', JRequest::getVar('ff_p','','get'),'get');
$id_suc =  JRequest::getVar('id_sucursal');
$sucursal_actual = 'Todas las Sucursales';
foreach(getSucursales() as $sucursal){
    if($id_suc == $sucursal->id){
        $sucursal_actual = $sucursal->nombre.' ('.$sucursal->departamento.')';        
    }
}
$cambio = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10);
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
    .d{
        font-weight: 500;
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
        <h3 class="box-title text-center">Rengel Importaciones <br> La Paz - Bolivia </h3>		
        <h3 class="box-title pull-right">Fecha: <?=date('d/m/Y')?></h3>		
        <!-- Algunos botones si son necesarios -->
        <div class="box-body" >
          <center>
              <h3>REPORTE DIARIO DE COBRANZAS <br> (Por sucursal Detalle)</h3>
          </center>
          <? if($desde!=''){?>
          <div>
              <p class="pull-right">Hasta: <?=$hasta?></p>
              <p class="pull-right" style="margin-right:10px;">Del: <?=$desde?></p>
          </div>
          <? }?>
        </div>
      </div>
      <? 
        $texto_fecha = 'F. Registro';
        if($tipo_f == 1){
            $texto_fecha = 'F. Pago';
        }elseif($tipo_f==0){
            $texto_fecha = 'F. Registro';
        }?>
      <button type="button" class="btn btn-success col-xs-12" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
      <div class="box-body">
        <table class="table table-striped table-borderded">
            <thead class="lineas">
                <th width="200"><?=$texto_fecha?></th>
                <th width="120">N° de Fac.</th>
                <th width="200">NIT</th>
                <th width="280">Detalle</th>
                <th >Monto Bs.</th>
                <th width="200">Monto $us.</th>
                <th width="200">Cuenta</th>
                <th width="200">Concepto</th>                        
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="border-bottom:3px black solid;">
                        <h4>
                            <b>Sucursal: <?=$sucursal_actual?></b>
                        </h4>
                    </td>
                    <td colspan="2"></td>
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
                foreach (getCNTReporteCobranzas() as $cobranzas){
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
                                    echo $sum_cheq;
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
                            $dolar = num2monto($cobranzas->monto/$cambio);
                            echo $dolar;
                        ?></td>
                        <td><?=codigoRename($cobranzas->cuenta)?></td>
                    <td><?=$cobranzas->concepto?></td>
                    </tr>
                <? 
                }
                ?>
            </tbody>            
        </table>
        <table class="table table-striped table-borderded">
            <tbody class="lineas">
                <tr>
                    <td width="200"><b>Totales:</b></td>
                    <td width="120"><b><?=$c?> Factura(s)</b></td>
                    <td width="200"></td>
                    <td width="280"></td>
                    <td width="200"><b><?=num2monto($sum)?></b></td>
                    <td width="250" class="text-left"><b><?=num2monto($sum/$cambio)?></b></td>
                    <td width="200"></td>
                    <td width="200"></td>
                </tr>
            </tbody>
        </table>
        <div class="col-md-6">
            <div class="parrafo"><div class="i"><b>(**)</b></div>  <div class="c"><b>p/Cobrar:</b></div> <div class="d"><?=num2monto($sum_cobrar)?></div></div>
            <div class="parrafo"><div class="i"><b>(+)</b></div> <div class="c"><b>Compensasión:</b></div> <div class="d"><?=num2monto($sum_compen)?></div></div>
            <div class="parrafo"><div class="i"><b>(++)</b></div> <div class="c"><b>Incobrables:</b></div> <div class="d"><?=num2monto($sum_incob)?></div></div>
            <div class="parrafo"><div class="i"><b>(#)</b></div> <div class="c"><b>Ant. Personal:</b></div> <div class="d"><?=num2monto($sum_antper)?></div></div>
            <div class="parrafo"><div class="i"><b>(##)</b></div> <div class="c"><b>Otros:</b></div> <div class="d" style="border-bottom: 1px black solid;"><?=num2monto($sum_otros)?></div></div>
            <? $sumar_otros = num2monto($sum_cobrar+$sum_compen+$sum_incob+$sum_antper+$sum_otros);
               $sumar_otros_e = $sum_cobrar+$sum_compen+$sum_incob+$sum_antper+$sum_otros;
                
            ?>
            <div class="parrafo"><div class="i"><b></div> <div class="c"><b>Total Otros (Bs):</div></b> <div class="d"><b><?=$sumar_otros?></b></div></div>
        </div>
        <div class="col-md-6">
            <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Efectivo:</b></div> <div class="d"><?=num2monto($sum_efec)?></div></div>
            <div class="parrafo"><div class="i"><b>(*)</b></div> <div class="c"><b>Cheques:</b></div> <div class="d" style="border-bottom: 1px black solid;"><?=num2monto($sum_cheq)?></div></div>
            <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Deposito en Caja (Bs):</b></div> <div class="d"><?=num2monto($sum_cheq+$sum_efec)?></div></div>
            <div class="parrafo"><div class="i"><b>(&amp;)</b></div><div class="c"><b>Dep. Directo:</b></div> <div class="d"style="border-bottom: 1px black solid;"><?=num2monto($sum_directo)?></div></div>
            <?  $total_ingresos = num2monto($sum_cheq+$sum_efec+$sum_directo);
                $total_ingresos_e = $sum_cheq+$sum_efec+$sum_directo;
            ?>
            <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Total Ingresos (Bs): </b></div> <div class="d"style="border-bottom: 1px black solid;"><?=$total_ingresos?></div></div>
            <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Total General (Bs):</b></div> <div class="d"><b><?=num2monto($total_ingresos_e+$sumar_otros_e)?></b></div></div>
        </div>
        <div id="firma"><b>Victoria Fanola <br>Caja</b></div>
      </div>
    </div>
  </section>
</div>
<button type="button" class="btn btn-success col-xs-12" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>