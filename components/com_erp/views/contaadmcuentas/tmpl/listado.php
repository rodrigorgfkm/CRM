<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Cuentas Contables')){
	$id_html = JRequest::getVar('id_html', '', 'get');
	$id = explode('_', $id_html);
	$id_gestion = JRequest::getVar('id', getGestionActiva(), 'get');
	$aux = JRequest::getVar('aux', 0, 'get');
	$n = 0;
?>
<script>
function envia(id, nombre, codigo, id_html, id_aux){    
	window.parent.recibe(id, nombre, codigo, id_html, id_aux);
	window.parent.Shadowbox.close();
	}
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var aux = jQuery('#aux').val();
	var id_html = '<?=$id_html?>';
	location.href = 'index.php?option=com_erp&view=contaadmcuentas&layout=listado&id='+id+'&id_html='+id_html+'&aux='+aux+'&tmpl=component';
	}
jQuery(document).ready(function(){
    jQuery('#cuenta').on('keyup', function(){
        var nro_cta = jQuery('#nro_cta').val();
        if(nro_cta.length>0){
            nro_cta = jQuery('#nro_cta').val();
        }
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=contaadmcuentas&layout=buscarcuenta&tmpl=blank',
            type: 'POST',
            data: {cuenta:jQuery(this).val(), nro_cta:nro_cta, gest:'<?=$id[1]?>'},
        })
        .done(function(data){
            jQuery('tbody').html(data);
        })
    })
    jQuery('#nro_cta').on('keyup', function(){
        var cuenta = jQuery('#cuenta').val();
        if(cuenta.length>0){
            cuenta = jQuery('#cuenta').val();
        }
        jQuery.ajax({
            url: 'index.php?option=com_erp&view=contaadmcuentas&layout=buscarcuenta&tmpl=blank',
            type: 'POST',
            data: {nro_cta:jQuery(this).val(), cuenta:cuenta, gest:'<?=$id[1]?>'},
        })
        .done(function(data){
            jQuery('tbody').html(data);
        })
    })
})
</script>
<style>
#header, #sidebar, #footer{ display: none}
.fixed-top #container{ margin-top:0px}
#body{ margin-left:0px; min-height:10px}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-book"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Buscar Cuenta Contable</h3>        
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-3">
                    	Seleccionar Gestión:
                	</label>
                    <div class="col-xs-12 col-sm-9">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){?>
                            <option value="<?=$ge->id?>" <?=$ge->id==$id_gestion?'selected':''?>><?=$ge->gestion?></option>
                            <? }?>
                    	</select>
                    	<input type="text" name="cuenta" id="cuenta" class="form-control" style="width:auto; display:inline" placeholder="Nombre de la Cuenta">
                    	<input type="text" name="nro_cta" id="nro_cta" class="form-control" style="width:auto; display:inline" placeholder="Número de Cuenta">
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="20">#</th>
                <th width="80">Código</th>
                <th>Nombre</th>
                <th width="80"></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
        </table>            
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>