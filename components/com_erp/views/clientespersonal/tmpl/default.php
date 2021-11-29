<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Lista Personal')){
	$cliente = JRequest::getVar('cliente', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
    $asociado = getCliente();
	?>
<script>
function enviarFiltro(){
    document.form.submit();
    }
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
        <h3 class="box-title">Personal de <?=$asociado->empresa?></h3>
		
      </div>
      
      <!-- Filtro de asociados -->
      <div class="box-body">
      	<a href="index.php?option=com_erp&view=clientespersonal&layout=nuevo&id=<?=JRequest::getVar('id', '', 'get')?>" class="btn btn-success pull-right" style="margin-left:5px">
        	<em class="fa fa-plus"></em>
            Registro de Personal
        </a>
        <a href="index.php?option=com_erp&view=clientes" class="btn btn-info pull-right">
        	<em class="fa fa-arrow-left"></em>
            Volver al listado de Asociados
        </a>
      </div>
      
      <!-- Lista del personal -->
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam datatable">
            <thead>
                <tr>
                    <th width="150"><span  data-toggle="tooltip" title="Haga clic para ordenar por Registro">Cargo</span></th>
                    <th><span  data-toggle="tooltip" title="Haga clic para ordenar por Cliente">Nombre y Apellidos</span></th>
                    <th width="200"><span  data-toggle="tooltip" title="Haga clic para ordenar por Correo-e">Correo-e</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Teléfono">Teléfono</span></th>
                    <th width="100"><span  data-toggle="tooltip" title="Haga clic para ordenar por Celular">Celular</span></th>
                    <th width="70">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <? 
				foreach(getPersonal() as $personal){
					?>
                <tr>
                    <td><?=$personal->cargo?></td>
                    <td><?=$personal->nombre.' '.$personal->apellido?></td>
                    <td>
					  <?
                      foreach(getClienteContacto($personal->id, 'e', 'p') as $com){
                          //getClientesC($personal->id, 'e', 'p')                             
						  echo $com->valor.'<br>';
						  }
					  ?>
                    </td>
                    <td>
				     <? foreach(getClienteContacto($personal->id, 't', 'p') as $com){
                          //getClientesC($personal->id, 'c', 'p')
                            $dato2 = explode('|',$com->valor);
                            if(empty($dato2)){
                                $telfc = $com->valor;
                                $extc = '';
                            }else{
                                $telfc = $dato2[0];
                                $extc =  $dato2[1];
                                if($dato2[1]!=''){
                                    $extc = ' ('.$dato2[1].')';                                
                                }
                            }
						  echo $telfc.$extc.'<br>';
				        }
					  ?>
                    </td>
                    <td>
					  <?
                      foreach(getClienteContacto($personal->id, 'c', 'p') as $com){
                          //getClientesC($personal->id, 't', 'p')
						  echo $com->valor.'<br>';
						  }
					  ?>
                   
                    <!--getClienteContacto($cliente->id_info, 't', 'c')
                    getClienteContacto($cliente->id_info, 'c', 'c')-->
                    </td>
                    <td>
                        <a href="index.php?option=com_erp&view=clientespersonal&layout=edita&id_cli=<?=$id?>&id=<?=$personal->id?>" data-toggle="tooltip" title="Editar datos del personal" class="btn btn-success" ><i class="fa fa-pencil"></i></a>
                        <a href="index.php?option=com_erp&view=clientespersonal&layout=elimina&id_cli=<?=$id?>&id=<?=$personal->id?>" data-toggle="tooltip" title="Eliminar Personal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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