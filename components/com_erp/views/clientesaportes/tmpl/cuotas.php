<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes') or validaAcceso("Creación de facturas")){
	$estado = JRequest::getVar('estado', '2', 'post');
	$session = JFactory::getSession();
	$ext = $session->get('extension');
	
	$asociado = JRequest::getVar('asociado', '', 'post');
	$registro = JRequest::getVar('registro', '', 'post');
	$id_categoria = JRequest::getVar('id_categoria', '', 'post');
	
	$lnk = JRequest::getVar('lnk', '', 'get');
	if($lnk != '')
		$view = '&layout=gestioncuotas';
	?>

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
	td:nth-of-type(1):before { content: "Cliente:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Correo-e:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Teléfono:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Celular:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Vigente:"; font-weight: bold}
	td:nth-of-type(6):before { content: "Acciones:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estado de cuenta</h3>
		
      </div>
      <div class="box-body">
       <? if(JRequest::getVar('tmpl')!='component'){?>
      	<a class="btn btn-info pull-right" href="index.php?option=com_erp&view=clientesaportes<?=$view?>">
        	<i class="fa fa-arrow-left"></i> 
            Volver al listado de asociados
        </a>
        <? }?>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="60"><span  data-toggle="tooltip" title="Haga clic para ordenar por Año">Año</span></th>
                    <th>Cuotas</th>
            </thead>
            <tbody>
                <? 
				foreach(getSociadoAportesA() as $anio){
                ?>
                <tr>
                    <td><?=$anio->anio?></td>
                    <td>
                        <?
                        foreach(getSociadoAportesM($anio->anio) as $mes){?>
                        <div class="col-xs-12 col-sm-1" style="padding:0 5px">
                            <button class="btn btn-info btn-xs btn-block" style="cursor:default">
                                <?=mes($mes->mes)?>
                                <br>
                                <em>(Bs.- <?=$mes->monto?>)</em>
                            </button>
                        </div>
						<? }
						?>
                    </td>
                </tr>
                <? 
				}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>