<? $session = JFactory::getSession();?>
<style>
@media print{
    .imprime{
        display: none;
    }
    .salto{
        display:block; 
        page-break-before:always;
    }
    #imgcheque{
        display: none;
    }
}
@page{
    margin-top: 0;
    padding-top: 0;
    margin-bottom: 0;
    padding-bottom: 0;
}      
    section{
        padding: 0 !important;
        margin-right: 0 !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .contenedor{
        width: 100%;
        display: block;
        margin-top: -20px;
    }
    .cheque{
        height: 360px;
        width: 800px;
        position: relative;
        z-index: 2;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }
    .cheque>div{
        position: absolute;        
        padding: 10px;
        z-index: 2;
    }
    .imagen{        
        position: absolute;
        z-index: 1;
    }
</style>
<script>
if(window.close()){
    alert("Se ha Cerrado la ventana De impresión");    
}
jQuery(document).on('ready',function(){
    jQuery('.imprime').on('click', function(){
        location.href = 'index.php?option=com_erp&view=librobancos&layout=confirmaprintch&tmpl=component';
    })
})
</script>
<?
$id = Jrequest::getVar('id','','get');
$arr = $session->get('arraycheques');
/*----DATOS PARA EL CHEQUE------*/
//ruta de la imagen para calcular el alto y ancho del cheque
?>
<? 
$cont = 0;
foreach($arr as $idcheque){
    $cheque = getLBcheque($idcheque);
    $reg = getLBcuenta($id);
    if($reg->cantidad==$cont){
        $salto = "salto";
        $cont = 0;
    }else{
        $salto = "";
    }
    $arrayfecha = explode("-",$reg->fecha);
    $mes = $reg->mesliteral==1?mes($arrayfecha[1]):$arrayfecha[1];
    $anio = $reg->digitos==2?substr($arrayfecha[0],2):$arrayfecha[0];
    $imgsrc = "media/com_erp/cheques/thumb_".$reg->imagen;
    imagecreatefromjpeg($imgsrc);
    $imagen = getimagesize($imgsrc);    //Sacamos la información     //Ancho
    $alto = $imagen[1];
?>
         <div class="contenedor <?=$salto?>">
            <div class="imagen">
                <? if($reg->imagen!=''){?>
                    <img src="media/com_erp/cheques/thumb_<?=$reg->imagen?>" alt="" id="imgcheque">
                <? }?>
            </div>
            <div class="cheque" style="height:<?=$alto?>px;">
                <div class="dinero" style="top:<?=$reg->posy_montonum?>px;left:<?=$reg->posx_montonum?>px"><b><?=$cheque->monto?></b></div>
                
                <div class="ciudad" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_ciudad?>px;"><b><?=$cheque->ciudad?></b></div>
                <div class="dia" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_dd?>px;"><b><?=$arrayfecha[2]?></b></div>
                <div class="mes" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_mm?>px;"><b><?=$mes?></b></div>
                <div class="anio" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_aa?>px;"><b><?=$anio?></b></div>
                
                <div class="nombre" style="top:<?=$reg->posy_nombre?>px;left:<?=$reg->posx_nombre?>px"><b><?=strtoupper($cheque->nombre)?></b></div>
                <div class="monto" style="top:<?=$reg->posy_montolit?>px;left:<?=$reg->posx_montolit?>px"><b><?=strtoupper(num_letra($cheque->monto))?></b></div>
                <div class="moneda" style="top:<?=$reg->posy_moneda?>px;left:<?=$reg->posx_moneda?>px; display:<?=$reg->imp_moneda==1?'block':'none'?>"><b><?=$banco->moneda=='N'?'BS':'$US'?></b></div>
            </div>
        </div>
<? $cont++;
}?>
<div class="col-xs-12 text-center">
    <button class="btn btn-success imprime" onClick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
</div>