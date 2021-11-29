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
	location.href = 'index.php?option=com_erp&view=contaadmcuentas&layout=lista&id='+id+'&id_html='+id_html+'&aux='+aux+'&tmpl=component';
	}
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
        <h3 class="box-title">Plan de Cuentas</h3>        
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
                        <select name="aux" id="aux" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                        	<option value="1" <?=$aux==1?'selected':''?>>Mostrar auxiliares</option>
                            <option value="0" <?=$aux==0?'selected':''?>>Ocultar auxiliares</option>
                        </select>
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable">
            <thead>
              <tr>
                <th width="20">#</th>
                <th width="80">Código</th>
                <th>Nombre</th>
                <th width="80"></th>
              </tr>
            </thead>
            <tbody>
				<? $n = 1;
                foreach(getCNTcuentas($id_gestion) as $cta){
					if($cta->codigo == 0){
						$pcuenta = getCNTcuenta($cta->id_padre);
						$codigo = '';
						$cta_id = $pcuenta->id;
						$cta_codigo = $pcuenta->codigo;
						$cta_nombre = $pcuenta->nombre.' ('.$cta->nombre.')';
						$id_auxiliar = $cta->id;
						}else{
						$codigo = codigoRename($cta->codigo);
						$cta_id = $cta->id;
						$cta_codigo = $cta->codigo;
						$cta_nombre = $cta->nombre;
						$id_auxiliar = 0;
						}
					?>
                <tr>
                  <td><?=$n?></td>
                  <td><?=$codigo?></td>
                  <td><?=$cta->nombre_completo?></td>
                  <td>
                      <? if(!hasChild($cta->id)){?>
                      <a class="btn btn-success btn-xs" onClick="envia('<?=$cta_id?>', '<?=filtroCadena2($cta_nombre)?>', '<?=codigoRename($cta_codigo)?>', '<?=$id[1]?>', '<?=$id_auxiliar?>')">
                          <em class="fa fa-pencil"></em> Cargar
                      </a>
                      <? }?>
                  </td>
                </tr>
                <? $n++;}?>
            </tbody>
        </table>            
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>