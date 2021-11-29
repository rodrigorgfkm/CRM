<?php defined('_JEXEC') or die;
if(validaAcceso('Cuentas Contables Edita')){
?>
<script>
function asigna(nombre, id){
	jQuery('#id_padre_nombre').html(nombre);
	jQuery('#id_padre').val(id);
	ocultaCuentas();
	}
function saveNew(){
	jQuery('#nuevo').val(1)
	jQuery('.btn-success').trigger('click');
	}
function muestraCuentas(){
	jQuery('.id_padre').fadeIn();
	}
function ocultaCuentas(){
	jQuery('.id_padre').fadeOut();
	}
</script>
<? $cuenta = getCNTcuenta();?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-editar"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Editar Cuenta</h3>
      </div>
      <div class="box-body">
        <?php if(!$_POST){?>
          <form class="form-horizontal" method="post" name="form" id="form" class="form-horizontal" role="form">
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Nombre de la cuenta<i class="fa-fa asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">
                   <input name="nombre" type="text" class="form-control validate[required]"value="<?=$cuenta->nombre?>">
               </div>
           </div>
           <div class="form-group">
             <label for="" class="col-xs-12 col-sm-2">
                 Unidad de Negocio <i class="fa fa-asterisk text-red"></i>
             </label>
             <div class="col-xs-12 col-sm-10">                
                <select name="unidad" id="unidad" class="form-control"style="width:auto">
                   <option value="">Seleccionar Unidad de Negocio</option>
                    <? foreach (getUnidadesDeNegocio(true) as $unidad){
                        $selected = $cuenta->id == JRequest::getVar('unidad','','post')?'selected':'';
                        echo '<option value="'.$unidad->id.'" '.$selected.'>'.$unidad->unidad_negocio.'</option>';
                    }                            
                    ?>
                </select>
             </div>
           </div>
           <div class="form-group">
               <label for="" class="col-xs-12 col-sm-2">
                   Cuenta Padre<i class="fa-fa asterisk text-red"></i>
               </label>
               <div class="col-xs-12 col-sm-10">                  
                  <span class="form-control uneditable-input" id="id_padre_nombre" onClick="muestraCuentas()"><?=$cuenta->p_nombre?></span>
                  <input type="hidden" name="id_padre" id="id_padre" class="form-control" value="<?=$cuenta->p_id?>">
                  <div class="id_padre" style="height:0px; overflow:visible; position:absolute; display:none">
                    <div style="border:1px solid #ccc; border-radius:5px; margin-top:5px; padding:10px; background:#FFF; width:600px">
                      <table id="tabladinamica">
                          <thead>
                              <tr>
                                  <th>N&ordm;asd</th>
                                  <th>Código</th>
                                  <th>Cuenta</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              <? cuentas(0, 0)?>
                          </tbody>
                      </table>
                      <div><a onClick="ocultaCuentas()" class="btn btn-block btn-success">Cerrar</a></div>
                    </div>
                  </div>
               </div>
           </div>
           <div class="col-xs-12 col-sm-offset-2">
               <button class="btn btn-success btn-sm col-xs-12 col-sm-3" type="submit"><i class="fa fa-floppy-o"></i> Guardar</button>
           </div>
        </form>
        <?php }else{
            cuenta_edita();
        ?>
          <h3>La cuenta fue creada correctamente</h3>
          <p><a href="index.php?option=com_erp&view=contaadmcuentas" class="btn btn-success">Volver</a></p>
        <? }?>
      </div>      
    </div>
  </section>
</div>
<? }else{
vistaBloqueada();
}?>
