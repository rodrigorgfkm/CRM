<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
?>
<script>
function cambiaGestion(){
	var id = jQuery('#id_gestion').val();
	
	location.href = 'index.php?option=com_erp&view=presupuesto&layout=ejecutado&id='+id;
	}

jQuery(function () {
	jQuery("input[type=text]").focus(function(){	   
		this.select();
		});	
	});
</script>
<style>
    #ctanum{
        display: none;
    }
    @media print{
        .print,.main-footer{
            display: none;
        }
        #ctanum{
            display: block;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte Comparativo por Cuentas</h3>
      </div>
      <div class="box-body print">
      	<div class="row">
            <div class="col-sm-12 col-md-12">
            	<form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
                	<label for="" class="col-xs-12 col-sm-2">
                    	Seleccionar Gestión: 
                	</label>
                    <div class="col-xs-12 col-sm-8">
                    	<select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                            <? foreach(getGestiones() as $ge){
                              if($ge->id==$id){
                                    $selected_g = 'selected';
                                    $gestion = $ge->gestion;
                                }else{
                                    $selected_g = '';
                                }?>
                              <option value="<?=$ge->id?>" <?=$selected_g?>><?=$ge->gestion?></option>
                            <? }?>
                    	</select>
                	</div>
                </form>
            </div>
        </div>
          <div class="container col-xs-12">
               <button type="button" class="btn btn-primary pull-right" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
               <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
          </div>
      </div>
      <div class="box-body">
        <h4 id="ctanum"><b>Gestión:<?=$gestion?></b></h4>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th width="20">#</th>
              <th width="80">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="250">Presupuestado Total</th>
              <th width="250">Ejecutado Total Gestión Anterior</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
            foreach(getCNTcuentaspreRep($id,1) as $cta){?>
            <tr>
              <td><?=$n?></td>
              <td><?=codigoRename($cta->codigo)?></td>
              <td><?=$cta->nombre?></td>
              <td class="text-right">
                  <? 
				  $monto = $cta->monto;
				  if($monto == '')
					  $monto = 0.00;
				  echo num2monto($monto);
                  ?>
              </td>
              <td class="text-right">
                  <? 
				  $monto = getPreExec($id, $cta->id);
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