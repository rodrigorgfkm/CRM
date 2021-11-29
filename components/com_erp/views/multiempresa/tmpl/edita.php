<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<?
$user =& JFactory::getUser();
$empresa = getEmpresa();
$usuario = getUsuario($user->get('id'));
?>
<?
 $lim_emp = 50;
 $lim_nit = 15;
 $lim_cod = 10;
if(!$_POST){?>              
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Datos de la Empresa</h3>
      </div>
      <div class="col-xs-12 text-right" style="padding-bottom:20px;">          
           <a href="index.php?option=com_erp&view=multiempresa" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver</a>
      </div>
      <div class="box-body">
          <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal">
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Empresa o Razón social <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <select name="empresa" id="empresa" class="form-control validate[required, maxSize[<?=$lim_emp?>]] select">                          
                          <? foreach (getCRMProspectos() as $empresa){?>
                              <option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
                          <? }?>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Tipo de Sociedad <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <select name="razon" id="razon" onChange="campo()" class="form-control validate[required, maxSize[<?=$lim_nit?>]] select2">
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
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">NIT <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="nit" id="nit" class="form-control validate[required]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Nombre comercial <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="comercial" id="comercial" class="form-control validate[required, maxSize[<?=$lim_cod?>]]">
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
                      <input type="text" name="codigo" id="codigo" class="form-control validate[reqruired]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Usuario <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="usuario" id="usuario" class="form-control validate[reqruired]">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label col-xs-12 col-sm-2">Sucursal <i class="fa fa-asterisk text-red"></i></label>
                  <div class="col-xs-12 col-sm-10">
                      <input type="text" name="sucursal" id="sucursal" class="form-control validate[reqruired]">
                  </div>
              </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm col-sm-3 col-xs-12" ><i class="fa fa-refresh"></i> Actualizar</button>
              </div>            
        </form>
    <? }else{}?>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>