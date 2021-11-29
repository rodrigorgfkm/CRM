<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes') or validaAcceso('Administracion Productos')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-user-secret"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nuevo Cliente Particular</h3>		
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Empresa <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                        <select name="id_empresa" id="id_empresa" class="select2 form-control validate[required]">
                            <option value="">Particular</option>
                            <? foreach(getEmpresasCliente() as $empresa){?>
                            <option value="<?=$empresa->id?>"><?=$empresa->empresa?></option>
                            <? }?>
                        </select>
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     NIT <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nit" id="nit" class="form-control validate[required]">
                 </div>
             </div>
            <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Nombre <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="nombre" id="nombre" class="form-control validate[required]">    
                 </div>
             </div>
            <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Apellido <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="apellido" id="apellido" class="form-control validate[required]">
                 </div>
             </div>          
            <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Correo Electrónico de Contacto <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="econtact[]" id="econtact" class="form-control validate[required]">
                 </div>
             </div>
            <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Telefono de Contacto
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="telfcontact[]" id="telfcontact" class="form-control">
                 </div>
             </div>          
            <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Celular de Contacto <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="celcontact[]" id="celcontact" class="form-control validate[required]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Dirección <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <input type="text" name="direccion" id="direccion" class="form-control validate[required]">
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2">
                     Detalle <i class="fa fa-asterisk text-danger"></i>
                 </label>
                 <div class="col-xs-12 col-sm-10">
                    <textarea name="detalle" id="detalle" class="form-control validate[required]"></textarea>
                 </div>
             </div>
              <div class="col-xs-12 col-sm-offset-2">
                  <button type="submit" class="btn btn-success btn-sm col-xs-12 col-sm-3"><i class="fa fa-floppy-o"></i> Guardar cliente</button>
              </div>
            </form>
            <? }else{
                $id = newCliente();
                $email =JRequest::getVar('econtact', '', 'post');
                $tel = JRequest::getVar('telfcontact', '', 'post');
                $cel = JRequest::getVar('celcontact', '', 'post');
                foreach ($email as $mail){
                    $newemail = $mail;
                }
                foreach ($tel as $telf){
                    $newtel = $telf;
                }
                foreach ($cel as $celu){
                    $newcel = $celu;
                }
                
                $nombre = JRequest::getVar('apellido', '', 'post').' '.JRequest::getVar('nombre', '', 'post');
                $fono = $newtel;
                $celular = $newcel;
                $nemail = $newemail?>
                <h3>El cliente fue creado correctamente</h3>
                <script>
                    window.parent.cargaCliente('<?=$id?>', '<?=$nombre?>', '<?=$fono?>', '<?=$celular?>', '<?=$nemail?>', '1');
                    window.parent.Shadowbox.close();
                </script>
                <?
                }?>
      </div>      
    </div>
  </section>
</div>
<? }else{vistaBloqueada(); }?>