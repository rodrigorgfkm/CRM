<?php defined('_JEXEC') or die;
$id_suc = JRequest::getVar('id_sucursal','','post');
$tipo_f = JRequest::getVar('tipo_f','','post');
$desde = JRequest::getVar('fi_f', JRequest::getVar('fi_p','','post'),'post');
$hasta = JRequest::getVar('ff_f', JRequest::getVar('ff_p','','post'),'post');
$cambio = readXML("https://www.bcb.gob.bo/rss_bcb.php", 10);
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
<script>
jQuery(document).on('ready', function(){
    jQuery('#tipo_f').on('change', function(){
        jQuery('#fechat').css('display','inline-block');
        jQuery('#id_desde').css('display','inline-block');
        jQuery('#id_hasta').css('display','inline-block');
        if(jQuery(this).val() == "1"){
            jQuery('#fechas').text('Fecha de Pago');
            jQuery('#fechat').text('Fecha de Pago');
            jQuery('#id_desde').attr('name','fi_p');
            jQuery('#id_hasta').attr('name','ff_p');
        }else if(jQuery(this).val() == "0"){
            jQuery('#fechas').text('Fecha de Registro');
            jQuery('#fechat').text('Fecha de Registro');
            jQuery('#id_desde').attr('name','fi_f');
            jQuery('#id_hasta').attr('name','ff_f');
        }
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-filetext-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte Diario de Cobranzas</h3>
		
        <!-- Algunos botones si son necesarios -->
        <div class="box-body"  data-toggle="tooltip" title="Filtros">
            <form action="" name="form" method="post">
                <select name="id_sucursal" id="id_sucursal" class="form-control" style="display:inline-block;width:auto;">
                    <option value="">Seleccionar Sucursal</option>
                <? foreach(getSucursales() as $sucursal){?>					        
                    <option value="<?=$sucursal->id?>" <?=$id_suc==$sucursal->id?'selected':'';?>><?=$sucursal->nombre.' ('.$sucursal->departamento.')'?></option>
                  <? }?>
                </select>
                <select id="tipo_f" name="tipo_f" class="form-control" style="display:inline-block;width:auto;">
                    <option value="">Seleccionar Tipo de Fecha</option>
                    <option value="0" <?=$tipo_f == '0'?'selected':''?>>Fecha de Registro</option>
                    <option value="1" <?=$tipo_f == '1'?'selected':''?>>Fecha de Pago</option>
                </select>
                <? 
                $texto_fecha = '';
                if($tipo_f == 1){
                    $texto_fecha = 'Fecha de Pago';
                }elseif($tipo_f==0){
                    $texto_fecha = 'Fecha de Registro';
                }?>
                <label for="" id="fechas" style="margin-right:10px;width:auto;display:<?=$tipo_f!=''?'inline-block':'none'?>"><?=$texto_fecha?></label> 
                <input type="text" name="<?=$tipo_f=='0'?'fi_f':'fi_p'?>" id="id_desde" class="datepicker form-control" value="<?=$desde?>" placeholder="Desde" style="display:<?=$tipo_f!=''?'inline-block':'none'?>;width:auto;">
                <input type="text" name="<?=$tipo_f=='0'?'ff_f':'ff_p'?>" id="id_hasta" class="datepicker form-control" value="<?=$hasta?>" placeholder="Hasta" style="display:<?=$tipo_f!=''?'inline-block':'none'?>;width:auto;">
                <button type="submit" id="enviar" class="btn btn-success"><i class="fa fa-filter"></i> Filtrar</button>
                <a class="btn btn-warning" href="index.php?option=com_erp&view=facturacionreportes&layout=cobranzasdiario"><em class="icon-exclamation-sign icon-white"></em> Limpiar</a>
            </form>
        </div>
      </div>
      <? if($_POST){
            $d1 = JRequest::getVar('fi_f','','post');
            $h1 = JRequest::getVar('ff_f','','post');
            $d2 = JRequest::getVar('fi_p','','post');
            $h2 = JRequest::getVar('ff_p','','post');
           ?>
          <div>
              <a href="index.php?option=com_erp&view=facturacionreportes&layout=imprimecobranzasdiario&id_sucursal=<?=$id_suc?>&fi_f=<?=$d1?>&ff_f=<?=$h1?>&fi_p=<?=$d2?>&ff_p=<?=$h2?>&tipo_f=<?=$tipo_f?>tmpl=component" rel="shadowbox" class="btn btn-success pull-right"><i class="fa fa-print"></i> Imprimir</a>
          </div>
      <? }?>
      <div class="box-body">
        <table class="table table-striped table-borderded datatable">
            <thead>
                <th id="fechat"><?=$texto_fecha?></th>
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
                $c++;/*                    
                echo '<pre>';
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
                            $dolar = num2monto($cobranzas->monto/$cambio);
                            echo $dolar.' '.$icono;
                        ?></td>
                        <td><?=codigoRename($cobranzas->cuenta)?></td>
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
                    <td><?=$sum_efec?></td>
                </tr>
            </tfoot>
        </table>
        <? 
        foreach (getFACformas() as $forma){/*
            echo '<pre>';
            print_r($forma);
            echo '</pre>';*/
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