<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Lista Personal')){
	$cliente = JRequest::getVar('cliente', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
    $asociado = getCliente();
?>
<script>

</script>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
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
		padding-left: 25% !important; 
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
	td:nth-of-type(1):before { content: "Estado: "; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Usuario: "; font-weight: bold}
	td:nth-of-type(3):before { content: "Motivo: "; font-weight: bold}
	td:nth-of-type(4):before { content: "Fecha: "; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-archive"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Historial de Cambios de Estado de <?=$asociado->empresa?></h3>
		
      </div>
      
      <!-- Filtro de asociados -->
      <div class="box-body">
      	<a href="index.php?option=com_erp&view=clientes&layout=cambioestado" class="btn btn-success pull-right" style="margin-left:5px">
        	<em class="fa fa-arrow-right"></em>
            Ir a Cambio de Estados
        </a>
        <a href="index.php?option=com_erp&view=clientes" class="btn btn-info pull-right">
        	<em class="fa fa-arrow-right"></em>
            Ir a al listado de Asociados
        </a>
      </div>
      <!-- Lista del personal -->
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <th width="100">Estado</th>
                <th width="200">Usuario que Realizó el Cambio</th>
                <th>Motivo</th>
                <th width="100">Fecha del Cambio</th>
            </thead>
            <tbody>
                <? foreach(getHistorialCambios() as $cambio){?>
                    <tr>
                        <td><?=$cambio->estado?></td>
                        <td><?=$cambio->usuario?></td>
                        <td><?=$cambio->motivo?></td>
                        <td><?=fecha($cambio->fecha)?></td>
                    </tr>
                <? }?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>