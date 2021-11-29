<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
$comprobante = getComprobante();
$empresa = getEmpresa();
$tipo = JRequest::getVar('t','','get');
$numerox = "690px";
$numeroy = "120px";
$fechay = "140px";
$totalt = "625px";
$alto = "1053px";
if($tipo=="Ingreso"){
    $typecom = "ingreso";
    $tamaño = "113px";
    $tamaño1 = "64px";
}elseif($tipo=="Egreso"){
    $typecom = "egreso";        
    $numerox = "660px";
    $numeroy = "105px";
    $fechay = "130px";
    $totalt = "630px";
    $tamaño = "100px";
    $tamaño1 = "64px";
}else{
    $typecom = "diario";
    $fechay = "145px";
    $totalt = "610px";
    $alto = "1045px";
    $tamaño = "113px";
    $tamaño1 = "64px";
}
?>
<style>
    @media print{
        img{
            opacity: 0;
        }
        body, .content{
            margin : 0 !important;
            padding : 0 !important;
            height: auto;
        }
    }
    img{
        position: absolute;
    }
    #contenido{
        height: <?=$alto?>;
        width: 812px;
        position: relative;
    }
    #cliente{
        position: relative;
        left: 170px;
        top: 150px;
    }
    #numero{
        position: absolute;
        left: <?=$numerox?>;
        top: <?=$numeroy?>;
    }
    #dia{
        position: absolute;
        left: 103px;
        bottom: <?=$fechay?>;
    }
    #mes{
        position: absolute;
        left: 170px;
        bottom: <?=$fechay?>;
    }
    #anio{
        position: absolute;
        left: 310px;
        bottom: <?=$fechay?>;
    }
    table{
        position: absolute;
        top: 210px;
        left: 60px;
    }
    .montos{
        padding-left: <?=$tamaño1?>;
        text-align: right;
    }
    .montos1{
        padding-left: <?=$tamaño?>;
        text-align: right;
    }
    .detalle{
        width: 440px;
    }
    .debe, .haber{
        width: 120px;
    }
    tfoot{
        position: absolute;
        top: <?=$totalt?>;
        right: 8px;
    }
</style>
<div id="contenido">
    <img src="media/comprobantes/<?=$typecom?>.jpg" width="100%" height="<?=$alto?>">
    <p id="numero"><?=$comprobante->numero?></p>
    <p id="cliente" style="<?=$typecom=="ingreso"?'display:none':''?>"><?=$comprobante->cliente?></p>
    <table>
        <thead>
            <th class="detalle" ></th>
            <th class="debe"></th>
            <th class="haber"></th>
        </thead>
        <tbody>
            <? 
            $total_debe = 0;
            $total_haber = 0;
            foreach(getComprobanteDetalle() as $detalle){
                $total_debe+= $detalle->debe;
                $total_haber+= $detalle->haber;?>
                <tr>
                    <td><?=$detalle->cuenta?></td>
                    <td class="montos1"><?=number_format($detalle->debe,2,",",".")?></td>
                    <td class="montos"><?=number_format($detalle->haber,2,",",".")?></td>
                </tr>
            <? }?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td style="width:115px"><?=number_format($total_debe,2,",",".")?></td>
                <td><?=number_format($total_haber,2,",",".")?></td>
            </tr>
        </tfoot>
    </table>
    <?
    $fecha = explode('-',$comprobante->fec_creacion);
    switch($fecha[1]){
        case '01':
            $mes = "Enero";
            break;
        case '02':
            $mes = "Febrero";
            break;
        case '03':
            $mes = "Marzo";
            break;
        case '04':
            $mes = "Abril";
            break;
        case '05':
            $mes = "Mayo";
            break;
        case '06':
            $mes = "Junio";
            break;
        case '07':
            $mes = "Julio";
            break;
        case '08':
            $mes = "Agosto";
            break;
        case '09':
            $mes = "Septiembre";
            break;
        case '10':
            $mes = "Octubre";
            break;
        case '11':
            $mes = "Noviembre";
            break;
        case '12':
            $mes = "Diciembre";
            break;
    }
    ?>
    <p id="dia"><?=$fecha[2]?></p>
    <p id="mes"><?=$mes?></p>
    <p id="anio"><?=$fecha[0]?></p>
</div>
<button type="button" class="btn btn-block btn-success imprime col-xs-12" onClick="Imprime()">Imprimir</button>
<script>
function Imprime(){
	jQuery('.imprime').hide();
	window.print();
	window.parent.Shadowbox.close();
	}
</script>
<? }else{ vistaBloaqueada();}?>