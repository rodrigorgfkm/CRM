<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
	$session->clear('antiguedad');
	
	if($_POST){
	  if(JRequest::getVar('limpia', 0, 'post') == 0){
	    $session->set('asociado', JRequest::getVar('asociado', '', 'post'));
	    $session->set('registro', JRequest::getVar('registro', '', 'post'));
	    $session->set('id_categoria', JRequest::getVar('id_categoria', '', 'post'));
	    $session->set('id_cobrador', JRequest::getVar('id_cobrador', '', 'post'));
	    $session->set('id_mensajero', JRequest::getVar('id_mensajero', '', 'post'));
	    $session->set('id_tipo', JRequest::getVar('id_tipo', '', 'post'));
	    $session->set('id_estado', JRequest::getVar('id_estado', '', 'post'));
	    $session->set('id_actividad', JRequest::getVar('id_actividad', '', 'post'));
	  }else{
	    $session->clear('asociado');
	    $session->clear('registro');
	    $session->clear('id_categoria');
        $session->clear('id_cobrador');
	    $session->clear('id_mensajero');
	    $session->clear('id_tipo');
	    $session->clear('id_estado');
	    $session->clear('id_actividad');
	  }
	}	
	$asociado = $session->get('asociado');
	$registro = $session->get('registro');
	$id_categoria = $session->get('id_categoria');
	$id_cobrador = $session->get('id_cobrador');
	$id_mesajero = $session->get('id_mensajero');
	$id_tipo = $session->get('id_tipo');
	$id_estado = $session->get('id_estado');
	$id_actividad = $session->get('id_actividad');

?>
<script>
    function limpiaForm(){
        jQuery('#limpia').val(1);
        jQuery('#form').submit();
	}    
    function enviarFiltro(){
		document.filtro.submit();
		}
jQuery(document).on('ready',function(){
    jQuery('#reg').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#uas').removeClass('bg-orange');
            jQuery('#dc').removeClass('bg-orange');
            jQuery('#uas').addClass('bg-blue');
            jQuery('#dc').addClass('bg-blue');
            jQuery('.regisasoc').slideDown(500);
            jQuery('#uas').attr('data-sw',1);
            jQuery('#dc').attr('data-sw',1);
            jQuery('.reguas').slideUp(500);
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regisasoc').slideUp(500);
            jQuery(this).attr('data-sw',0);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#uas').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.reguas').slideDown(500);
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#reg').removeClass('bg-orange');
            jQuery('#dc').removeClass('bg-orange');
            jQuery('#reg').addClass('bg-blue');
            jQuery('#dc').addClass('bg-blue');
            jQuery('#reg').attr('data-sw',1);
            jQuery('#dc').attr('data-sw',1);
            jQuery('.regisasoc').slideUp(500);
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.reguas').slideUp(500);
            jQuery(this).attr('data-sw',1);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#dc').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.regdcon').slideDown(500);
            jQuery(this).removeClass('bg-blue');
            jQuery(this).addClass('bg-orange');
            jQuery('#reg').removeClass('bg-orange');
            jQuery('#uas').removeClass('bg-orange');
            jQuery('#reg').addClass('bg-blue');
            jQuery('#uas').addClass('bg-blue');
            jQuery('#reg').attr('data-sw',1);
            jQuery('#uas').attr('data-sw',1);
            jQuery('.reguas').slideUp(500);
            jQuery('.regisasoc').slideUp(500);
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regdcon').slideUp(500);
            jQuery(this).attr('data-sw',1);
            jQuery(this).removeClass('bg-orange');
            jQuery(this).addClass('bg-blue');
        }
    })
    jQuery('#eac').on('click',function(){
        if(jQuery(this).attr('data-sw')==1){
            jQuery('.regacec').show();
            jQuery(this).attr('data-sw',0);
        }else{
            jQuery('.regacec').hide();
            jQuery(this).attr('data-sw',1);
        }
    })
    jQuery('#m_reg').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.regis').trigger('click');
        }else{
            jQuery('.regis').removeAttr('checked');
        }        
    })
    jQuery('.regis').on('click', function(){
        if(jQuery('.regis:checked').length!=13){
            jQuery('#m_reg').removeAttr('checked');
        }else{
            jQuery('#m_reg').prop('checked', true);
        }
    })
    jQuery('#m_uas').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.uas').trigger('click');
        }else{
            jQuery('.uas').removeAttr('checked');            
        }        
    })
    jQuery('.uas').on('click', function(){
        if(jQuery('.uas:checked').length!=7){
            jQuery('#m_uas').removeAttr('checked');
        }else{
            jQuery('#m_uas').prop('checked', true);
        }
    })
    jQuery('#m_dc').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.contacto').trigger('click');
        }else{
            jQuery('.contacto').removeAttr('checked');
        }        
    })
    jQuery('.contacto').on('click', function(){
        if(jQuery('.contacto:checked').length!=3){
            jQuery('#m_dc').removeAttr('checked');
        }else{
            jQuery('#m_dc').prop('checked', true);
        }
    })
    /*jQuery('#m_eac').on('click', function(){
        if(jQuery(this).prop('checked')){
            jQuery('.encuesta').trigger('click');
        }else{
            jQuery('.encuesta').removeAttr('checked');
        }        
    })*/    
    jQuery('.labelcheck').on('click',function(){
        jQuery(this).children().trigger('click');
    })
})
</script>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
    tr:first-child td{
        width: 415px;
    }
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1023px)  {
    /* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
    /* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	tr { border: 1px solid #ccc; }
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		/*padding-left: 25% !important; */
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: ""; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: ""; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa  fa-file-text"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte Total de Asociados</h3>
      </div>      
      <div class="box-body">
        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h3 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <b>Cantidad Total de Asociados <?=getTotalAsociados(0,0,0)?></b> 
                    </a>
                  </h3>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,0,0)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,0,0)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,0,0)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,0,0)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,0,0)?></td>
                                </tr>
                            </tbody>               
                        </table>
                    </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h3 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <b>Cantidad Total De Asociados Con Facturación Masiva <?=getTotalAsociados(0,1)?></b>
                    </a>
                  </h3>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,1)?></td>
                                </tr>
                            </tbody>               
                        </table>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h3 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <b>Cantidad Total De Asociados Activos <?=getTotalAsociados(0,0,1)?></b>
                    </a>
                  </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,0,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,0,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,0,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,0,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,0,1)?></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-stripped">
                            <legend>Cantidad Total de Asociados Activos con Facturación Masiva <?=getTotalAsociados(0,1,1)?></legend>
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,1,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,1,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,1,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,1,1)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,1,1)?></td>
                                </tr>
                            </tbody>
                        </table>
                         
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                  <h3 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      <b>Cantidad Total De Asociados Con Estado de Baja <?=getTotalAsociados(0,0,2)?></b>
                    </a>
                  </h3>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body">
                        <table class="table table-bordered table-stripped">                            
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,0,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,0,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,0,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,0,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,0,2)?></td>
                                </tr>
                            </tbody>               
                        </table>
                        <table class="table table-bordered table-stripped">
                            <legend>Cantidad Total de Asociados Con Estado de Baja con Facturación Masiva <?=getTotalAsociados(0,1,2)?></legend>
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,1,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,1,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,1,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,1,2)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,1,2)?></td>
                                </tr>
                            </tbody>               
                        </table>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFive">
                  <h3 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      <b>Cantidad Total De Asociados Suspendidos <?=getTotalAsociados(0,0,3)?></b>
                    </a>
                  </h3>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                  <div class="panel-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,0,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,0,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,0,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,0,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,0,3)?></td>
                                </tr>
                            </tbody>               
                        </table>
                        <table class="table table-bordered table-stripped">
                            <legend>Cantidad Total de Asociados Suspendidos con Facturación Masiva <?=getTotalAsociados(0,1,3)?></legend>
                            <thead>
                                <th>Categoría</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categoría 1</td>
                                    <td><?=getTotalAsociados(1,1,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 2</td>
                                    <td><?=getTotalAsociados(2,1,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 3</td>
                                    <td><?=getTotalAsociados(3,1,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 4</td>
                                    <td><?=getTotalAsociados(4,1,3)?></td>
                                </tr>
                                <tr>
                                    <td>Categoría 5</td>
                                    <td><?=getTotalAsociados(5,1,3)?></td>
                                </tr>
                            </tbody>               
                        </table>
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>