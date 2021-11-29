<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Clientes')){?>
<?
$conf = getPosConfiguracion();
$campo = getCampo();
?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Editar campo</h3>
    <? if(!$_POST){?>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table class="table table-striped table-bordered datatable">
        <tbody>
          <tr>
            <td width="200">Campo</td>
            <td><input type="text" name="campo" id="campo" value="<?=$campo->tipo?>"></td>
          </tr>
          <tr>
            <td>Obligatorio</td>
            <td>
            	<label style="display:inline"><input style="display:inline" type="radio" name="obligatorio" value="1" <?=$campo->obligatorio==1?'checked':''?>> Si</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label style="display:inline"><input style="display:inline" type="radio" name="obligatorio" value="0" <?=$campo->obligatorio==0?'checked':''?>> No</label>
            </td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="submit" id="submit" value="Enviar" class="btn btn-success"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <? }else{
		editCampo();?>
		<h3>El campo fue editado correctamente</h3>
        <p><a href="index.php?option=com_erp&view=clientescampos" class="btn btn-success">Volver</a></p>
		<?
		}?>
						</div>
					</div>
              	  </div>
              </div>
              
              
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_clientesadmi.php' );?>
			</div>
<? }else{?>
<div class="alert alert-warning" style="width:100%; margin-top:50px; font-size:20px; line-height:20px; text-align:center">No tiene los <strong style="color:#c09803">privilegiós suficientes</strong> para acceder a esta sección</div>
	<style>
	#maincontainer{ background:#FFF !important}
	</style>
<? }?>