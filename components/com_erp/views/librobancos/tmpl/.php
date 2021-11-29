<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	var mes = jQuery('#mes').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=comparativopormes&id='+id+'&mes='+mes;
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
        <h3 class="box-title">Reporte comparativo por mes</h3>
      </div>
      <div class="container col-xs-12">
           <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
      </div>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-2">
                    	Seleccionar Gestión: 
                	</label>
                    <div class="col-xs-12 col-sm-8">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){?>
                            <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                            <? }?>
                    	</select>
                        <select name="mes" id="mes" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
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
                </form>
            </div>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th width="20">#</th>
              <th width="80">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="200">Presupuestado</th>
              <th width="200">Ejecutado</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
            foreach(getCNTcuentaspre($id) as $cta){?>
            <tr>
              <td><?=$n?></td>
              <td><?=codigoRename($cta->codigo)?></td>
              <td><?=$cta->nombre?></td>
              <td class="text-right">
                  <? 
				  $monto = getCNTpresupuesto($cta->id);
				  if($monto == '')
					  $monto = 0.00;
				  echo num2monto($monto);
                  ?>
              </td>
              <td class="text-right">
                  <? 
				  $monto = executeCNTpresupuesto($cta->codigo, $mes);
				  echo num2monto($monto);
                  ?>
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