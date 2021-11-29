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
    .cheque{
        border: 2px dashed black;
        height: 360px;
        width: 715px;
        position: relative;
        z-index: 2;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }
    .cheque>div{
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
    //primera FILA
    jQuery('#dolaresx').on('keyup change', function(){
        jQuery('.sus').css('left',jQuery(this).val()+'px');
    })
    jQuery('#dolaresy').on('keyup change', function(){
        jQuery('.sus, .bs, .monto').css('top',jQuery(this).val()+'px');
        jQuery('#bsy, #montoy').val(jQuery(this).val());
    })
    jQuery('#bsx').on('keyup change', function(){
        jQuery('.bs').css('left',jQuery(this).val()+'px');
    })
    jQuery('#montox').on('keyup change', function(){
        jQuery('.monto').css('left',jQuery(this).val()+'px');
    })
    //Recibido de
    jQuery('#recibidoy').on('keyup change', function(){
        jQuery('.recibido').css('top',jQuery(this).val()+'px');
    })
    jQuery('#recibidox').on('keyup change', function(){
        jQuery('.recibido').css('left',jQuery(this).val()+'px');
    })
    //monto literal
    jQuery('#lity').on('keyup change', function(){
        jQuery('.montolit').css('top',jQuery(this).val()+'px');
    })
    jQuery('#litx').on('keyup change', function(){
        jQuery('.montolit').css('left',jQuery(this).val()+'px');
    })
    //CONCEPTO
    jQuery('#concepty').on('keyup change', function(){
        jQuery('.concepto').css('top',jQuery(this).val()+'px');
    })
    jQuery('#conceptx').on('keyup change', function(){
        jQuery('.concepto').css('left',jQuery(this).val()+'px');
    })
    //N CHEQUE
    jQuery('#nchequey').on('keyup change', function(){        
        jQuery('.ncheque, .dia, .mes, .anio').css('top',jQuery(this).val()+'px');
        jQuery('#diay, #mesy, #anioy').val(jQuery(this).val())
    })    
    jQuery('#nchequex').on('keyup change', function(){
        jQuery('.ncheque').css('left',jQuery(this).val()+'px');
    }) 
    //dia
    jQuery('#diax').on('keyup change', function(){
        jQuery('.dia').css('left',jQuery(this).val()+'px');
    })
    //mes
    jQuery('#mesx').on('keyup change', function(){
        jQuery('.mes').css('left',jQuery(this).val()+'px');
    })
    //año
    jQuery('#aniox').on('keyup change', function(){
        jQuery('.anio').css('left',jQuery(this).val()+'px');
    })
    //BANCO
    jQuery('#bancox').on('keyup change', function(){
        jQuery('.banco').css('top',jQuery(this).val()+'px');
    })
    jQuery('#bancoy').on('keyup change', function(){
        jQuery('.banco').css('left',jQuery(this).val()+'px');
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
    //-----------dolares-----------
    jQuery('.sus').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.dolares').show(500);
    })
    //-----------dolares-----------
    jQuery('.bs').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.bolivianos').show(500);
    })
    //-----------dolares-----------
    jQuery('.monto').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.montonum').show(500);
    })
    //-----------dolares-----------
    jQuery('.recibido').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.recibido').show(500);
    })
    //-----------dolares-----------
    jQuery('.montolit').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.montolite').show(500);
    })
    //-----------dolares-----------
    jQuery('.concepto').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.porconcpeto').show(500);
    })
    //-----------dolares-----------
    jQuery('.ncheque').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.chequeb').show(500);
    })
    //-----------dolares-----------
    jQuery('.dia').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.dias').show(500);
    })
    //-----------dolares-----------
    jQuery('.mes').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.meslit').show(500);
    })
    //-----------dolares-----------
    jQuery('.anio').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.aniosf').show(500);
    })
    //-----------dolares-----------
    jQuery('.banco').on('click',function(){
        jQuery('.form-group').hide(500);
        jQuery('.bank').show(500);
    })
    //cerrar campos
    jQuery('.close_c').on('click',function(){
        var clase = jQuery(this).parent().attr('class');
        var clase_campos = clase.split(' ');
        jQuery('.'+clase_campos[1]).hide(500);
    })
})
</script>
<?
//ruta de la imagen para calcular el alto y ancho del cheque
$id = JRequest::getVar('id','','get');
$reg = getLBcuenta($id);
//$imgsrc = "media/com_erp/cheques/thumb_".$reg->imagen;
$imgsrc = "media/com_erp/recibo.jpg";
imagecreatefromjpeg($imgsrc);
$imagen = getimagesize($imgsrc);    //Sacamos la información     //Ancho
$alto = $imagen[1];
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
                    <img src="media/com_erp/recibo.jpg" alt="" id="imgcheque">
                <?// }?>
            </div>
            <div class="cheque" style="height:<?=$alto?>px;display:inline-block">                
                <div class="sus" style="top:<?=$reg->posy_ciudad==''?140:'';?>px;left:<?=$reg->posx_dd==''?350:'';?>px;"><b>X</b></div>
                <div class="bs" style="top:<?=$reg->posy_ciudad==''?140:'';?>px;left:<?=$reg->posx_dd==''?460:'';?>px;"><b>X</b></div>
                <div class="monto" style="top:<?=$reg->posy_ciudad==''?140:'';?>px;left:<?=$reg->posx_dd==''?575:'';?>px;"><b>MONTO</b></div>
                <div class="recibido" style="top:<?=$reg->posy_ciudad==''?180:'';?>px;left:<?=$reg->posx_dd==''?150:'';?>px;"><b>RECIBIDO DE</b></div>
                <div class="montolit" style="top:<?=$reg->posy_montolit==''?210:'';?>px;left:<?=$reg->posx_montolit==''?150:'';?>px"><b>MONTO LITERAL</b></div>
                <div class="concepto" style="top:<?=$reg->posy_montolit==''?280:'';?>px;left:<?=$reg->posx_montolit==''?350:'';?>px"><b>POR CONCEPTO DE</b></div>
                <div class="ncheque" style="top:<?=$reg->posy_ciudad==''?350:'';?>px;left:<?=$reg->posx_mm==''?100:'';?>px;"><b>CHEQUE</b></div>
                <div class="dia" style="top:<?=$reg->posy_ciudad==''?350:'';?>px;left:<?=$reg->posx_mm==''?390:'';?>px;"><b>DIA</b></div>
                <div class="mes" style="top:<?=$reg->posy_ciudad==''?350:'';?>px;left:<?=$reg->posx_mm==''?480:'';?>px;"><b>MES</b></div>
                <div class="anio" style="top:<?=$reg->posy_ciudad==''?350:'';?>px;left:<?=$reg->posx_aa==''?640:'';?>px;"><b>AÑO</b></div>
                <div class="banco" style="top:<?=$reg->posy_nombre==''?380:'';?>px;left:<?=$reg->posx_nombre==''?90:'';?>px"><b>BANCO</b></div>
            </div>
            <div style="width:300px; height:480px;display:inline-block">
                <div class="form-group dolares" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_dolares" id="dolaresx" class="form-control" value="<?=$reg->posx_dolares?>">
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
                
                <div class="form-group bolivianos" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_bs" id="bsx" class="form-control" value="<?=$reg->posx_bs?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_bs" id="bsy" class="form-control" value="<?=143?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="b" id="b" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <div class="form-group montonum" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_monto" id="montox" class="form-control" value="<?=$reg->posx_monto?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_monto" id="montoy" class="form-control" value="<?=143?>" readonly>
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="mn" id="mn" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <div class="form-group recibido" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_recibido" id="recibidox" class="form-control" value="<?=$reg->posx_recibido?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_recibido" id="recibidoy" class="form-control" value="<?=$reg->posy_recibido?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="r" id="r" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <div class="form-group montolite" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_ncheque" id="nchequex" class="form-control" value="<?=$reg->posx_ncheque?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_ncheque" id="nchequey" class="form-control" value="<?=$reg->posy_ncheque?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="ml" id="ml" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                   
                <div class="form-group porconcpeto" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_concep" id="conceptx" class="form-control" value="<?=$reg->posx_concep?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_concep" id="concepty" class="form-control" value="<?=$reg->posy_concep?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="c" id="c" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                   
                <div class="form-group chequeb" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_ncheque" id="nchequex" class="form-control" value="<?=$reg->posx_ncheque?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_ncheque" id="nchequey" class="form-control" value="<?=$reg->posy_ncheque?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="ch" id="ch" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                   
                <div class="form-group dias" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_dd" id="diax" class="form-control" value="<?=$reg->posx_dd?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_dd" id="diay" class="form-control" value="<?=$reg->posy_ncheque?>" readonly style="display:none">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="dd" id="dd" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                   
                <div class="form-group meslit" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_mm" id="mesx" class="form-control" value="<?=$reg->posx_mm?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_mm" id="mesy" class="form-control" value="<?=$reg->posy_ncheque?>" readonly style="display:none">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="mm" id="mm" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <div class="form-group aniosf" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_aa" id="aniox" class="form-control" value="<?=$reg->posx_aa?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_aa" id="anioy" class="form-control" value="<?=$reg->posy_ncheque?>" readonly style="display:none">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="yy" id="yy" value="">
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                
                <div class="form-group bank" style="display:none;position:relative;">
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Izquierdo</label>                            
                        <input type="number" name="posx_banco" id="bancox" class="form-control" value="<?=$reg->posx_banco?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Superior</label>
                        <input type="number" name="posy_banco" id="bancoy" class="form-control"value="<?=$reg->posy_banco?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="bb" id="bb" value="">
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