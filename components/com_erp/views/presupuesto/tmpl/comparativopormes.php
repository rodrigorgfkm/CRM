<?php defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
    switch ($mes){
        case '1':
            $mesact = 'Enero';
            break;
        case '2':
            $mesact = 'Febrero';
            break;
        case '3':
            $mesact = 'Marzo';
            break;
        case '4':
            $mesact = 'Abril';
            break;
        case '5':
            $mesact = 'Mayo';
            break;
        case '6':
            $mesact = 'Junio';
            break;
        case '7':
            $mesact = 'Julio';
            break;
        case '8':
            $mesact = 'Agosto';
            break;
        case '9':
            $mesact = 'Septiembre';
            break;
        case '10':
            $mesact = 'Octubre';
            break;
        case '11':
            $mesact = 'Noviembre';
            break;
        case '12':
            $mesact = 'Diciembre';
            break;
    }
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
<style>
    #textocentro{
        display: none;
    }
    @media print{
        .print,.main-footer{
            display: none;
        }
        #textocentro{
            display: block;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte comparativo por mes</h3>
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
                        <select name="mes" id="mes" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                            <option value="1" <?=$mes=='1'?'selected':''?>>Enero</option>
                              <option value="2" <?=$mes=='2'?'selected':''?>>Febrero</option>
                              <option value="3" <?=$mes=='3'?'selected':''?>>Marzo</option>
                              <option value="4" <?=$mes=='4'?'selected':''?>>Abril</option>
                              <option value="5" <?=$mes=='5'?'selected':''?>>Mayo</option>
                              <option value="6" <?=$mes=='6'?'selected':''?>>Junio</option>
                              <option value="7" <?=$mes=='7'?'selected':''?>>Julio</option>
                              <option value="8" <?=$mes=='8'?'selected':''?>>Agosto</option>
                              <option value="9" <?=$mes=='9'?'selected':''?>>Septiembre</option>
                              <option value="10" <?=$mes=='10'?'selected':''?>>Octubre</option>
                              <option value="11" <?=$mes=='11'?'selected':''?>>Noviembre</option>
                              <option value="12" <?=$mes=='12'?'selected':''?>>Diciembre</option>
                    	</select>
                	</div>
                </form>
            </div>
        </div>
      </div>
      <div class="container col-xs-12 print">
           <button class="btn btn-primary pull-right print" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
           <a href="#" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
      </div>
      <div class="box-body">
        <center id="textocentro"><h4>Mes de <?=$mesact?>, Gestión <?=$gestion?></h4></center>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th width="20">#</th>
              <th width="80">C&oacute;digo</th>
              <th>Nombre</th>
              <th width="200">Presupuestado</th>
              <th width="200">Ejecutado Gestion Anterior</th>
            </tr>
          </thead>
          <tbody>
            <? $n = 1;
            foreach(getCNTcuentaspreRep($id,0,1) as $cta){?>
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
				  $monto = (getPreExec($id, $cta->id)/12);//executeCNTpresupuesto($cta->codigo, $mes);
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