<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Edita')){
	$cuenta = getCNTcuenta();
    /*echo '<pre>';
    print_r($cuenta);
    echo '</pre>';*/
?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listacuentas&tmpl=component&id='+id, width:800, height:450, player: "iframe"}); return false;
	}
function recibe(id, nombre, codigo, codigo_sug){
	jQuery('#id_padre_nombre').html(nombre);
	jQuery('#id_padre').val(id);
	jQuery('#codigo_padre').html(codigo);
	jQuery('#codigopadre').val(codigo);
	jQuery('#codigo').val(codigo_sug);
    var num = codigo;
    var codepadre;
    while(num>0){        
        codepadre = parseInt(num%10);
        num = parseInt(num/10);
    }
    if(codepadre == 3 || codepadre == 4){
        jQuery('.presupuesto').show(500);
        jQuery('.eging').show(500);
        jQuery('#id_unidadnegocio').removeAttr('disabled');
    }else{
        jQuery('.presupuesto').hide(500);
        jQuery('.eging').hide(500);
        jQuery('#id_unidadnegocio').attr('disabled','disabled');
    }
}
</script>
<?
    $lim_nom = 50;
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-edit"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar cuenta <?=$cuenta->nombre?></h3>
      </div>
	  <?php if(!$_POST){?>
      <form method="post" name="form" id="form" class="form-horizontal">
        <div class="box-body">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Nombre de la cuenta <i class="fa fa-asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">
                   <input name="nombre" type="text" class="form-control validate[required, maxSize[<?=$lim_nom?>]] focused" id="nombre" value="<?=$cuenta->nombre?>">
                   <input name="id" type="hidden" id="id" value="<?=$cuenta->id?>">
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Cuenta padre
               </label>
               <div class="col-xs-12 col-sm-10">
                  <span class="form-control uneditable-input" id="id_padre_nombre" style="cursor:not-allowed">
                      <?=$cuenta->p_nombre?>
                  </span>
               </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Código
               </label>
               <div class="col-xs-12 col-sm-10">
                  <span class="form-control uneditable-input" id="id_padre_nombre" style="cursor:not-allowed">
                      <?=$cuenta->codigo?>
                  </span>
               </div>
           </div>
           <div class="form-group presupuesto" style="display:none">
             <label for="" class="col-xs-12 col-sm-2">
                Cuenta de Presupuesto <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                <input name="presupuesto" type="checkbox" class="form-control validate[required, maxSize[<?=$lim_nom?>]]" data-toggle="toggle">                 
             </div>
         </div>
        </div>
        <div class="box-footer">
          <a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Cuentas</a>
          <button type="reset" class="btn btn-warning"><em class="fa fa-refresh"></em> Reestablecer datos</button>
          <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Editar Cuenta</button>
        </div>
    	</form>
        <?php }else{?>
        <div class="box-body">
        <?
            $val = editCNTcuenta();

            if($val == 1){
            ?>
            <h3>La cuenta fue editada correctamente</h3>
            <p><a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-success">Volver</a></p>
            <?
            }else{?>
            <h3>Ya existe una cuenta con el mismo código, intente nuevamente</h3>
            <p><a onclick="javascript:history.back()" class="btn btn-success">Volver</a></p>
            <? }?>
        </div>
        <? }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>