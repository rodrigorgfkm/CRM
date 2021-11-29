<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){?>

<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=presupuesto&layout=cargacuentas&tmpl=component', width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, id_html){
	jQuery('#cuenta').val(nombre);
	jQuery('#cuenta_id').val(id);
	}
jQuery(document).ready(function(){
    //carga cuenta
    jQuery('form').on('click', '#cargafile_cta', function(){
        jQuery(this).siblings('#file_cta').trigger('click');
    })
    jQuery('form').on('change', '#file_cta', function(){                
        id_file=jQuery(this).attr('id');
        inputfile = document.getElementById(id_file).files;//obtenemos todos los archivos en la variable
        for (var i = 0; i < inputfile.length; i++) {
            var type = inputfile[i].name;            
        }
        var extension = type.split('.');
        //validando
        alert(extension);
        if(extension[1] == 'pdf' || extension[1] == 'xlsx' || extension[1] == 'docx' || extension[1] == 'pptx'){
            jQuery('#cargafile_cta').removeClass('btn-primary');
            jQuery('#cargafile_cta').addClass('bg-green-active');
            jQuery('#cargafile_cta').removeClass('validate[required]');
            jQuery('#cargafile_cta').html('<i class="fa fa-check"></i> Adjuntado');
        }else{
            jQuery('#cargafile_cta').removeClass('btn-warning');            
            jQuery('#cargafile_cta').addClass('btn-danger');
            jQuery('#cargafile_cta').html('<i class="fa fa-remove"></i> Archivo No Permitido');
            setTimeout(function(){//Retardando el Tiempo de Ejecucion
                jQuery('#cargafile_cta').removeClass('btn-danger');
                jQuery('#cargafile_cta').addClass('btn-warning');
                jQuery('#cargafile_cta').html('<i class="fa fa-upload"></i> Adjuntar Nuevamente');
            },3000);
        }
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Cargar Archivos de presupuesto</h3>
      </div>
      <div class="box-body">
      <?
        $lim_det = 50;    
        $lim_mont = 6;    
      ?>
      <? if(!$_POST){?>
          <form action="" class="form-horizontal" name="form" id="form" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Nombre de Responsable de Unidad <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="text" name="detalle" class="form-control validate[required, maxSize[<?=$lim_det?>]]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Adjuntar Archivo <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <button type="button" id="cargafile_cta" class="btn btn-warning validate[required]"><i class="fa fa-upload"></i> Cargar Archivo</button>
                      <input type="file" id="file_cta" name="archivo" style="display:none">
                      <br>
                      <small>Extensiones permitidas: pdf, xslx, docx, pptx</small>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Área de Prespuesto <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                    <select name="cuenta" id="cuenta" class="form-control validate[required]">
                      <option value="">Seleccionar</option>
                      <? foreach (getAreasPresupuesto() as $cta){?>
                          <option value="<?=$cta->id_cta?>"><?=$cta->area?></option>
                      <? }?>
                    </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-xs-12 col-sm-2 control-label">
                      Monto Total <i class="fa fa-asterisk text-red"></i>
                  </label>
                  <div class="col-sx-12 col-sm-4">
                      <input type="number" name="monto" id="monto" class="form-control validate[required, maxSize[<?=$lim_mont?>]]" step="any">
                  </div>
              </div>
              <div class="div col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
              </div>
          </form>
      </div>
      <? }
	  else{
		  newCNTsolicitud();
		  ?>
	  <div class="box-body">
      	<h3>El Formulario se envió correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=presupuesto&layout=formadjunta" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver
            </a>
        </p>
      </div>
	  <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>