<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<style>
@media print{
    .table-responsive{
        width: 100%;
    }
}
    .cliente{
        overflow-x: auto;
        width: 100%;               
    }
    .etiqueta{
        position: relative;
        border: 1px black dashed;
    }
    .etiqueta>div{
        position: absolute;
        padding: 5px;
        border: 1px black dashed;
        width: auto;
    }
    .table-responsive{
        width: 50%;
    }
</style>
<script>
jQuery(document).on('ready', function(){
    //monto Númeral
    jQuery('#nombrex').on('keyup change', function(){
        jQuery('.contacto').css('left',jQuery(this).val()+'px');
    })
    jQuery('#nombrey').on('keyup change', function(){
        jQuery('.contacto').css('top',jQuery(this).val()+'px');
    })//Empresa
    jQuery('#empresax').on('keyup change', function(){
        jQuery('.empresa').css('left',jQuery(this).val()+'px');
    })
    jQuery('#epmresay').on('keyup change', function(){
        jQuery('.empresa').css('top',jQuery(this).val()+'px');
    })//Direccion
    jQuery('#dirx').on('keyup change', function(){
        jQuery('.dir').css('left',jQuery(this).val()+'px');
    })
    jQuery('#diry').on('keyup change', function(){
        jQuery('.dir').css('top',jQuery(this).val()+'px');
    })//dimension
    jQuery('#alto').on('keyup change', function(){
        //if(jQuery(this).val()<=120){
            jQuery('.etiqueta').css('height',jQuery(this).val()+'px');            
        //}
    })
    jQuery('#ancho').on('keyup change', function(){
        //if(jQuery(this).val()<=340){
            jQuery('.etiqueta').css('width',jQuery(this).val()+'px');            
        //}
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
    /*jQuery("#imagen").on('change',function(){
        jQuery('#formimg').trigger('submit');
        readURL(this);
        
    });*/
    jQuery("input[type=number]").focus(function(){	  
        this.select();
    })
})
</script>
<?
$etiqueta = getEtiqueta();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-tags"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Posiciones de Etiqueta</h3>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
         <form action="" name="form" id="form" class="form-horizontal table-responsive" enctype="multipart/form-data" method="post">
             <!--<input type="hidden" name="id" value="<?=$id?>">-->
             <table class="table table-striped table-bordered">
                 <thead>
                 </thead>
                 <tbody>
                     <tr>
                         <td></td>
                         <td><b>Alto</b></td>
                         <td><b>Ancho</b></td>
                     </tr>
                     <tr>
                         <td><b>Dimensión</b></td>
                         <td><input type="number" name="alto" id="alto" class="form-control" value="<?=$etiqueta->alto?>"></td>
                         <td><input type="number" name="ancho" id="ancho" class="form-control" value="<?=$etiqueta->ancho?>"></td>
                     </tr>
                     <tr>
                         <td colspan="3"></td>
                     </tr>
                     <tr>
                         <td></td>
                         <td><b>Margen Izquierdo</b></td>
                         <td><b>Margen Superior</b></td>
                     </tr>
                     <tr>
                         <td><b>Nombre</b></td>
                         <td><input type="number" name="posx_nombre" id="nombrex" class="form-control" value="<?=$etiqueta->posx_nombre?>"></td>
                         <td><input type="number" name="posy_nombre" id="nombrey" class="form-control" value="<?=$etiqueta->posy_nombre?>"></td>
                     </tr>
                     <tr>
                         <td><b>Empresa</b></td>
                         <td><input type="number" name="posx_empresa" id="empresax" class="form-control" value="<?=$etiqueta->posx_empresa?>"></td>
                         <td><input type="number" name="posy_empresa" id="epmresay" class="form-control"value="<?=$etiqueta->posy_empresa?>"></td>
                     </tr>                     
                     <tr>
                         <td><b>Dirección</b></td>
                         <td><input type="number" name="posx_dir" id="dirx" class="form-control" value="<?=$etiqueta->posx_dir?>"></td>
                         <td><input type="number" name="posy_dir" id="diry" class="form-control" value="<?=$etiqueta->posy_dir?>"></td>
                     </tr>
                     <tr>
                         <td colspan="3"></td>
                     </tr>                     
                     <tr>
                         <td width="200px"><b>Cantidad de Etiquetas por página al imprimir</b></td>
                         <td><input type="number" name="cantidad" id="cantidad" class="form-control" value="<?=$etiqueta->cantidad?>"></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td colspan="6">
                            <!--<a href="index.php?option=com_erp&view=librobancos&layout=mantenimiento" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Regresar al Mantenimiento de Bancos</a>-->
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Confirmar Posiciones</button>
                         </td>
                     </tr>
                 </tbody>
             </table>
            </div>
        </form>
        <div class="cliente">
            <div class="etiqueta" style="width:<?=$etiqueta->ancho?>px;height:<?=$etiqueta->alto?>px;">
                <!--<div class="conten">
                    <div class"texto">SEÑOR:</div>
                    <div class="tipo">TIPO</div>
                </div>-->
                <div class="contacto" style="top:<?=$etiqueta->posy_nombre?>px;left:<?=$etiqueta->posx_nombre?>px;">NOMBRE Y APELLIDO</div>
                <div class="empresa" style="top:<?=$etiqueta->posy_empresa?>px;left:<?=$etiqueta->posx_empresa?>px;">NOMBRE DE LA EMPRESA</div>
                <div class="dir" style="top:<?=$etiqueta->posy_dir?>px;left:<?=$etiqueta->posx_dir?>px;">DIRECCIÓN DE LA EMPRESA</div>
            </div>
        </div>
        <!--<div class="container-fluid" style="margin-top:25px;">
            <form action="index.php?option=com_erp&view=clientes&layout=altocheque&tmpl=blank" name="form2" id="formimg" class="form-horizontal" enctype="multipart/form-data" method="POST">
               <div class="form-group">
                   <label for="" class="col-xs-12 col-sm-2"><b>Actualizar la imagen de la etiqueta</b></label>
                   <div class="col-xs-12 col-sm-10">
                       <input type="hidden" name="id" value="<?=$id?>">
                       <input type="file" name="imagen" id="imagen" class="form-control">
                   </div>
               </div>
            </form>
        </div>-->
        <? }else{
            editEtiqueta();
        ?>
            <h3 class="alert alert-success">Se ha editado correcamente la Etiqueta</h3>
            <a href="index.php?option=com_erp&view=clientes&layout=etiquetas" class="btn btn-info"><i class="fa fa-arrow-left"></i> Regresar al listado de las etiquetas</a>
        <? }?>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>