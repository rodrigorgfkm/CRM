<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Validar Clientes')){?>
<script>
function confirma(id){
	jQuery('.modal-title').html('<i class="icon-ban-circle"></i> Validar Asociado');
	jQuery('.modal-body').html('<p>&iquest;Esta seguro de validar el registro del asociado seleccionado?</p>');
	jQuery('.modal-footer').html('<a class="btn btn-success" onclick="envia()"><em class="fa fa-save"></em> Confirmar</a> <button type="button" class="btn btn-info pull-left" data-dismiss="modal"><em class="fa fa-sign-out"></em> Cerrar</button>');
	jQuery('#ventanaModal').trigger('click');
	}
function envia(){
	jQuery('#ventanaModal').trigger('click');
	jQuery('#form').submit();
	}
</script>
<?
$cliente = getCliente();?>

<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-briefcase"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Ver detalle de registro de "<?=$cliente->empresa?>"</h3>
      </div>
      
        <? if(!$_POST){?>
          <form method="post" enctype="multipart/form-data" name="form" id="form" class="form-horizontal" role="form">            
           <div class="box-body">
            <? if($cliente->registro != ''){?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Registro
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->registro?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Libro/Tomo/Part
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->libro.'/'.$cliente->tomo.'/'.$cliente->part?>
                </div>
            </div>
            <? }?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Empresa
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->empresa?>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                    Tipo de Sociedad
                </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->sociedad?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    NIT
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->nit?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Categoría
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->id_categoria?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Capital
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->capital?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Matrícula RECSA
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->matr_recsa?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Resol. RECSA
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->resol_recsa?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Testimonio
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->testimonio?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Poder
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->poder?>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                    Modo de envío
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->id_modo_envio?>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                   Cobrador
              </label>
                <div class="col-xs-12 col-sm-10">
                    a
              </div>
            </div>
            <div class="form-group">
                <label for="tipo" class="col-xs-12 col-sm-2">
                   Mensajería
              </label>
                <div class="col-xs-12 col-sm-10">
                    a
              </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Ataché
                </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->atache?>
                </div>
            </div>
          
            <h4 class="text-primary">Datos de Contacto</h4>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Nombre
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->nombre?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Apellido
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->apellido?>
                </div>
            </div>
            <? foreach(getCampos(1) as $campo){?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    <?=$campo->tipo?>
                </label>
                <div class="col-xs-12 col-sm-10">
                    <?=getCampoValor($campo->id, $cliente->id_info)?>
                </div>
            </div>
          <? }?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Dirección
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->direccion?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Departamento
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->id_estado?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Ciudad
              </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->ciudad?>
                </div>
            </div>
            
             <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Detalle
                </label>
                <div class="col-xs-12 col-sm-10">
                    <?=$cliente->detalle?>
                </div>
            </div>
            <?
            if($cliente->registro == ''){
			?>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Registro
                </label>
                <div class="col-xs-12 col-sm-10">
                  <input type="text" name="registro" id="registro" class="form-control validate[required]" placeholder="Nro. de registro">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-xs-12 col-sm-2">
                    Libro/Tomo/Part 
                </label>
                <div class="col-xs-12 col-sm-3">
                  <input type="text" name="libro" id="libro" class="form-control validate[required]" placeholder="Libro">
                </div>
                <div class="col-xs-12 col-sm-3">
                  <input type="text" name="tomo" id="tomo" class="form-control validate[required]" placeholder="Tomo">
                </div>
                <div class="col-xs-12 col-sm-4">
                  <input type="text" name="part" id="part" class="form-control validate[required]" placeholder="Part">
                </div>
            </div>
            <? }?>
        </div>
        
        <div class="box-footer">
        	<a href="index.php?option=com_erp&view=clientes" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a>
            <?
            if($cliente->registro == ''){
			?>
            <button type="button" onClick="confirma(<?=$cliente->id?>)" class="btn btn-success pull-right"><em class="fa fa-check"></em> Validar registro del Asociado</button>
            <? }?>
        </div>
        
      </form>
            <? }else{
                validaCliente();?>
              <div class="box-body">
                <h3>El asociado fue validado correctamente</h3>
                <p><a href="index.php?option=com_erp&view=clientes" class="btn btn-info"><em class="fa fa-arrow-left"></em> Ir a la lista de Asociados</a></p>
              </div>
                <?
                                }?>
    </div>
  </section>
</div>              
 <? }else{
vistaBloqueada();
}?>