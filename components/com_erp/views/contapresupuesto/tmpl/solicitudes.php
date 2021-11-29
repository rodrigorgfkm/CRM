<?php defined('_JEXEC') or die;
$session = JFactory::getSession();

if(JRequest::getVar('l', '', 'get') == 1){
	$session->clear('filtro');
	$session->clear('fecha_ini');
	$session->clear('fecha_fin');
	$session->clear('tipo');
	}else{
	if($_POST){
		$session->set('filtro', JRequest::getVar('filtro', '', 'post'));
		$session->set('fecha_ini', JRequest::getVar('fecha_ini', '', 'post'));
		$session->set('fecha_fin', JRequest::getVar('fecha_fin', '', 'post'));
		$session->set('tipo', JRequest::getVar('tipo', '', 'post'));
		}
	}

$pag = JRequest::getVar('p', 1, 'get');

if($session->get('tipo') != '' || $session->get('fecha_ini') != '' || $session->get('fecha_fin') != ''){
	$style = 'display: block';
	$class_btn = 'btn-default';
	$class_ico = 'fa fa-arrow-circle-up';
	}else{
	$style = 'display: none';
	$class_btn = '';
	$class_ico = 'fa fa-arrow-circle-down';
	}
?>
<script>
var boton = 0;
function muestra(){
	jQuery('#herramientas').slideToggle();
	if(boton == 0){
		boton = 1;
		jQuery('#mas').addClass('btn-default');
		jQuery('#mas i').removeClass('icon-circle-arrow-down').addClass('icon-circle-arrow-up icon-white')
		}else{
		boton = 0;
		jQuery('#mas').removeClass('btn-default');
		jQuery('#mas i').removeClass('icon-circle-arrow-up icon-white').addClass('icon-circle-arrow-down')
		}
	}
function limpiaForm(){
	jQuery('#form').attr('action', 'index.php?option=com_erp&view=contacomprobantes&l=1');
	jQuery('#form').submit();
	}
// Setter
jQuery(function () {
	jQuery.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional["es"]);
	jQuery("#fecha_ini").datepicker({
		dateFormat: "yy-mm-dd"
	});
	jQuery("#fecha_fin").datepicker({
		dateFormat: "yy-mm-dd"
	});
});
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Solicitudes de presupuesto</h3>        
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered">
          <thead>
                <tr>
                  <th width="15">Nro.</th>
                  <th width="100">Codigo</th>
                  <th>Cuenta</th>
                  <th width="150">Usuario</th>
                  <th width="150">Detalle</th>
                  <th width="150">Monto</th>
                  <th width="120">Fecha</th>
                  <th width="50">Acciones</th>
                </tr>
          </thead>
          <tbody>
          <?php 
		  $n = 0;
          foreach(getCNTsolicitudes() as $sol){
			  $n++;
                ?>
                <tr>
                  <td><?=$n?></td>
                  <td><?=$sol->codigo?></td>
                  <td><?=$sol->cuenta?></td>
                  <td><?=$sol->usuario?></td>
                  <td><?=$sol->detalle?></td>
                  <td class="text-right"><?=num2monto($sol->monto)?></td>
                  <td><?=fecha($sol->fecha)?></td>
                  <td>
                    <a href="index.php?option=com_erp&view=contapresupuesto&layout=solicitud&id=<?=$sol->id?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                  </td>
                </tr>
                <?php }?>
          </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<style>
#fecha_ini, #fecha_fin{
      width:80px;
      }
    .input-append{
      display: inline;
      }
</style>