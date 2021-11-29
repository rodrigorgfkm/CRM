<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Nuevo')){
	$id = JRequest::getVar('id', '', 'get');
	?>
<script>
function popup(id){
	Shadowbox.open({ content: 'index.php?option=com_erp&view=contaadmcuentas&layout=listacuentas&tmpl=component&id=<?=$id?>', width:800, height:450, player: "iframe"}); return false;
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
        //jQuery('.presupuesto').show(500);
        jQuery('.eging').show(500);
        jQuery('#id_unidadnegocio').removeAttr('disabled');
    }else{
        //jQuery('.presupuesto').hide(500);
        jQuery('.eging').hide(500);
        jQuery('#id_unidadnegocio').attr('disabled','disabled');
    }
}
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-plus"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Crear Cuenta</h3>
      </div>
	  <?php if(!$_POST){?>
      <form method="post" name="form" id="form" class="form-horizontal" role="form">
      	<div class="box-body">
          <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Cuenta padre <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                 <span class="form-control uneditable-input" id="id_padre_nombre" onClick="popup(this.id)" style="cursor:pointer"></span>
                 <input type="hidden" name="id_padre" id="id_padre">
             </div>
         </div>
          <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Nombre del auxiliar <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">
                 <input name="nombre" type="text" class="form-control validate[required]" id="focusedInput">
                 <input type="hidden" name="id_gestion" id="id_gestion" value="<?=JRequest::getVar('id', '', 'get')?>">
             </div>
         </div>
         <div class="form-group eging">
             <label for="" class="col-xs-12 col-sm-2">
                 Unidad de Negocio <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">                
                <select name="id_unidadnegocio" id="id_unidadnegocio" class="form-control"style="width:auto">
                   <option value="">Seleccionar Unidad de Negocio</option>
                    <? foreach (getUnidadesDeNegocio(true) as $unidad){
                        echo '<option value="'.$unidad->id.'">'.$unidad->unidad_negocio.'</option>';
                    }                            
                    ?>
                </select>
             </div>
         </div>
        </div>
        <div class="box-footer">
          <a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Cuentas</a>
          <button type="reset" class="btn btn-warning"><em class="fa fa-refresh"></em> Reestablecer datos</button>
          <button type="submit" class="btn btn-success pull-right"><em class="fa fa-floppy-o"></em> Crear Auxiliar</button>
        </div>
    </form>
    <?php }else{
        $val = newCNTcuenta(1);

        if($val == 1){
        ?>
        <h3>La cuenta fue creada correctamente</h3>
        <p><a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-success">Volver</a></p>
        <?
        }else{?>
        <h3>Ya existe una cuenta con el mismo código, intente nuevamente</h3>
        <p><a onclick="javascript:history.back()" class="btn btn-success">Volver</a></p>
        <? }
    }?>
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>