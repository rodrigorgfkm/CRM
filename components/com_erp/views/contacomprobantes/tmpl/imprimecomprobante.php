<?php defined('_JEXEC') or die;
$pag = JRequest::getVar('p', 1, 'get');
$pa =JRequest::getVar('pag', '', 'get');
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
    $tamaño = "237px";
    $tamaño1 = "102px";
    $derecha = "91px";
    $derecha1 = "0px";
    $det1 = "59%";
    $der = "-35px";
    $position = "position: absolute;";
    $fechay = "157px";
    $rigt = "0";
    $comp="I";
}elseif($tipo=="Egreso"){
    $typecom = "egreso";        
    $numerox = "660px";
    $numeroy = "105px";
    $fechay = "152px";
    $totalt = "620px";
    $tamaño = "70px";
    $tamaño1 = "64px";
    $der = "8px";
    
    $comp="E";
}else{
    $typecom = "diario";
    $fechay = "145px";
    $totalt = "610px";
    $alto = "1045px";
    $tamaño = "113px";
    $tamaño1 = "64px";
    $der = "8px";
    $comp="D";
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
        padding-right: <?=$derecha1?>;
        <?=$position?>
        right: <?=$rigt?>;
    }
    .montos1{
        padding-left: <?=$tamaño?>;
        text-align: right;
        padding-right: <?=$derecha?>;
        <?=$position?>
            right: <?=$rigt?>;
    }
    .det1{
       /* width:<?=$det1?>;
            max-width: 1200px;
        */
      position: relative;
        max-width: 376px;
    /*width: 77%;
    max-width: 40px;*/
    }
    .det{
        position: absolute;
        bottom: 246px;
        margin-left: 77px;
        width: 440px;
            
    }
    .detalle{
        width: 425px;
    }
    .debe, .haber{
        width: 120px;
    }
    tfoot{
        position: absolute;
        top: <?=$totalt?>;
        right: <?=$der?>;
        
    }
</style>
<script>
jQuery('#imprime').fadeOut();
</script>
<? $s=0;
    $total_debe = 0;
            $total_haber = 0;
    foreach(getComprobanteDetalle() as $d){
        $s++;
        $total_debe+= $d->debe;
                $total_haber+= $d->haber;
    }
		  $cant = 8;
    
              $spaginas = $s / $cant;
    
	           if(($npagina % $cant) != 0)
		          $spaginas = ceil($paginas);
                    $spaginas= $spaginas+1 ;

            $cantPages = $spaginas;
            
		  $url = 'index.php?option=com_erp&view=contacomprobantes&layout=imprimecomprobante&id='.JRequest::getVar('id', '', 'get').'&t='.$tipo.'&pag='.$pa.'&tmpl=component';
          if(!empty($cantPages)){
		  ?>
		  <div class="row-fluid paginacion imprime">
			<div class="span12">
          <strong>Paginacion:</strong>
			  <div  class="btn-group clearfix sepH_a">
				  <a href="<?=$url?>" class="btn ttip_t" title="Ir a la primera página">&lArr;</a>
				  <a href="<?=$url?>&p=<?=($pag-1)?>" class="btn ttip_t" title="Ir a la página anterior">&larr;</a>
				  <? 
				  for($i=1; $i<=$cantPages; $i++){
					if($pag == $i){?>
					<a class="btn btn-info"><?=$i?></a>
					<? }elseif($i < ($pag + 5) && $i > ($pag - 5)){?>
					<a href="<?=$url?>&p=<?=$i?>" class="btn ttip_t" title="Ir a la página <?=$i?>"><?=$i?></a>
				  <? }
				  }?>
				  <a href="<?=$url?>&p=<?=($pag+1)?>" class="btn ttip_t" title="Ir a la página siguiente">&rarr;</a>
				  <a href="<?=$url?>&p=<?=$cantPages?>" class="btn ttip_t" title="Ir a la última página">&rArr;</a>
			  </div>
			</div>
		  </div>
        <? }?>
<div id="contenido">
   <?
    $fecha = explode('-',$comprobante->fec_creacion);
    switch($fecha[1]){
        case '01':
            $mes1 = "01";
            break;
        case '02':
            $mes1 = "02";
            break;
        case '03':
            $mes1 = "03";
            break;
        case '04':
            $mes1 = "04";
            break;
        case '05':
            $mes1 = "05";
            break;
        case '06':
            $mes1 = "06";
            break;
        case '07':
            $mes1 = "07";
            break;
        case '08':
            $mes1 = "08";
            break;
        case '09':
            $mes1 = "09";
            break;
        case '10':
            $mes1 = "10";
            break;
        case '11':
            $mes1 = "11";
            break;
        case '12':
            $mes1 = "12";
            break;
    }
    ?>
    
    
    <img src="media/comprobantes/<?=$typecom?>.jpg" width="100%" height="<?=$alto?>">
    <p id="numero"><?=$mes1?>-<?=$comp?>/<?=$comprobante->numero?><?/*if($pag>"1"){*/?><br>Pag:<?=$pag?><?/*}*/?></p>
    <p id="cliente" style="<?=$typecom=="ingreso"?'display:none':''?>"><?=$comprobante->cliente?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$comprobante->cheque_nro?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? foreach (getLBcuentas() as $banco){
                                if($comprobante->id_banco == $banco->id){
        $cadena=$banco->banco;
                                       
                                    $resultado = str_replace("Banco", "", $cadena);
        ?>                                  
                                    <?=$resultado?>
                            <? }
                            }?></p>
    <table >
        <thead>
            <th class="detalle" ></th>
            <th class="debe"></th>
            <th class="haber"></th>
        </thead>
        <tbody>
            <? 
            
            foreach(getComprobanteDetallePrint() as $detalle){
                
            
            ?>
                <tr>
                    <td class="det1"><?=$detalle->codigo?>&nbsp;&nbsp;<?=$detalle->cuenta?>
                    <?if($tipo=="Ingreso"){?>
    
<?}elseif($tipo=="Egreso"){?>
  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$comprobante->detalle?>&nbsp;Bs&nbsp;<?=$comprobante->tipo_cambio?> 
<?}else{?>
  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$comprobante->detalle?>&nbsp;Bs&nbsp;<?=$comprobante->tipo_cambio?> 
<?}?><?$cadenas = $detalle->detalle;
                $numcarac= strlen ($cadenas);
                        if ($numcarac<54){?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$detalle->detalle?>
                    <?}?></td>
                    
                    <td class="montos1"><?=number_format($detalle->debe,2,".",",")?></td>
                    <td class="montos"><?=number_format($detalle->haber,2,".",",")?></td>
                </tr>
            <? }?>
            
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td style="width:115px"><?=number_format($total_debe,2,".",",")?></td>
                <td><?=number_format($total_haber,2,".",",")?></td>
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
    <p class="det"><?=$comprobante->glosa?></p>
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