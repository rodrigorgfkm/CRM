<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var mes = jQuery('#mes').val();
	
	location.href = 'index.php?option=com_erp&view=contapresupuesto&id='+id+'&mes='+mes;
	}

jQuery(function () {
	jQuery("input[type=text]").focus(function(){	   
		this.select();
		});	
	});


</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asignación de presupuestos</h3>
      </div>
      <? if(!$_POST){?>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
              <label for="" class="col-xs-12 col-sm-2">
                  Seleccionar Gestión: 
              </label>
              <div class="col-xs-12 col-sm-8">
                  <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto" onChange="cambiaGestion()">
                      <? foreach(getGestiones() as $ge){?>
                      <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                      <? }?>
                  </select>
                  <select name="mes" id="mes" class="form-control" style="width:auto" onChange="cambiaGestion()">
                      <option value="01" <?=$mes=='01'?'selected':''?>>Enero</option>
                      <option value="02" <?=$mes=='02'?'selected':''?>>Febrero</option>
                      <option value="03" <?=$mes=='03'?'selected':''?>>Marzo</option>
                      <option value="04" <?=$mes=='04'?'selected':''?>>Abril</option>
                      <option value="05" <?=$mes=='05'?'selected':''?>>Mayo</option>
                      <option value="06" <?=$mes=='06'?'selected':''?>>Junio</option>
                      <option value="07" <?=$mes=='07'?'selected':''?>>Julio</option>
                      <option value="08" <?=$mes=='08'?'selected':''?>>Agosto</option>
                      <option value="09" <?=$mes=='09'?'selected':''?>>Septiembre</option>
                      <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
                      <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
                      <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
                  </select>
              </div>
            </div>
        </div>
      </div>
      <form  method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="20">#</th>
                  <th width="80">C&oacute;digo</th>
                  <th>Nombre</th>
                  <th width="200">Presupuesto</th>
                </tr>
              </thead>
              <tbody>
                <? $n = 1;
                foreach(getCNTcuentas($id) as $cta){?>
                <tr>
                  <td><?=$n?></td>
                  <td><?=codigoRename($cta->codigo)?></td>
                  <td><?=$cta->nombre_completo?></td>
                  <td class="text-center">
                      <? 
					  if($cta->id_origen != 0){
					  	if(checkCNTctapresupuesto($cta->id_origen) == 1){
							$monto = getCNTpresupuesto($cta->id);
							if($monto == ''){
								if($mes > 1)
									$monto = executeCNTpresupuesto($cta->codigo, ($mes-1));
									else
									$monto = 0.00;
								}
							?>
                      <input type="hidden" name="id_cta[]" id="id_cta[]" value="<?=$cta->id?>">
                      <input type="text" name="presupuesto[]" id="presupuesto_<?=$cta->id?>" class="form-control text-right" value="<?=$monto?>">
                      <? }}?>
                  </td>
                </tr>
                <? $n++;}?>
              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right col-xs-12 col-sm-2"><em class="fa fa-floppy-o"></em> Guardar cambios</button>
          </div>
      </form>
      <? }
	  else{
		  saveCNTpresupuesto();
		  ?>
	  <div class="box-body">
      	<h3>La asignación de presupeustos se realizó correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=contapresupuesto" class="btn btn-info">
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