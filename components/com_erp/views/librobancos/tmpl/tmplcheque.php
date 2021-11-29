<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador Libro de Bancos')){?>
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
        width: 800px;
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
    //monto Númeral
    jQuery('#montox').on('keyup change', function(){
        jQuery('.dinero').css('left',jQuery(this).val()+'px');
    })
    jQuery('#montoy').on('keyup change', function(){
        jQuery('.dinero').css('top',jQuery(this).val()+'px');
    })
    //Monto Literal
    jQuery('#montolx').on('keyup change', function(){
        jQuery('.monto').css('left',jQuery(this).val()+'px');
    })
    jQuery('#montoly').on('keyup change', function(){
        jQuery('.monto').css('top',jQuery(this).val()+'px');
    })
    //Nombre
    jQuery('#nombrex').on('keyup change', function(){
        jQuery('.nombre').css('left',jQuery(this).val()+'px');
    })
    jQuery('#nombrey').on('keyup change', function(){
        jQuery('.nombre').css('top',jQuery(this).val()+'px');
    })
    //Moneda
    jQuery('#monedax').on('keyup change', function(){
        jQuery('.moneda').css('left',jQuery(this).val()+'px');
    })
    jQuery('#moneday').on('keyup change', function(){
        jQuery('.moneda').css('top',jQuery(this).val()+'px');
    })
    //ciudad
    jQuery('#ciudad').on('keyup change', function(){
        jQuery('.ciudad').css('left',jQuery(this).val()+'px');
    })
    //ciudad
    jQuery('#ciudady').on('keyup change', function(){
        jQuery('.ciudad, .dia, .mes, .anio').css('top',jQuery(this).val()+'px');        
        jQuery('#diay, #mesy, #anioy').val(jQuery(this).val());
    })    
    //dia
    jQuery('#dia').on('keyup change', function(){
        jQuery('.dia').css('left',jQuery(this).val()+'px');
    })
    //Mes    
    jQuery('#mes').on('keyup change', function(){
        jQuery('.mes').css('left',jQuery(this).val()+'px');
    })
    //Año
    jQuery('#anio').on('keyup change', function(){
        jQuery('.anio').css('left',jQuery(this).val()+'px');
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
})
</script>
<?
//ruta de la imagen para calcular el alto y ancho del cheque
$id = JRequest::getVar('id','','get');
$reg = getLBcuenta($id);
$imgsrc = "media/com_erp/cheques/thumb_".$reg->imagen;
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
        <h3 class="box-title">Posiciones</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
         <form action="" name="form" id="form" class="form-horizontal table-responsive" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="<?=$id?>">
             <table class="table table-striped table-bordered">
                 <thead>
                     <th></th>
                     <th class="text-center">Margen Izquierdo</th>
                     <th class="text-center">Margen Superior</th>
                     <th></th>
                     <th class="text-center">Margen Izquierdo</th>
                     <th class="text-center">Margen Superior</th>
                 </thead>
                 <tbody>
                     <tr>
                         <td><b>Monto</b></td>
                         <td><input type="number" name="posx_montonum" id="montox" class="form-control" value="<?=$reg->posx_montonum?>"></td>
                         <td><input type="number" name="posy_montonum" id="montoy" class="form-control" value="<?=$reg->posy_montonum?>"></td>
                         <td><b>Monto en Literal</b></td>
                         <td><input type="number" name="posx_montolit" id="montolx" class="form-control" value="<?=$reg->posx_montolit?>"></td>
                         <td><input type="number" name="posy_montolit" id="montoly" class="form-control" value="<?=$reg->posy_montolit?>"></td>
                     </tr>
                     <tr>
                         <td><b>Nombre</b></td>
                         <td><input type="number" name="posx_nombre" id="nombrex" class="form-control" value="<?=$reg->posx_nombre?>"></td>
                         <td><input type="number" name="posy_nombre" id="nombrey" class="form-control" value="<?=$reg->posy_nombre?>"></td>
                         <td><b style="display:<?=$reg->imp_moneda==1?'block':'none'?>">Moneda</b></td>
                         <td><input type="number" name="posx_moneda" id="monedax" class="form-control" value="<?=$reg->posx_moneda?>" style="display:<?=$reg->imp_moneda==1?'block':'none'?>"></td>
                         <td><input type="number" name="posy_moneda" id="moneday" class="form-control" value="<?=$reg->posy_moneda?>" style="display:<?=$reg->imp_moneda==1?'block':'none'?>"></td>
                     </tr>                     
                     <tr>
                         <td><b>Ciudad</b></td>
                         <td><input type="number" name="posx_ciudad" id="ciudad" class="form-control" value="<?=$reg->posx_ciudad?>"></td>
                         <td><input type="number" name="posy_ciudad" id="ciudady" class="form-control"value="<?=$reg->posy_ciudad?>"></td>                         
                         <td><b>Día</b></td>
                         <td><input type="number" name="posx_dd" id="dia" class="form-control" value="<?=$reg->posx_dd?>"></td>
                         <td><input type="number" name="posy_dd" id="diay" class="form-control" value="<?=$reg->posy_ciudad?>" readonly></td>
                     </tr>
                     <tr>
                         <td><b>Mes</b></td>
                         <td><input type="number" name="posx_mm" id="mes" class="form-control" value="<?=$reg->posx_mm?>"></td>
                         <td><input type="number" name="posy_mm" id="mesy" class="form-control" value="<?=$reg->posy_ciudad?>" readonly></td>
                         <td><b>Año</b></td>
                         <td><input type="number" name="posx_aa" id="anio" class="form-control" value="<?=$reg->posx_aa?>"></td>
                         <td><input type="number" name="posy_aa" id="anioy" class="form-control" value="<?=$reg->posy_ciudad?>" readonly></td>                         
                     </tr>                     
                     <tr>
                         <td colspan="6"></td>
                     </tr>
                     <tr>
                         <td colspan="2"><b>Cantidad de cheques por página al imprimir</b></td>
                         <td><input type="number" name="cantidad" id="cantidad" class="form-control" value="<?=$reg->cantidad?>"></td>
                     </tr>
                     <tr>
                         <td colspan="6">
                            <a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Regresar al Mantenimiento de Bancos</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Confirmar Posiciones</button>
                         </td>
                     </tr>
                 </tbody>
             </table>
            </div>
        </form>
        <div class="contenedor">
            <div class="imagen">
                <? if($reg->imagen!=''){?>
                    <img src="media/com_erp/cheques/thumb_<?=$reg->imagen?>" alt="" id="imgcheque">
                <? }?>
            </div>
            <div class="cheque" style="height:<?=$alto?>px;">
                <div class="dinero" style="top:<?=$reg->posy_montonum?>px;left:<?=$reg->posx_montonum?>px"><b>MONTO</b></div>
                
                <div class="ciudad" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_ciudad?>px;"><b>CIUDAD</b></div>
                <div class="dia" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_dd?>px;"><b>DIA</b></div>
                <div class="mes" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_mm?>px;"><b>MES</b></div>
                <div class="anio" style="top:<?=$reg->posy_ciudad?>px;left:<?=$reg->posx_aa?>px;"><b>AÑO</b></div>
                
                <div class="nombre" style="top:<?=$reg->posy_nombre?>px;left:<?=$reg->posx_nombre?>px"><b>NOMBRE</b></div>
                <div class="monto" style="top:<?=$reg->posy_montolit?>px;left:<?=$reg->posx_montolit?>px"><b>MONTO LITERAL</b></div>
                <div class="moneda" style="top:<?=$reg->posy_moneda?>px;left:<?=$reg->posx_moneda?>px; display:<?=$reg->imp_moneda==1?'block':'none'?>"><b>MONEDA</b></div>            
            </div>
        </div>
        <div class="container-fluid" style="margin-top:25px;">
            <form action="index.php?option=com_erp&view=librobancos&layout=altocheque&tmpl=blank" name="form2" id="formimg" class="form-horizontal" enctype="multipart/form-data" method="POST">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2"><b>Actualizar la imagen del cheque</b></label>
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
            <h3 class="alert alert-success">Se ha editado correcamente el cheque</h3>
            <a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar al Mantenimiento de Bancos</a>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>