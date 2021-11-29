<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Administración Facturación')){?>
<style>
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    /* Force table to not be like tables anymore */
    .thumbnail{
        width: 100px;
    }
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
		padding-left: 27% !important; 
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
	td:nth-of-type(2):before { content: "Actividad:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Acciones:"; font-weight: bold}	
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-puzzle-piece"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Actividades</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered datatable" id="tabladinamica">
            <thead>
              <tr>
                <th class="table_checkbox">N&ordm;</th>
                <th>Actividad</th>
                <th width="100">Acciones</th>
              </tr>                
            </thead>
            <tbody>
              <? $n = 0;
              foreach(getRubros() as $rubro){
                  $n++;?>
              <tr>
                <td><?=$n?></td>
                <td><strong>
                  <?=$rubro->rubro?>
                </strong></td>
                <td>
                  <a href="index.php?option=com_erp&view=facturacionrubro&layout=edita&id=<?=$rubro->id?>" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                  <a href="index.php?option=com_erp&view=facturacionrubro&layout=elimina&id=<?=$rubro->id?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <? }?>
            </tbody>
          </table>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>