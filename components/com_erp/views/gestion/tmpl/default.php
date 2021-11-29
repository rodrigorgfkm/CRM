<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administrador')){?>
<?
$user =& JFactory::getUser();
$empresa = getEmpresa();
$usuario = getUsuario($user->get('id'));
?>
<? if($usuario->group_id == 8){
    if(!$_POST){?>
<script>
function campo(){
    var tipo = jQuery('#razon').val();
    switch(tipo){
        case 'Otro':
        jQuery('.otro').slideDown();
        jQuery('.titular').slideUp();
        jQuery('#titular').val('');
        break;
        case 'Unipersonal':
        jQuery('.otro').slideUp();
        jQuery('#otro').val('');
        jQuery('.titular').slideDown();
        break;
        default:
        jQuery('.otro').slideUp();
        jQuery('.titular').slideUp();
        jQuery('#otro').val('');
        jQuery('#titular').val('');
        break;
        }
    }
</script>              
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Datos de la Empresa</h3>
      </div>
      <div class="box-body">
    <?
        $lim_emp = 50;
        $lim_nit = 20;
        $lim_sig = 15;
    ?>
    <form method="post" enctype="multipart/form-data" name="form" id="form">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <td width="200">Razón social</td>
            <td><input type="text" name="empresa" id="empresa" class="form-control validate[required, maxSize[<?=$lim_emp?>]]" value="<?=$empresa->empresa?>"></td>
          </tr>
          <tr>
            <td>Tipo de Sociedad</td>
            <td>
                <select name="razon" id="razon" onChange="campo()" class="form-control">
                	<option value=""></option>
                    <option value="Unipersonal" <?=$empresa->razon=='Unipersonal'?'selected':''?>>Unipersonal</option>
                    <option value="S.R.L." <?=$empresa->razon=='S.R.L.'?'selected':''?>>S.R.L.</option>
                    <option value="S.A." <?=$empresa->razon=='S.A.'?'selected':''?>>S.A.</option>
                    <option value="S.C.A." <?=$empresa->razon=='S.C.A.'?'selected':''?>>S.C.A.</option>
                    <option value="Soc. Ac." <?=$empresa->razon=='Soc. Ac.'?'selected':''?>>Soc. Ac.</option>
                    <option value="Ltda." <?=$empresa->razon=='Ltda.'?'selected':''?>>Ltda.</option>
                    <option value="Sociedad Estatal" <?=$empresa->razon=='Sociedad Estatal'?'selected':''?>>Sociedad Estatal</option>
                    <option value="Otro" <?=$empresa->razon=='Otro'?'selected':''?>>Otro</option>
                </select>
            </td>
          </tr>
          <tr>
            <td width="200"><span class="titular" style="display:none">Nombre del Titular</span></td>
            <td><span class="titular" style="display:none"><input type="text" name="titular" id="titular" class="form-control validate[required]" value="<?=$empresa->titular?>"></span></td>
          </tr>
          <tr>
            <td width="200"><span class="otro" style="display:none">Sociedad</span></td>
            <td><span class="otro" style="display:none"><input type="text" name="otro" id="otro" class="form-control" value="<?=$empresa->otro?>"></span></td>
          </tr>
          <tr>
            <td><?=$empresa->nombre_docidentidad?></td>
            <td><input type="text" name="nit" id="nit" class="form-control validate[required, maxSize[<?=$lim_nit?>]]" value="<?=$empresa->nit?>"></td>
          </tr>
          <!--<tr>
            <td>Gran Actividad</td>
            <td>
              <select name="granactividad" id="granactividad" class="form-control">
                <option value=""></option>
                <option value="Servicios">Servicios</option>
                <option value="Comercio">Comercio</option>
              </select>
            </td>
          </tr>-->
          <tr>
            <td>Nombre Comercial</td>
            <td><input type="text" name="comercial" id="comercial" class="form-control validate[required, maxSize[<?=$lim_sig?>]]" value="<?=$empresa->comercial?>"></td>
          </tr>
          <tr>
            <td>Logo</td>
            <td>
            	<? if($empresa->logo != '')
					echo '<img src="media/com_erp/'.$empresa->logo.'">'?>
            	<input type="file" name="logo" id="logo">
            </td>
          </tr>
          <tr>
            <td>Logo Impresión</td>
            <td>
            	<? if($empresa->logoimpresion != '')
					echo '<img src="media/com_erp/'.$empresa->logoimpresion.'">'?>
            	<input type="file" name="logoimpresion" id="logoimpresion">
            </td>
          </tr>
          <tr>
            <td>País</td>
            <td>
            	<select name="id_pais" class="form-control validate[required]">
                	<? foreach(getPaises() as $pais){?>
                	<option value="<?=$pais->id?>" <?=$pais->id==$empresa->id_pais?'selected':''?>><?=$pais->pais?></option>
                    <? }?>
                </select>
            </td>
          </tr>
          <!--
          <tr>
            <td colspan="2">Otros impuestos</td>
            </tr>
          <tr>
            <td>Nombre impuesto</td>
            <td><input type="text" name="impuesto2"> Porcentaje
              <input type="text" name="impuesto3" placeholder="0%"></td>
          </tr>-->
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" class="btn btn-success" value="Enviar"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		editEmpresa();?>
		<h3>Los datos de la empresa fueron modificados correctamente</h3>
        <p><input type="button" name="button" class="btn btn-success" value="Volver" onClick="location.href='index.php?option=com_erp&view=gestion&Itemid=802'"></p>
		<?
		}}else{?>
		<h3>No tiene privilegios para ver este contenido</h3>
		<? }?>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>