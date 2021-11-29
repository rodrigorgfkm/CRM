<?php 
defined('_JEXEC') or die;
if(validaAcceso('Asignación de Presupuestos')){
	$id = JRequest::getVar('id', getGestionAc(), 'get');
	$mes = JRequest::getVar('mes', '01', 'get');
?>
<script>
jQuery(document).ready(function(){
    jQuery('.mes').on('keyup', function(){
        var valor = jQuery(this).val();
        var col = jQuery(this).closest('tr').attr('id');
        var totalcta = 0;
        for(i=1;i<=12;i++){
            totalcta = totalcta + parseInt(jQuery('#mes_'+i+'_'+col).val());
        }
        jQuery(this).parent().siblings('.cuenta').find('.total_cta').val(totalcta);
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Asignación de Presupuesto Ejecutado Anterior</h3>
      </div>
      <? //if(!$_POST['form']){?>
      <div class="box-body">
      	<div class="row">
            <div class="col-sm-12 col-md-6">
              <label for="" class="col-xs-12 col-md-3">
                  Seleccionar Gestión: 
              </label>
              <div class="col-xs-12 col-md-2">
                  <select name="id_gestion" id="id_gestion" class="form-control" style="width:auto; display:inline" onChange="cambiaGestion()">
                      <? foreach(getGestiones() as $ge){?>
                      <option value="<?=$ge->id?>" <?=$ge->id==$id?'selected':''?>><?=$ge->gestion?></option>
                      <? }?>
                  </select>
              </div>
            </div>
            <div class="col-xs-12">
                <b>Filtrar: </b>
                <form action="" name="form2" id="form2" method="post">
                    <input type="text" name="codigo" id="codigo" class="form-control" style="width:auto; display: inline-block" placeholder="Buscar Cuenta" value="<?=JRequest::getVar('codigo','','post')?>">
                    <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Buscar Cuenta</button>
                    <a href="index.php?option=com_erp&view=presupuesto&layout=formulario" class="btn btn-info"> Limpiar</a>
                </form>                
            </div>
        </div>
      </div>
      <? 
        if($_POST){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                      <th width="100">#</th>
                      <th width="200">Nombre</th>
                      <th width="250">Total</th>
                  </thead>
                  <tbody>
                    <? $n = 1;
                        foreach(getPreEjecuctado($id) as $cta){?>
                        <tr id="<?=$n?>">
                          <td><b><?=$cta->codigo?></b></td>
                          <td><b><?=trim($cta->nombre)?></b></td>
                          <td class="cuenta">
                              <input type="text" name="total_<?=$i.'_'.$n?>" id="total_<?=$i.'_'.$n?>" class="total_cta form-control text-right" style="width:250px" value="<?=$cta->monto?>" readonly>
                              <input type="hidden" name="idcta_<?=$i.'_'.$n?>" value="<?=$cta->id?>">
                          </td>
                        </tr>
                    <? $n++;}?>
                  </tbody>
                </table>
            </div>
          </div>
      </form>
      <? }/*
        }else{
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
	  <? }*/?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>