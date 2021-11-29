<?php defined('_JEXEC') or die;
if(validaAcceso('Crea Categoria Clientes')){
?>
<style>
@media
only screen and (max-width: 760px),
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
	tbody td{ min-height: 20px}
	td:nth-of-type(1):before { content: "Categoría: "; font-weight: bold}
	td:nth-of-type(2):before { content: "Sigla: "; font-weight: bold}
	td:nth-of-type(3):before { content: ""; }
	td:nth-of-type(3){ padding: 5px !important; height:35px}
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Categorías</h3>
		
        <!-- Algunos botones si son necesarios -->        
      </div>
      <div class="box-body">
      <table class="table table-bordered table-striped table_vam datatable">
        <thead>
          <tr>
            <th>Categorís</th>
            <th width="150">Aporte mensual Bs.</th>
            <th width="125">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getClientesCats() as $cat){?>
          <tr>
            <td><strong>
              <?=$cat->categoria?>
            </strong></td>
            <td class="text-right"><?=num2monto(getCategoriaAporte($cat->id))?></td>
            <td>
                <a href="index.php?option=com_erp&view=clientesadmcatap&layout=nuevo&id=<?=$cat->id?>" class="btn btn-success">
                	<i class="fa fa-pencil"></i>
                    Actualizar monto
                </a>
            </td>
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