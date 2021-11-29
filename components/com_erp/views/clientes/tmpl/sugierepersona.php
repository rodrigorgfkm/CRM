<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Registro de Clientes')){?>
<!-- INICIO -->
<style>
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
	td:nth-of-type(1):before { content: "Nº:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Nombre:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Celular:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Correo-e:"; font-weight: bold}
	td:nth-of-type(5):before { content: "Dir:"; font-weight: bold}
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Clientes</h3>
		
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
        <table class="table table-bordered table-striped table_vam" id="tabladinamica">
            <thead>
                <tr>
                    <th width="20">N&ordm;</th>
                    <th>Nombre</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClientesPSugerido() as $cliente){
                      if($cliente->vigente == 1){
                          $n++;
                          $com = getClientesCom($cliente->id);
                      ?>
                <tr>
                    <td><?=$n?></td>
                    <td><a style="cursor:pointer" href="index.php?option=com_erp&view=clientes&layout=edita&id=<?=$cliente->id?>"><?=$cliente->apellido.' '.$cliente->nombre?></a></td>
                    <td><?=getClienteCelular($cliente->id)?></td>
                    <td><?=getClienteEmail($cliente->id)?></td>
                    <td><?=$cliente->direccion?></td>
                </tr>
                <? }}?>
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<?
}else{
    vistaBloqueada();
}?>