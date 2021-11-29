<?php defined('_JEXEC') or die;
$id_suc = JRequest::getVar('id_sucursal','','post');
$f_i = JRequest::getVar('fecha_ini','','post');
$f_f = JRequest::getVar('fecha_fin','','post');
$cambio = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10)
?>
<style>
    .i{
        text-align: left;
        margin-right: 25px;
        display: inline-block;
        width: 70px;
    }
    .d,.c{
        text-align: right;
        width: 170px;
        display: inline-block;
    }
    center>.parrafo>div{
        display: inline-block;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-filetext-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte Diario de Cobranzas</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="box-body"  data-toggle="tooltip" title="Filtros">
          <!--<div class="btn-group" data-toggle="btn-toggle">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>-->
          <form action="" name="form" method="post">
              <select name="id_sucursal" id="id_sucursal" class="form-control" style="display:inline-block;width:auto;">
                <option value="">Seleccionar Sucursal</option>
                <? foreach(getSucursales() as $sucursal){?>					        
                    <option value="<?=$sucursal->id?>" <?=$id_suc==$sucursal->id?'selected':'';?>><?=$sucursal->nombre.' ('.$sucursal->departamento.')'?></option>
                <? }?>
              </select>
              <input type="text" name="fecha_ini" class="datepicker form-control" value="<?=$f_i?>" placeholder="Desde" style="display:inline-block;width:auto;">
              <input type="text" name="fecha_fin" class="datepicker form-control" value="<?=$f_f?>" placeholder="Hasta" style="display:inline-block;width:auto;">
              <button type="submit" id="enviar" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>
          </form>
        </div>
      </div>
      <? if($_POST){?>
          <div>
              <a href="index.php?option=com_erp&view=facturacionreportes&layout=imprimecobranzasdiario&id_sucursal=<?=$id_suc?>&fecha_ini=<?=$f_i?>&fecha_fin=<?=$f_f?>&tmpl=component" rel="shadowbox" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</a>
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
                        <td><?=$cobranzas->monto?></td>
                        <td><?
                            foreach(getFormasPago() as $forma){
                                if ($cobranzas->id_formapago == $forma->id){                                    
                                    $icono = $forma->figura;
                                }
                                switch ($forma->forma){
                                    case 'Efectivo':
                                        $sum_efec += $cobranzas->monto;
                                        break;
                                    case 'Cheque':
                                        $sum_cheq += $cobranzas->monto;
                                        break;
                                    case 'Por Cobrar':
                                        $sum_cobrar += $cobranzas->monto;
                                        break;
                                    case 'Incobrables':
                                        $sum_incob += $cobranzas->monto;
                                        break;
                                    case 'Ant. Personal':
                                        $sum_anteper += $cobranzas->monto;
                                        break;
                                    case 'Otros':
                                        $sum_otros += $cobranzas->monto;
                                        break;
                                    case 'Depósito Directo':
                                        $sum_directo += $cobranzas->monto;
                                        break;
                                }
                            }
                            $sum = $sum + $cobranzas->monto;
                            $dolar = num2monto($cobranzas->monto/$cambio);
                            echo $dolar.' '.$icono;
                        ?></td>
                        <td><?=$cobranzas->cuenta?></td>
                    <td><?=$cobranzas->concepto?></td>
                    </tr>
                <? 
                }
            }?>
            </tbody>
            <tfoot>
                <tr>
                    <td><b>Totales:</b></td>
                    <td><b><?=$c?> Factura(s)</b></td>
                    <td></td>
                    <td></td>
                    <td><b><?=num2monto($sum)?></b></td>
                    <td><b><?=num2monto($sum/$cambio)?></b></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <? 
        foreach (getFACformas() as $forma){
            echo '<pre>';
            print_r($forma);
            echo '</pre>';
        }
        if($_POST){?>
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
            <div class="parrafo"><div class="i"><b></b></div><div class="c"><b>Total General (Bs):</b></div> <div class="d"><?=num2monto($total_ingresos_e+$sumar_otros_e)?></div></div>
        </div>
        <center><b>Victoria Fanola <br>Caja</b></center>
        <? }?>
      </div>
    </div>
  </section>
</div>