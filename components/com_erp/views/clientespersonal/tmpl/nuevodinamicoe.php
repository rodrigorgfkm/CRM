<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-dedent"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Empresa</h3>		
        <!-- Algunos botones si son necesarios -->
        <div class="text-right">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
          </div>
        </div>
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Empresa <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="empresa" id="empresa" class="form-control validate[required]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Empresa <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="nit" id="nit" class="form-control validate[required]">
                 </div>
             </div>
          <? foreach(getCampos(1) as $campo){?>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     <?=$campo->tipo?> <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control validate[required]">
                 </div>
             </div>
          <? }?>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Dirección <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="direccion" id="direccion" class="form-control validate[required]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Estado <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <select name="id_estado" id="id_estado" class="select2 form-control validate[required]">
                        <? foreach(getPaises() as $pais){?>
                            <option value=""></option>
                            <optgroup label="<?=$pais->pais?>">
                            <? foreach(getEstados($pais->id) as $e){?>
                                <option value="<?=$e->id?>"><?=$e->estado?></option>
                                <? }
                                }?>
                      </select>
                 </div>                 
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Ciudad <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="localidad" id="localidad" class="form-control validate[required]">
                 </div>                 
             </div>
             <h4 class="text-primary">Datos de Contacto</h4>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Nombre <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="nombre" id="nombre" class="form-control validate[required]">
                 </div>                 
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Apellido <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="apellido" id="apellido" class="form-control validate[required]">
                 </div>                 
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Cargo <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="cargo" id="cargo" class="form-control validate[required]">
                 </div>                 
             </div>
          <? foreach(getCampos() as $campo){?>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     <?=$campo->tipo?> <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <input type="text" name="id_<?=$campo->id?>" id="id_<?=$campo->id?>" class="form-control validate[required]">
                 </div>                 
             </div>
          <? }?>
             <div class="form-group">
                 <label for="" class="col-xs-10 col-sm-2">
                     Detalle <i class="fa fa-asterisk text-red"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                     <textarea name="detalle" id="detalle" class="form-control validate[required]"></textarea>
                 </div>                 
             </div>
             <div class="col-xs-12 col-sm-offset-2">
                 <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar cliente</a>
             </div>              
            </form>
            <? }else{
                $id = newCliente(empresa);
                $nombre = JRequest::getVar('empresa', '', 'post');
                $fono = JRequest::getVar('id_1', '', 'post');
                $celular = JRequest::getVar('id_2', '', 'post');
                $email = JRequest::getVar('id_3', '', 'post');?>
                <h3>El cliente fue creado correctamente</h3>
                <script>
                    window.parent.cargaCliente('<?=$id?>', '<?=$nombre?>', '<?=$fono?>', 'e');
                    window.parent.Shadowbox.close();
                </script>
                <?
                }?>
      </div>      
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>