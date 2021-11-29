<?php
defined('_JEXEC') or die('Restricted access');
if(validaAcceso('Cuentas Contables')){
	$id = explode('_', JRequest::getVar('id', '', 'get'));
	$n = 0;
?>
<script>
function envia(id, nombre, codigo, id_html){
	window.parent.recibe(id, nombre, codigo, id_html);
	window.parent.Shadowbox.close();
	}
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=cargacuentas&id='+id+'&tmpl=component';
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
                	<label for="" class="col-xs-12 col-sm-2">
                    	Seleccionar Gestión: 
                	</label>
                    <div class="col-xs-12 col-sm-8">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){?>
                            <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                            <? }?>
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
                foreach(getCNTcuentas() as $cta){?>
                <? if($cta->presupuesto == 1){?>
                    <tr>
                      <td><?=$n?></td>
                      <td><?=codigoRename($cta->codigo)?></td>
                      <td><?=$cta->nombre_completo?></td>
                      <td>
                          <a class="btn btn-success btn-xs" onClick="envia('<?=$cta->id?>', '<?=$cta->nombre?>', '<?=$cta->codigo?>', '<?=$id[1]?>')">
                              <em class="fa fa-pencil"></em> Cargar
                          </a>
                      </td>
                    </tr>
                <? $n++;}?>
                <? }?>
            </tbody>
        </table>            
      </div>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>