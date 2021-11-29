<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<style>
@media print{ 
    .cheque{
        border-bottom: 1px dashed black;
        height: 360px;
        z-index: 0;        
    }
    .imprime{
        display: none;
    }
}
    .contenedor{
        width: 100%;
        overflow-x: auto;
    }
    .factura{
        border: 2px dashed black;
        height: 360px;
        width: 715px;
        position: relative;
        z-index: 2;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }
    .factura>div{
        position: absolute;
        border: 1px dashed black;
        padding: 10px;
        z-index: 2;
    }
    .imagen{        
        position: absolute;
        z-index: 1;
    }
    #imgcheque{
        width: 100%;
        opacity: .5;
    }
    #diay, #mesy, #anioy{
        cursor: not-allowed;
    }
</style>
<script>
jQuery(document).on('ready', function(){
    //Factura
    jQuery('#facturax').on('keyup change', function(){
        jQuery('.nfactura').css('left',jQuery(this).val()+'px');
    })
    jQuery('#facturay').on('keyup change', function(){
        jQuery('.nfactura').css('top',jQuery(this).val()+'px');
        jQuery('#montoy').val(jQuery(this).val());
    })
    //NIT
    /*jQuery('#nitx').on('keyup change', function(){
        jQuery('.nit').css('left',jQuery(this).val()+'px');
    })
    jQuery('#nity').on('keyup change', function(){
        jQuery('.nit').css('top',jQuery(this).val()+'px');
    })*/
    //AUTORIZACION
    jQuery('#autox').on('keyup change', function(){
        jQuery('.autorizacion').css('left',jQuery(this).val()+'px');
    })
    jQuery('#autoy').on('keyup change', function(){
        jQuery('.autorizacion').css('top',jQuery(this).val()+'px');
    })
    //FECHA LITERAL Y NIT CLIENTE
    jQuery('#fechality').on('keyup change', function(){
        jQuery('.fechaliteral, .nitcliente').css('top',jQuery(this).val()+'px');        
        jQuery('#fechality, #nitcliy').val(jQuery(this).val())
    })
    //FECHA LITERAL IZQUIERDO
    jQuery('#fechalitx').on('keyup change', function(){
        jQuery('.fechaliteral').css('left',jQuery(this).val()+'px');
    })
    //NIT CLIENTE IZQUIERDO
    jQuery('#nitclix').on('keyup change', function(){
        jQuery('.nitcliente').css('left',jQuery(this).val()+'px');
    })
    //CLIENTE
    jQuery('#clientey').on('keyup change', function(){
        jQuery('.cliente').css('top',jQuery(this).val()+'px');
    })
    jQuery('#clientex').on('keyup change', function(){
        jQuery('.cliente').css('left',jQuery(this).val()+'px');
    })
    //DIA MES AÑO
    jQuery('#diay').on('keyup change', function(){        
        jQuery('.dia, .mes, .anio').css('top',jQuery(this).val()+'px');
        jQuery('#diay, #mesy, #anioy').val(jQuery(this).val())
    }) 
    //DIA
    jQuery('#diax').on('keyup change', function(){
        jQuery('.dia').css('left',jQuery(this).val()+'px');
    })
    //MES
    jQuery('#mesx').on('keyup change', function(){
        jQuery('.mes').css('left',jQuery(this).val()+'px');
    })
    //AÑO
    jQuery('#aniox').on('keyup change', function(){
        jQuery('.anio').css('left',jQuery(this).val()+'px');
    })
    //DOLARES
    jQuery('#dolaresx').on('keyup change', function(){
        jQuery('.sus').css('left',jQuery(this).val()+'px');
    })
    jQuery('#dolaresy').on('keyup change', function(){
        jQuery('.sus').css('top',jQuery(this).val()+'px');
    })
    //BOLIVIANOS
    jQuery('#bsy').on('keyup change', function(){
        jQuery('.bs').css('top',jQuery(this).val()+'px');
    })
    jQuery('#bsx').on('keyup change', function(){
        jQuery('.bs').css('left',jQuery(this).val()+'px');
    })
    //EFECTIVO
    jQuery('#efectivox').on('keyup change', function(){
        jQuery('.efectivo').css('left',jQuery(this).val()+'px');
    })
    jQuery('#efectivoy').on('keyup change', function(){
        jQuery('.efectivo').css('top',jQuery(this).val()+'px');
    })
    //CHEQUE
    jQuery('#chequey').on('keyup change', function(){
        jQuery('.cheque').css('top',jQuery(this).val()+'px');
    })
    jQuery('#chequex').on('keyup change', function(){
        jQuery('.cheque').css('left',jQuery(this).val()+'px');
    })
    //MONTO LITERAL
    jQuery('#montolity').on('keyup change', function(){
        jQuery('.montolit').css('top',jQuery(this).val()+'px');
    })
    jQuery('#montolitx').on('keyup change', function(){
        jQuery('.montolit').css('left',jQuery(this).val()+'px');
    })
    //CODIGO DE CONTROL
    jQuery('#codigocy').on('keyup change', function(){
        jQuery('.codigoc').css('top',jQuery(this).val()+'px');
    })
    jQuery('#codigocx').on('keyup change', function(){
        jQuery('.codigoc').css('left',jQuery(this).val()+'px');
    })
    //NUMERO DE CHEQUE
    jQuery('#nchequey').on('keyup change', function(){        
        jQuery('.ncheque').css('top',jQuery(this).val()+'px');        
    })
    jQuery('#nchequex').on('keyup change', function(){
        jQuery('.ncheque').css('left',jQuery(this).val()+'px');
    }) 
    //BANCO
    jQuery('#bancox').on('keyup change', function(){
        jQuery('.banco').css('top',jQuery(this).val()+'px');
    })
    jQuery('#bancoy').on('keyup change', function(){
        jQuery('.banco').css('left',jQuery(this).val()+'px');
    })
    //FECHA DE EMISION
    jQuery('#fechaemisionx').on('keyup change', function(){
        jQuery('.fecha_e').css('top',jQuery(this).val()+'px');
    })
    jQuery('#fechaemisiony').on('keyup change', function(){
        jQuery('.fecha_e').css('left',jQuery(this).val()+'px');
    })
    //CANTIDAD DESCRIPCION SUBTOTAL
    jQuery('#cantidady').on('keyup change', function(){        
        jQuery('.cantidad, .descripcion, .subtotal').css('top',jQuery(this).val()+'px');
        jQuery('#cantidady, #descripciony, #subtotaly').val(jQuery(this).val())
    }) 
    //CANTIDAD
    jQuery('#cantidadx').on('keyup change', function(){
        jQuery('.cantidad').css('left',jQuery(this).val()+'px');
    })
    //DESCRIPCION
    jQuery('#descripcionx').on('keyup change', function(){
        jQuery('.descripcion').css('left',jQuery(this).val()+'px');
    })
    //SUBTOTAL
    jQuery('#subtotalx').on('keyup change', function(){
        jQuery('.subtotal').css('left',jQuery(this).val()+'px');
    })
    //TOTAL
    jQuery('#totalx').on('keyup change', function(){
        jQuery('.total').css('left',jQuery(this).val()+'px');
    })
    jQuery('#totaly').on('keyup change', function(){
        jQuery('.total').css('top',jQuery(this).val()+'px');
    })

    //precargando la imagen
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                jQuery('#imgcheque').attr('src', e.target.result);                
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    //enviamos el fomrulario de la imagen
    jQuery("#imagen").on('change',function(){
        jQuery('#formimg').trigger('submit');
        readURL(this);
        
    });
    jQuery("input[type=number]").focus(function(){	  
        this.select();
    })
    /*//-----------NIT-----------
    jQuery('.nit').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.nnit').show(500);
    })*/
    //-----------FACTURA-----------
    jQuery('.nfactura').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.facturanum').show(500);
    })
    //-----------AUTORIZACION-----------
    jQuery('.autorizacion').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.nauto').show(500);
    })
    //-----------FECHA LITERAL-----------
    jQuery('.fechaliteral').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.fechalit').show(500);
    })
    //---------NIT CLIENTE---------
    jQuery('.nitcliente').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.nitcli').show(500);
    })
    //-----------CLIENTE-----------
    jQuery('.cliente').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.client').show(500);
    })
    //-----------DIA-----------
    jQuery('.dia').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.dias').show(500);
    })
    //-----------MES-----------
    jQuery('.mes').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.meslit').show(500);
    })
    //-----------ANIO-----------
    jQuery('.anio').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.aniosf').show(500);
    })
    //-----------DOLARES-----------
    jQuery('.sus').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.dolares').show(500);
    })
    //-----------BOLIVIANOS-----------
    jQuery('.bs').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.bolivianos').show(500);
    })
    //-----------MONTO LITERAL-----------
    jQuery('.montolit').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.montolite').show(500);
    })
    //-----------FECTIVO-----------
    jQuery('.efectivo').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.efec').show(500);
    })
    //-----------CHEQUE-----------
    jQuery('.cheque').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.cheq').show(500);
    })
    //-----------CODIGO DE CONTROL-----------
    jQuery('.codigoc').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.codigo').show(500);
    })
    //-----------NUMERO CHEQUE-----------
    jQuery('.ncheque').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.chequeb').show(500);
    })
    //-----------BANCO-----------
    jQuery('.banco').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.bank').show(500);
    })
    //-----------FECHA DE EMISION-----------
    jQuery('.fecha_e').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.fechae').show(500);
    })
    //-----------CANTIDAD-----------
    jQuery('.cantidad').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.cant').show(500);
    })
    //-----------DECRIPCION-----------
    jQuery('.descripcion').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.desc').show(500);
    })//-----------SUBTOTAL-----------
    jQuery('.subtotal').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.sub').show(500);
    })//-----------TOTAL-----------
    jQuery('.total').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.tot').show(500);
    })
    //cerrar campos
    jQuery('.close_c').on('click',function(){
        var clase = jQuery(this).parent().attr('class');
        var clase_campos = clase.split(' ');
        jQuery('.'+clase_campos[1]).hide(500);
    })
    /*------ENVIANDO DATOS------*/
    jQuery('.btn-success').on('click',function(){
        var posx = jQuery(this).closest('.form-group').children('div').find('input').val();
        var posy = jQuery(this).closest('.form-group').children('div').next().find('input').val();
        var id_campo = jQuery(this).siblings().val();
        alert(posx+'  '+posy+' '+id_campo);
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=facturacion&layout=actualizaposicion&tmpl=blank"',
            type: 'POST',
            data: {id:id_campo, pos_x:posx,pos_y:posy}
        })
        /*.done(function(data){
        })*/
    })
})
</script>
<?
//ruta de la imagen para calcular el alto y ancho del cheque
$id = JRequest::getVar('id','','get');
$reg = getFacturaCampos(4);
/*echo '<pre>';
print_r($reg);
echo '</pre>';*/
//$imgsrc = "media/com_erp/cheques/thumb_".$reg->imagen;
$imgsrc = "media/com_erp/factura.jpg";
imagecreatefromjpeg($imgsrc);
$imagen = getimagesize($imgsrc);    //Sacamos la información     //Ancho
$alto = $imagen[1];
foreach ($reg as $value){
    //echo $value->pos_x."<br>";
    //echo $value->pos_y."<br>";
    echo $value->campo."<br>";
}
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-money"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Posiciones Recibo</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
        <div class="contenedor">
            <div class="imagen">
                <?// if($reg->imagen!=''){?>
                    <img src="media/com_erp/factura.jpg" alt="" id="imgcheque">
                <?// }?>
            </div>
            <?
            function clase($clasenombre){
                switch ($clasenombre){
                    case 'n_factura':
                        $clase_campo = 'nfactura_Nº DE FACTURA';
                        break;
                    case 'n_autorizacion':
                        $clase_campo = 'autorizacion_Nº AUTORIZACIÓN';
                        break;
                    case 'fecha_literal':
                        $clase_campo = 'fechaliteral_FECHA LITERAL';
                        break;
                    case 'nit_cliente':
                        $clase_campo = 'dia_DIA';
                        break;
                    case 'cliente':
                        $clase_campo = 'mes_MES';
                        break;
                    case 'dia':
                        $clase_campo = 'anio_AÑO';
                        break;
                    case 'mes':
                        $clase_campo = 'nitcliente_NIT CLIENTE';
                        break;
                    case 'anio':
                        $clase_campo = 'cliente_CLIENTE RAZON SOCIAL';
                        break;
                    case 'cheque':
                        $clase_campo = 'montolit_MONTO LITERAL';
                        break;
                    case 'efectivo':
                        $clase_campo = 'codigoc_CÓDIGO DE CONTROL';
                        break;
                    case 'bolivianos':
                        $clase_campo = 'efectivo_EF';
                        break;
                    case 'dolares':
                        $clase_campo = 'cheque_CH';
                        break;
                    case 'n_cheque':
                        $clase_campo = 'bs_Bs';
                        break;
                    case 'banco':
                        $clase_campo = 'sus_$us';
                        break;
                    case 'monto_literal':
                        $clase_campo = 'ncheque_Nº CHEQUE';
                        break;
                    case 'c_Control':
                        $clase_campo = 'banco_BANCO';
                        break;
                    case 'fecha_emision':
                        $clase_campo = 'fecha_e_FECHA DE EMISION';
                        break;
                    case 'cantidad':
                        $clase_campo = 'cantidad_CANT.';
                        break;
                    case 'descripcion':
                        $clase_campo = 'descripcion_DESCRIPCION';
                        break;
                    case 'subtotal':
                        $clase_campo = 'subtotal_SUBTOTAL';
                        break;
                    case 'total':
                        $clase_campo = 'total_TOTAL';
                        break;
                }
                return $clase_campo;
            }
            ?>
            <div class="factura" style="height:<?=$alto?>px;display:inline-block">                
                <!--<div class="nit" style="top:<?=$reg->posy_ciudad==''?140:'';?>px;left:<?=$reg->posx_dd==''?460:'';?>px;"><b>Nº DE NIT</b></div>-->
                <div class="nfactura" style="top:<?=$reg->posy_ciudad!=''?:45;?>px;left:<?=$reg->posx_dd==''?555:'';?>px;"><b>Nº DE FACTURA</b></div>
                <div class="autorizacion" style="top:<?=$reg->posy_ciudad==''?70:'';?>px;left:<?=$reg->posx_dd==''?555:'';?>px;"><b>Nº AUTORIZACIÓN</b></div>
                <div class="fechaliteral" style="top:<?=$reg->posy_ciudad==''?145:'';?>px;left:<?=$reg->posx_dd==''?235:'';?>px;"><b>FECHA LITERAL</b></div>
                <div class="dia" style="top:<?=$reg->posy_ciudad==''?205:'';?>px;left:<?=$reg->posx_mm==''?55:'';?>px;"><b>DIA</b></div>
                <div class="mes" style="top:<?=$reg->posy_ciudad==''?205:'';?>px;left:<?=$reg->posx_mm==''?90:'';?>px;"><b>MES</b></div>
                <div class="anio" style="top:<?=$reg->posy_ciudad==''?205:'';?>px;left:<?=$reg->posx_aa==''?130:'';?>px;"><b>AÑO</b></div>
                <div class="nitcliente" style="top:<?=$reg->posy_montolit==''?145:'';?>px;left:<?=$reg->posx_montolit==''?565:'';?>px"><b>NIT CLIENTE</b></div>
                <div class="cliente" style="top:<?=$reg->posy_montolit==''?175:'';?>px;left:<?=$reg->posx_montolit==''?265:'';?>px"><b>CLIENTE RAZON SOCIAL</b></div>
                <div class="montolit" style="top:<?=$reg->posy_montolit==''?350:'';?>px;left:<?=$reg->posx_montolit==''?220:'';?>px"><b>MONTO LITERAL</b></div>
                <div class="codigoc" style="top:<?=$reg->posy_montolit==''?375:'';?>px;left:<?=$reg->posx_montolit==''?300:'';?>px"><b>CÓDIGO DE CONTROL</b></div>
                <div class="efectivo" style="top:<?=$reg->posy_ciudad==''?230:'';?>px;left:<?=$reg->posx_mm==''?50:'';?>px;"><b>EF</b></div>
                <div class="cheque" style="top:<?=$reg->posy_ciudad==''?250:'';?>px;left:<?=$reg->posx_mm==''?50:'';?>px;"><b>CH</b></div>
                <div class="bs" style="top:<?=$reg->posy_ciudad==''?230:'';?>px;left:<?=$reg->posx_dd==''?148:'';?>px;"><b>Bs</b></div>
                <div class="sus" style="top:<?=$reg->posy_ciudad==''?258:'';?>px;left:<?=$reg->posx_dd==''?148:'';?>px;"><b>$us</b></div>
                <div class="ncheque" style="top:<?=$reg->posy_ciudad==''?285:'';?>px;left:<?=$reg->posx_dd==''?65:'';?>px;"><b>Nº CHEQUE</b></div>
                <div class="banco" style="top:<?=$reg->posy_nombre==''?330:'';?>px;left:<?=$reg->posx_nombre==''?60:'';?>px"><b>BANCO</b></div>
                <div class="fecha_e" style="top:<?=$reg->posy_nombre==''?396:'';?>px;left:<?=$reg->posx_nombre==''?325:'';?>px"><b>FECHA DE EMISION</b></div>
                <div class="cantidad" style="top:<?=$reg->posy_nombre==''?222:'';?>px;left:<?=$reg->posx_nombre==''?193:'';?>px"><b>CANT.</b></div>
                <div class="descripcion" style="top:<?=$reg->posy_nombre==''?222:'';?>px;left:<?=$reg->posx_nombre==''?258:'';?>px"><b>DESCRIPCION</b></div>
                <div class="subtotal" style="top:<?=$reg->posy_nombre==''?222:'';?>px;left:<?=$reg->posx_nombre==''?585:'';?>px"><b>SUBTOTAL</b></div>
                <div class="total" style="top:<?=$reg->posy_nombre==''?325:'';?>px;left:<?=$reg->posx_nombre==''?590:'';?>px"><b>TOTAL</b></div>
            </div>
            <div style="width:300px; height:480px;display:inline-block">
                <!--NIT-->
                <!--<div class="form-group nnit" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_nit" id="nitx" class="form-control" value="<?=$reg->posx_bs?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_nit" id="nity" class="form-control" value="<?=143?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="b" id="b" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>-->
                <!--FACTURA-->
                <div class="form-group facturanum" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_factura" id="facturax" class="form-control" value="<?=555?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_factura" id="facturay" class="form-control" value="<?=45?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="fnum" id="fnum" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>                
                <!--AUTORIZACION-->
                <div class="form-group nauto" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_auto" id="autox" class="form-control" value="<?=555?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_auto" id="autoy" class="form-control" value="<?=70?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="auto" id="auto" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--FECHA LITERAL-->
                <div class="form-group fechalit" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_fechalit" id="fechalitx" class="form-control" value="<?=135?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_fechalit" id="fechality" class="form-control" value="<?=235?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="feclit" id="feclit" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <!--NIT CLIENTE-->
                <div class="form-group nitcli" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_nitcli" id="nitclix" class="form-control" value="<?=175?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_nitcli" id="nitcliy" class="form-control" value="<?=260?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="nitcli" id="nitcli" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--CLIENTE RAZON SOCIAL-->
                <div class="form-group client" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_cliente" id="clientex" class="form-control" value="<?=175?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_cliente" id="clientey" class="form-control" value="<?=265?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="razon" id="razon" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--DIA CANCECLACION-->
                <div class="form-group dias" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_dd" id="diax" class="form-control" value="<?=55?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_dd" id="diay" class="form-control" value="<?=205?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="dd" id="dd" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--MES CANCECLACION-->   
                <div class="form-group meslit" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_mm" id="mesx" class="form-control" value="<?=90?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_mm" id="mesy" class="form-control" value="<?=205?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="mm" id="mm" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--AÑO CANCECLACION-->
                <div class="form-group aniosf" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_aa" id="aniox" class="form-control" value="<?=130?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_aa" id="anioy" class="form-control" value="<?=205?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="yy" id="yy" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--BOLIVIANOS-->
                <div class="form-group bolivianos" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_bs" id="bsx" class="form-control" value="<?=148?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_bs" id="bsy" class="form-control" value="<?=230?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="b" id="b" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--DOLARES-->
                <div class="form-group dolares" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_dolares" id="dolaresx" class="form-control" value="<?=258?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_dolares" id="dolaresy" class="form-control" value="<?=143?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="d" id="d" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--EFECTIVO-->
                <div class="form-group efec" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_efectivo" id="efectivox" class="form-control" value="<?=50?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_efectivo" id="efectivoy" class="form-control" value="<?=250?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="b" id="b" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--CHEQUE-->
                <div class="form-group cheq" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_cheque" id="chequex" class="form-control" value="<?=50?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_cheque" id="chequey" class="form-control" value="<?=230?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="chequ" id="chequ" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--MONTO LITERAL-->   
                <div class="form-group montolite" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_montolit" id="montolitx" class="form-control" value="<?=220?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_montolit" id="montolity" class="form-control" value="<?=350?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="ml" id="ml" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--NUMERO DE CHEQUE-->   
                <div class="form-group chequeb" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_ncheque" id="nchequex" class="form-control" value="<?=65?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_ncheque" id="nchequey" class="form-control" value="<?=285?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="nch" id="nch" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--CODIGO DE CONTROL-->   
                <div class="form-group codigo" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_codigoc" id="codigocx" class="form-control" value="<?=375?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_codigoc" id="codigocy" class="form-control" value="<?=300?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="cc" id="cc" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--BANCO-->                
                <div class="form-group bank" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_banco" id="bancox" class="form-control" value="<?=60?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_banco" id="bancoy" class="form-control"value="<?=330?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="banca" id="banca" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--FECHA DE EMISION-->                
                <div class="form-group fechae" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_fechaemision" id="fechaemisionx" class="form-control" value="<?=396?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_fechaemision" id="fechaemisiony" class="form-control"value="<?=325?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="fem" id="fem" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--CANTIDAD-->                
                <div class="form-group cant" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_cantidad" id="cantidadx" class="form-control" value="<?=396?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_cantidad" id="cantidady" class="form-control"value="<?=325?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="ctd" id="ctd" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--DESCRIPCION-->                
                <div class="form-group desc" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_descripcion" id="descripcionx" class="form-control" value="<?=396?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_descripcion" id="descripciony" class="form-control"value="<?=325?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="desc" id="desc" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--SUBTOTAL-->                
                <div class="form-group sub" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_subtotal" id="subtotalx" class="form-control" value="<?=396?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_subtotal" id="subtotaly" class="form-control"value="<?=325?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="subt" id="subt" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <!--TOTAL-->                
                <div class="form-group tot" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_total" id="totalx" class="form-control" value="<?=396?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_total" id="totaly" class="form-control"value="<?=325?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="tota" id="tota" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="margin-top:25px; display:none;">
            <form action="index.php?option=com_erp&view=librobancos&layout=altocheque&tmpl=blank" name="form2" id="formimg" class="form-horizontal" enctype="multipart/form-data" method="POST">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2"><b>Actualizar la imagen del Recibo</b></label>
                   <div class="col-xs-12 col-sm-10">
                       <input type="hidden" name="id" value="<?=$id?>">
                       <input type="file" name="imagen" id="imagen" class="form-control">
                   </div>
               </div>
            </form>
        </div>
        <? }else{
            editLBcuentacheque();
        ?>
            <h3 class="alert alert-success">Se ha editado correcamente el Recibo</h3>
            <!--<a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar al Mantenimiento de Bancos</a>-->
        <? }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>