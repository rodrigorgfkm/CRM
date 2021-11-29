<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<script>
function campo(){
	var razon = jQuery('#razon').val();
	if(razon == 'Otro')
		jQuery('#otro').slideDown();
		else
		jQuery('#otro').slideUp();
	
	if(razon == 'Unipersonal')
		jQuery('#div_otro').slideDown();
		else
		jQuery('#div_otro').slideUp();
	}
</script>           
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-building"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear empresa</h3>
      </div>
     <div class="col-xs-12 text-right" style="padding-bottom:20px;">          
           <a href="index.php?option=com_erp&view=multiempresa" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver</a>
      </div>
      <div class="box-body">
        <?
         $lim_emp = 50;
         $lim_nit = 15;
         $lim_cod = 10;
        ?>
          <? if(!$_POST){?>
          <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">             
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Empresa o Razón social <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="empresa" id="empresa" class="form-control validate[required, maxSize[<?=$lim_emp?>]]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Tipo de Sociedad <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <select name="razon" id="razon" onChange="campo()" class="form-control validate[required] select2">
                        <option value=""></option>
                        <option value="Unipersonal">Unipersonal</option>
                        <option value="S.R.L.">S.R.L.</option>
                        <option value="S.A.">S.A.</option>
                        <option value="S.C.A.">S.C.A.</option>
                        <option value="Soc. Ac.">Soc. Ac.</option>
                        <option value="Ltda.">Ltda.</option>
                        <option value="Sociedad Estatal" >Sociedad Estatal</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input type="text" name="otro" id="otro" class="form-control" placeholder="Tipo de sociedad" style="display:none">
                  </div>
              </div>
              <div class="form-group" id="div_otro" style="display:none">
                  <label for="" class="control-label col-xs-12 col-sm-2">Titular</label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="nit" id="nit" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">NIT <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="nit" id="nit" class="form-control validate[required, maxSize[<?=$lim_nit?>]]">
                  </div>
              </div>
              <div class="form-group">
                <label for="" class="control-label col-xs-12 col-sm-2">Logo <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="file" name="logo" id="logo" class="form-control validate[required]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Logo Impresión <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="file" name="logoimpresion" id="logoimpresion" class="form-control validate[reqruired]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Código <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="codigo" id="codigo" class="form-control validate[reqruired, maxSize[<?=$lim_cod?>]]">
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm col-sm-3 col-xs-12" ><i class="fa fa-floppy-o"></i> Guardar</button>
              </div>            
        </form>
    	<? }else{
			newMainEmpresa();
			}?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>