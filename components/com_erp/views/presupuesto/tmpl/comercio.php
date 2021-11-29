<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
if(validaAcceso('Asignación de Presupuestos')){	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mesp', '01', 'post');
    $cuentas = JRequest::getVar('cuent', '', 'post');
    $moneda = JRequest::getVar('moneda', '1', 'post');
    switch ($mes){
        case '01':
            $mesact = 'Enero';
            break;
        case '02':
            $mesact = 'Febrero';
            break;
        case '03':
            $mesact = 'Marzo';
            break;
        case '04':
            $mesact = 'Abril';
            break;
        case '05':
            $mesact = 'Mayo';
            break;
        case '06':
            $mesact = 'Junio';
            break;
        case '07':
            $mesact = 'Julio';
            break;
        case '08':
            $mesact = 'Agosto';
            break;
        case '09':
            $mesact = 'Septiembre';
            break;
        case '10':
            $mesact = 'Octubre';
            break;
        case '11':
            $mesact = 'Noviembre';
            break;
        case '12':
            $mesact = 'Diciembre';
            break;
    }
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var mes = jQuery('#mes').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=pormes&id='+id+'&mes='+mes;
	}

jQuery(function () {
	jQuery("input[type=text]").focus(function(){	   
		this.select();
		});	
	});
</script>
<style>
    #textocentro{
        display: none;
    }
    @media print{
        .print,.main-footer{
            display: none;
        }
        #textocentro{
            display: block;
        }
    }
    thead{
        border: double black 3px;
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
        <div class="box-header">            
            <h3 class="box-title text_center">Rengel Importaciones SRL.<BR> La Paz - Bolivia <br>NIT 1020743029</h3>
            <h3 class="box-title pull-right">Fecha: <?=date('d/m/Y')?><br>Usuario: <?=$user->name?></h3>
        </div>
        <h4 class="text-center">REPORTE COMERCIO DEL PRESUPUESTO DEL MES<br>Gestión: <?=$mesact?> <?=date('Y')?><br><span style="display:<?=$moneda==1?'none':'block'?>">(Expresado en Dólares Americanos)</span></h4>
      <div class="box-body print">
        <div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-2">
                    	Seleccionar Gestión: 
                	</label>
                    <div class="col-xs-12 col-sm-8">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){
                              if($ge->id==$id){
                                    $selected_g = 'selected';
                                    $gestion = $ge->gestion;
                                }else{
                                    $selected_g = '';
                                }?>
                              <option value="<?=$ge->id?>" <?=$selected_g?>><?=$ge->gestion?></option>
                            <? }?>
                    	</select>
                        <select name="mesp" id="mesp" class="form-control" style="width:auto; display:inline">
                            <option value="">Mes</option>
                            <option value='01' <?=$mes=='01'?'selected':'';?>>Enero</option>
                            <option value='02' <?=$mes=='02'?'selected':'';?>>Febrero</option>
                            <option value='03' <?=$mes=='03'?'selected':'';?>>Marzo</option>
                            <option value='04' <?=$mes=='04'?'selected':'';?>>Abril</option>
                            <option value='05' <?=$mes=='05'?'selected':'';?>>Mayo</option>
                            <option value='06' <?=$mes=='06'?'selected':'';?>>Junio</option>
                            <option value='07' <?=$mes=='07'?'selected':'';?>>Julio</option>
                            <option value='08' <?=$mes=='08'?'selected':'';?>>Agosto</option>
                            <option value='09' <?=$mes=='09'?'selected':'';?>>Septiembre</option>
                            <option value='10' <?=$mes=='10'?'selected':'';?>>Octubre</option>
                            <option value='11' <?=$mes=='11'?'selected':'';?>>Noviembre</option>
                            <option value='12' <?=$mes=='12'?'selected':'';?>>Diciembre</option>
                        </select>
                        <select name="cuent" id="cuent" class="form-control" style="width:auto; display:inline">
                            <option value="">Seleccionar Cuenta</option>
                            <option value='3__001' <?=$cuentas=='3__001'?'selected':'';?>>3.XX0010000</option>
                            <option value='4__001' <?=$cuentas=='4__001'?'selected':'';?>>4.XX0010000</option>
                            <option value='4__003' <?=$cuentas=='4__003'?'selected':'';?>>4.XX0030000</option>
                            <option value='4__008' <?=$cuentas=='4__008'?'selected':'';?>>4.XX0080000</option>
                        </select>
                        <select name="moneda" id="moneda" class="form-control" style="width:auto; display:inline">
                            <option value='1' <?=$moneda==1?'selected':''?>>Bolivianos</option>
                            <option value=<?=readXML("https://www.bcb.gob.bo/rss_bcb.php", 10)?> <?=$moneda!=1?'selected':''?>>Dólares Americanos</option>
                        </select>
                        <button type="submit" class="btn btn-success" style="width:auto; display:inline"><i class="fa fa-filter"></i> Filtrar</button>
                        <!--<input type="text" name="fecha" class="datepicker form-control" value="<?=$fecha_ini?>" placeholder="Fecha" style="display:inline-block;width:auto;">              -->
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="container col-xs-12 print">
            <button class="btn btn-primary pull-right print" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
            <form action="components/com_erp/views/presupuesto/tmpl/exporta_resumen.php" name="form1" id="form1" method="post">
                <input type="hidden" name="id_gestion_e" value="<?=$id?>">
                <input type="hidden" name="mes_e" value="<?=$mes?>">
                <input type="hidden" name="cuenta_e" value="<?=$cuentas?>">
                <input type="hidden" name="moneda_e" value="<?=$moneda?>">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
            </form>
      </div>      
      <div class="box-body">
       <center id="textocentro"><h4>Mes de <?=$mesact?>, Gestión <?=$gestion?></h4></center>
       <? if($_POST){?>
        <table class="table table-striped table-bordered">
            <thead>
                <th width="80" class="text-center">CUENTAS</th>
                <th width="40" class="text-center">PRESUPUESTO<br> <?='31/12/'.$gestion?></th>
                <th width="40" class="text-center">PRESUPUESTO<br><?=$mesact?></th>
                <th width="40" class="text-center">EJEC.<br><?=$mesact?></th>
                <th width="40" class="text-center">DIF. </th>
                <th width="40" class="text-center">PRESUP.ACUM. A:<br><?=$mesact?></th>
                <th width="40" class="text-center">EJEC.ACUM. A:<br><?=$mesact?></th>
                <th width="40" class="text-center">DIF.ACUM.</th>
                <th width="40" class="text-center">%</th>
                <th width="40" class="text-center">S/TOTAL<br>GESTIÓN</th>
            </thead>
            <tbody>
            <? 
            //CUENTAS 3XX001....
            // INGRESOS POR SERVICIOS
            $n = 1;
            $sumpre = 0;
            $sumpre2 = 0;
            $sumeje =0;
            $sumdif = 0;
            $sumacum = 0;
            $sumeje2 = 0;
            $sumdife = 0;
            $sumdifeacu = 0;
            $sumtot = 0;
            foreach(getRepPresupuestos($cuentas) as $cta){?>
            <tr>
                <td><?=codigoRename($cta->codigo)?> <br> <?=$cta->nombre?></td>
                <td class="text-right">
                    <? 
                    $monto = getPresupuestado($cta->id, $cta->id_gestion);
                    if($monto == '' or $monto == 0)
                       $monto = 0.00;
                     
                    $monto = $monto/$moneda;
                    echo num2monto($monto);
                     $sumpre= $monto + $sumpre; 
                     
                    ?>
                </td>
                <td class="text-right">
                   <? $p_mes = getPMesesBefore($cta->id,$mes, $id);
                        if($p_mes == '')
                            $p_mes = 0.00;
                        $p_mes = $p_mes/$moneda;
                    echo num2monto($p_mes);
                    $sumpre2=$p_mes + $sumpre2;  
                   ?>
                </td>
                <td class="text-right"><?
                    //EJECUTADO GESTION ACTUAL
                    $totalmes_debe = 0;
                    $totalmes_haber = 0;
                    $p_e = 0;
                    foreach (getCuentasComprobante($cta->id,$mes) as $ctames){
                        $totalmes_debe += $ctames->debe;
                        $totalmes_haber += $ctames->haber;
                        $p_e = $totalmes_debe - $totalmes_haber;
                    }                    
                    $p_e = $p_e/$moneda;
                    echo num2monto($p_e);
                    $sumeje = $p_e + $sumeje;
                ?>
                </td>
                <td class="text-right">
                    <? $dif = $p_e-$p_mes;
                        
                        echo num2monto($dif);
                       $sumdif = $sumdif + $dif;                                        
                    ?>
                </td>
                <td class="text-right">
                    <?  //ACUMULADO
                        $p_acumulado = 0;
                        for ($i = $mes; $i > 0; $i--){
                            $meses_pa = getPMesesBefore($cta->id,$i, $id);
                            if($meses_pa==''){
                                $meses_pa = 0;
                            }
                            $p_acumulado = $p_acumulado + $meses_pa;
                        }
                        $p_acumulado = $p_acumulado/$moneda;
                        echo num2monto($p_acumulado);
                          $sumacum = $sumacum +  $p_acumulado;
                    ?>
                </td>
                <td class="text-right">
                    <?  
                        $e_acumulado = 0;
                        for ($i = $mes; $i > 0; $i--){
                            $total_debe = 0;
                            $total_haber = 0;
                            $mes_i = strlen($i)==1?'0'.$i:$i;
                            foreach(getCuentasComprobante($cta->id,$mes_i) as $detalle){
                                $total_debe+= $detalle->debe;
                                $total_haber+= $detalle->haber;                                
                            }
                            $totalac = $total_debe - $total_haber;
                            $e_acumulado = $totalac+$e_acumulado;
                        }
                        $e_acumulado = $e_acumulado/$moneda;
                    ?>
                    <?=num2monto($e_acumulado)?>
                    <? $sumeje2=$e_acumulado +$sumeje2;?>
                </td>
                <td class="text-right">
                 <? $dif_acumulada = $e_acumulado - $p_acumulado;
                    $dif_acumulada = $dif_acumulada/$moneda;
                  echo num2monto($dif_acumulada);
                ?>
                <? $sumdifeacu = $sumdifeacu + $dif_acumulada?>
                </td>
                <td class="text-right">
                    <?  $diff = $dif_acumulada/$p_acumulado;
                        $diff = $diff * 100;
                        //PORCENTAJE
                        $t_diff = is_nan($diff)!=1&is_infinite($diff)!=1?$diff:'0,00';
                        $t_diff = $t_diff/$moneda;
                        $t_diff = is_nan($t_diff)!=1&is_infinite($t_diff)!=1?$t_diff:'0,00';
                        echo num2monto($t_diff);
                        $t_diff = floatval($t_diff);
                        $sumdife = num2monto($t_diff)+$sumdife;
                    ?>
                </td>
                <td class="text-right">
                    <?  
                        $total_cta = ($e_acumulado/$monto)*100;
                        //PORCENTAJE TOTAL DE LA GESTION
                        $t_cta = is_nan($total_cta)!=1&is_infinite($total_cta)!=1?$total_cta:'0,00';
                        $t_cta = $t_cta/$moneda; 
                        echo num2monto($t_cta);
                        $t_cta = floatval($t_cta);
                        $sumtot = $t_cta + $sumtot;
                    ?>
                </td>
            </tr>
            <? $n++;
               $sumt= $sumt + $n;                                                
            }?>
            <tr style="border-top:2px black solid">
                <td><b>TOTAL RUBRO</b></td>
                <td class="text-right"><b><?= num2monto($sumpre);?></b></td>
                <td class="text-right"><b><?= num2monto($sumpre2);?></b></td>
                <td class="text-right"><b><?= num2monto($sumeje);?></b></td>
                <td class="text-right"><b><?= num2monto($sumdif);?></b></td>
                <td class="text-right"><b><?= num2monto($sumacum);?></b></td>
                <td class="text-right"><b><?= num2monto($sumeje2);?></b></td>
                <td class="text-right"><b><?= num2monto($sumdifeacu);?></b></td>
                <td class="text-right"><b><?= num2monto($sumdife);?></b></td>
                <td class="text-right"><b><?= num2monto($sumtot);?></b></td>
            </tr>
            </tbody>
        </table>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>