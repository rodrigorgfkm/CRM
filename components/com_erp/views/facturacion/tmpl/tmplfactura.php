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
    .facturaconten{
        border: 2px dashed black;
        height: 360px;
        width: 813px;
        position: relative;
        z-index: 2;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }
    .facturaconten>div{
        position: absolute;
        border: 1px dashed black;
        padding: 10px;
        z-index: 2;
    }
    .imagen{        
        position: absolute;
        z-index: 1;
        width: 813px;
        height: 529px;
    }
    #imgcheque{
        width: 100%;
        opacity: .9;
    }
    #diay, #mesy, #anioy{
        cursor: not-allowed;
    }
</style>
<script>
jQuery(document).on('ready', function(){
    //MOVIENDO POSICIONES
    //POSICION X
    jQuery('.posx').on('keyup change', function(){
        var claseidx = jQuery(this).closest('.form-group').attr('id');
        jQuery('.'+claseidx).css('left',jQuery(this).val()+'px');
    })
    //POSICION Y
    jQuery('.posy').on('keyup change', function(){
        var claseidy = jQuery(this).closest('.form-group').attr('id');
        jQuery('.'+claseidy).css('top',jQuery(this).val()+'px');        
    })
    //POSICION ANCHO
    jQuery('.ancho').on('keyup change', function(){
        var claseidancho = jQuery(this).closest('.form-group').attr('id');
        jQuery('.'+claseidancho).css('width',jQuery(this).val()+'px');        
    })
    //TAMÑO FUENTE
    jQuery('.fuente').on('keyup change', function(){
        var claseidfuente = jQuery(this).closest('.form-group').attr('id');
        jQuery('.'+claseidfuente).css('font-size',jQuery(this).val()+'px');        
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
    //ABRIENDO POSICIONES
    jQuery('.caja').on('click',function(){
        var miclasec = jQuery(this).attr('class');
        var caja = miclasec.split(' ');
        jQuery('.form-group').hide(500);
        jQuery('#'+caja[0]).show(500);
    })
    //cerrar campos
    jQuery('.close_c').on('click',function(){
        var id = jQuery(this).parent().attr('id');
        jQuery('#'+id).hide(500);
    })
    /*------ENVIANDO DATOS------*/
    jQuery('.btn-success').on('click',function(){
        var posx = jQuery(this).closest('.form-group').find('.posx').val();
        var posy = jQuery(this).closest('.form-group').find('.posy').val();
        var ancho = jQuery(this).closest('.form-group').find('.ancho').val();
        var fuente = jQuery(this).closest('.form-group').find('.fuente').val();
        var visible = jQuery(this).closest('.form-group').find('[type=checkbox]').val();
        var id_campo = jQuery(this).siblings('[type=hidden]').val();
        var sucursal = jQuery('#sucursal').val();
        //alert(posx+'  '+posy+' '+id_campo);
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=facturacion&layout=actualizaposicion&tmpl=blank"',
            type: 'POST',
            data: {id:id_campo, pos_x:posx,pos_y:posy,tam_fuente:fuente, ancho:ancho, visible:visible, id_sucursal:sucursal}
        })
        jQuery(this).closest('.form-group').hide(500);
        /*.done(function(data){
        })*/
    })
    jQuery('.mycheck').on('click', function(){
        var mycheck = jQuery(this).parent().siblings('.id_check').val();
        var mypx = jQuery(this).parent().siblings('.id_px').val();
        var mypy = jQuery(this).parent().siblings('.id_py').val();
        var myanch = jQuery(this).parent().siblings('.id_anch').val();
        var myfuente = jQuery(this).parent().siblings('.id_fuen').val();
        
        var nombre = jQuery(this).parent().siblings('.nombre').val();
        var id_check = jQuery(this).attr('id');
        var vis;
        if(jQuery('#'+id_check).prop('checked')){
            jQuery('.'+nombre).show(500);
            vis = 1;
        }else{
            jQuery('.'+nombre).hide(500);
            vis = 0;
        }
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=facturacion&layout=actualizaposicion&tmpl=blank',
            type: 'POST',        
            data: {id:mycheck, pos_x:mypx,pos_y:mypy,tam_fuente:myfuente, ancho:myanch, visible:vis}
        })        
    })
    /*.done(function(data){
    })*/
})
</script>
<?
//ruta de la imagen para calcular el alto y ancho del cheque
$id = JRequest::getVar('id','','get');
$reg = getFacturaCampos($id);
/*echo '<pre>';
print_r($reg);
echo '</pre>';*/
//$imgsrc = "media/com_erp/cheques/thumb_".$reg->imagen;
$imgsrc = "media/com_erp/factura.jpg";
imagecreatefromjpeg($imgsrc);
$imagen = getimagesize($imgsrc);    //Sacamos la información     //Ancho
$alto = $imagen[1];
/*foreach ($reg as $value){
    //echo $value->pos_x."<br>";
    //echo $value->pos_y."<br>";
    echo $value->campo."<br>";
}*/
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
            function clasenombre($clasenombre){
                switch ($clasenombre){
                    case 'factura_numero':
                        $clase_campo = 'nfactura_Nº DE FACTURA';
                        break;
                    case 'llave_autorizacion':
                        $clase_campo = 'autorizacion_Nº AUTORIZACIÓN';
                        break;
                    case 'factura_fliteral':
                        $clase_campo = 'fechaliteral_FECHA LITERAL';
                        break;
                    case 'cliente_nit':
                        $clase_campo = 'nitcliente_NIT CLIENTE';
                        break;
                    case 'cliente':
                        $clase_campo = 'cliente_CLIENTE RAZON SOCIAL';
                        break;
                    case 'factura_dia':
                        $clase_campo = 'dia_DIA';
                        break;
                    case 'factura_mes':
                        $clase_campo = 'mes_MES';
                        break;
                    case 'factura_anio':
                        $clase_campo = 'anio_AÑO';
                        break;
                    case 'factura_cheque':
                        $clase_campo = 'cheque_X';
                        break;
                    case 'fecha_completa':
                        $clase_campo = 'fechacompleta_FECHA COMPLETA';
                        break;
                    case 'factura_efectivo':
                        $clase_campo = 'efectivo_X';
                        break;
                    case 'factura_bolivianos':
                        $clase_campo = 'bs_X';
                        break;
                    case 'factura_dolares':
                        $clase_campo = 'sus_X';
                        break;
                    case 'factura_nrocheque':
                        $clase_campo = 'ncheque_Nº CHEQUE';
                        break;
                    case 'factura_banco':
                        $clase_campo = 'banco_BANCO';
                        break;
                    case 'factura_totalliteral':
                        $clase_campo = 'montolit_MONTO LITERAL';
                        break;
                    case 'factura_codigo':
                        $clase_campo = 'codigoc_CÓDIGO DE CONTROL';
                        break;
                    case 'llave_fechalimite':
                        $clase_campo = 'fechalimitellave_FECHA DE LIMITE LLAVE';
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
                    case 'factura_total':
                        $clase_campo = 'total_TOTAL';
                        break;
                    case 'factura_pie':
                        $clase_campo = 'facturapie_FACTURA PIE';
                        break;
                    case 'factura_qr':
                        $clase_campo = 'facturaqr_FACTURA QR';
                        break;
                    case 'factura_original':
                        $clase_campo = 'facturaoriginal_FACTURA ORIGINAL';
                        break;
                    case 'empresa_rubro':
                        $clase_campo = 'empresarubro_EMPRESA RUBRO';
                        break;
                    case 'empresa_datos':
                        $clase_campo = 'empresadatos_EMPRESA DATOS';
                        break;
                }
                return $clase_campo;
            }
            ?>
            <div class="facturaconten" style="height:<?=$alto?>px;display:inline-block">
                <? foreach ($reg as $cuadro){
                    $clasenomb = clasenombre($cuadro->campo);
                    $tipo = explode('_',$clasenomb);
                ?>
                   <div class="<?=$tipo[0]?> caja" style="left:<?=$cuadro->pos_x?>px;top:<?=$cuadro->pos_y?>px;<?=$cuadro->visible==1?'display:block;':'display:none;';?>width:<?=$cuadro->ancho==0?'auto;':$cuadro->ancho.'px;';?>font-size:<?=$cuadro->tam_fuente?>px;"><b><?=$tipo[1]?></b></div>
                <? }?>
            </div>
            <div style="width:300px; height:480px;display:inline-block">
                <? foreach ($reg as $forms){
                    $clasenomb = clasenombre($forms->campo);
                    $idclase = explode('_',$clasenomb);
                ?>
                <div class="form-group" id="<?=$idclase[0]?>" style="display:none;position:relative;">
                    <div class="col-md-12 text-center text-blue"><b><?=$idclase[1]?></b></div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">M. Izquierdo</label>                            
                        <input type="number" name="<?=$idclase[0]?>pos_x" id="<?=$idclase[0]?>x" class="form-control posx" value="<?=$forms->pos_x?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">M. Superior</label>
                        <input type="number" name="<?=$idclase[0]?>pos_y" id="<?=$idclase[0]?>y" class="form-control posy" value="<?=$forms->pos_y?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">Ancho</label>
                        <input type="number" name="<?=$idclase[0]?>_ancho" id="<?=$idclase[0]?>_ancho" class="form-control ancho" value="<?=$forms->ancho?>">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="col-xs-12">T. Fuente</label>
                        <input type="number" name="<?=$idclase[0]?>_fuente" id="<?=$idclase[0]?>_fuente" class="form-control fuente" value="<?=$forms->tam_fuente?>">
                    </div>
                    <div class="col-xs-12">
                        <input type="hidden" name="<?=$forms->campo?>_id" id="<?=$forms->campo?>_id" value="<?=$forms->id_campo?>">
                        <label for=""><input type="checkbox" name="<?=$forms->campo?>_check" id="<?=$forms->campo?>_check" value="1" <?=$forms->visible==1?'checked':'';?> style="display:none"> Visible</label>
                        <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                    <button type="button" class="btn btn-danger close_c" style="position:absolute;"><i class="fa fa-remove"></i></button>
                </div>
                <? }?>
                <input type="hidden" name="sucursal" id="sucursal" value="<?=JRequest::getVar('id')?>">
            </div>
            <div class="col-xs-12">
               <? foreach ($reg as $checks){
                    $clasenomb = clasenombre($checks->campo);
                    $idcheck = explode('_',$clasenomb);
                ?>
                <div class="col-md-3">
                    <input type="hidden" name="px_<?=$checks->campo?>" id="px_<?=$checks->campo?>" class="id_px" value="<?=$checks->pos_x?>">
                    <input type="hidden" name="py_<?=$checks->campo?>" id="py_<?=$checks->campo?>" class="id_py" value="<?=$checks->pos_y?>">
                    <input type="hidden" name="anch_<?=$checks->campo?>" id="anch_<?=$checks->campo?>" class="id_anch" value="<?=$checks->ancho?>">
                    <input type="hidden" name="fu_<?=$checks->campo?>" id="fu_<?=$checks->campo?>" class="id_fuen" value="<?=$checks->tam_fuente?>">
                    <input type="hidden" name="id_<?=$checks->campo?>" id="id_<?=$checks->campo?>" class="id_check" value="<?=$checks->id_campo?>">
                    <input type="hidden" name="campo_<?=$checks->campo?>" id="campo_<?=$checks->campo?>" class="nombre" value="<?=$idcheck[0]?>">
                    <label for=""><input type="checkbox" name="<?=$checks->campo?>_checkb" id="<?=$checks->campo?>_checkb" class="mycheck" value="1" <?=$checks->visible==1?'checked':'';?>> <?=$idcheck[1]=='X'?strtoupper($checks->campo):$idcheck[1];?></label>
                </div>
               <? }?>
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