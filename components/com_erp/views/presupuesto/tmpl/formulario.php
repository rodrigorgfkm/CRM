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
    jQuery('#enviar').on('click', function(){
        jQuery('#form').trigger('submit');
    })
})
</script>

<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Formulario de Trabajo - Asignación de presupuestos</h3>
      </div>
      <? //if(!$_POST['form']){?>
      <div class="box-body">
      	<div class="row">
            <!--<div class="col-sm-12 col-md-6">
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
            </div>-->
            <div class="col-xs-12">
                <b>Filtrar: </b>
                <form action="" name="form2" id="form2" method="post">
                    <input type="text" name="codigo" id="codigo" class="form-control" style="width:auto; display: inline-block" placeholder="Buscar Cuenta" value="<?=JRequest::getVar('codigo','','post')?>" required>
                    <input type="hidden" name="posted" value="1">
                    <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i> Buscar Cuenta</button>
                    <a href="index.php?option=com_erp&view=presupuesto&layout=formulario" class="btn btn-info"> Limpiar</a>
                    <? if(isset($_POST['posted'])){?>
                    <button type="button" id="enviar" class="btn bg-olive pull-right btn-lg"><i class="fa fa-save"></i> Guardar Formulario de Trabajo</button>
                    <? }?>
                </form>
            </div>
        </div>
      </div>      
      <? if(isset($_POST['posted'])){?>
      <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
          <div class="box-body">                                  
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                      <th width="100">#</th>
                      <th width="200">Nombre</th>
                      <? for($i=1; $i<=12; $i++){?>                      
                          <th width="250" class="text-center"><?=mes($i)?></th>
                      <? }?>
                      <th width="250" class="text-center">Total</th><!--
                      <th width="250" class="text-center">Total Presupuestado</th>-->
                  </thead>
                  <tbody>
                    <?  $n = 1;                        
                        foreach(searchCtaPresupuesto($id) as $cta){
                        $sum = 0?>
                        <tr id="<?=$n?>">
                          <td><?=codigoRename($cta->codigo)?></td>
                          <td><?=trim($cta->nombre)?></td>
                          <? for($i=1; $i<=12; $i++){?>                  
                          <td>
                             <? $monto = getMontoPresupuestoBloque($cta->id, $id, $i);
                                $sum = $monto + $sum;
                              ?>
                              <input type="text" name="mes_<?=$i.'_'.$n?>" id="mes_<?=$i.'_'.$n?>" class="mes form-control validate[required] text-right" value="<?=$monto?>" style="width:100px">
                          </td>
                          <? }?>
                          <td class="cuenta">
                              <input type="text" name="total_<?=$n?>" id="total_<?=$i.'_'.$n?>" class="total_cta form-control text-right" style="width:100px" readonly value="<?= num2monto($sum)?>">
                              <input type="hidden" name="idcta_<?=$n?>" value="<?=$cta->id?>">
                          </td><!--
                          <td>
                              
                          </td>-->
                        </tr>
                    <? $n++;}?>
                  </tbody>
                </table>
                <? $n--;?>
                <input type="hidden" name="numero" value="<?=$n?>">
                <input type="hidden" name="formmul" value="1">
            </div>
          </div>
      </form>
      <? }elseif(isset($_POST['formmul'])){
		  newPresupuestoBloque($id);
		  ?>
	  <div class="box-body">
      	<h3>La asignación de presupeustos se realizó correctamente</h3>
        <p>
        	<a href="index.php?option=com_erp&view=presupuesto&layout=formulario" class="btn btn-info">
            	<em class="fa fa-arrow-left"></em>
                Volver al formulario de Trabajo
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