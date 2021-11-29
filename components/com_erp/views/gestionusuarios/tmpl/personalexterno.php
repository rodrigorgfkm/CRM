<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Lista Personal')){
	$cliente = JRequest::getVar('cliente', '', 'post');
	$id = JRequest::getVar('id', '', 'get');
    $asociado = getCliente();
	?>
<script>
function enviarFiltro(){
    //document.form.submit();
    }
    jQuery(document).on('ready',function(){
        
    })    
function confirma(id){
	jQuery('.modal-title').html('<i class="icon-ban-circle"></i> ¿Eliminar Este Personal?');
	jQuery('.modal-body').html('<form action="index.php?option=com_erp&view=gestionusuarios&layout=eliminapersonal&tmpl=blank" method="POST">'+
                               '<input type="hidden" name="id" value="'+id+'">'+
                               '<div class="col-xs-12"><button type="button" id="data" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cancelar</button>'+
                               '<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Confirmar</button></div>'+
                               '</form>');
	jQuery('.modal-footer').html('');
	jQuery('#ventanaModal').trigger('click');
}
</script>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
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
		padding-left: 40% !important; 
	}
	.table>tbody>tr>td{
        overflow-x: scroll;
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
	td:nth-of-type(1):before { content: "Usuario: "; font-weight: bold; text-align: left;}
	td:nth-of-type(2):before { content: "Cargo: "; font-weight: bold; text-align: left;}
	td:nth-of-type(3):before { content: "Acciones: "; font-weight: bold; text-align: left;}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Personal Externo</h3>
      </div>      
      <!-- Filtro de asociados -->
      <div class="box-body">
      </div>      
      <!-- Lista del personal -->
      <div class="box-body">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered table-striped table_vam datatable">
                <thead>
                    <th></th>
                    <th>Usuario</th>
                    <th>Cargo</th>
                    <th width="60">Acciones</th>
                </thead>
                <tbody>
                   <? foreach (getUsuariosext() as $usuario){
                    if($usuario->habilitado != 0){
					   $icon = '';
					   $btn = 'btn btn-primary';
					   $title = 'Bloquear usuario';
                       $estado= 0;
					}else{
					   $icon = '-o';
					   $btn = 'btn btn-danger';
					   $title = 'Habilitar usuario';
                       $estado= 1;
					}
					?>
                    <tr>
                        <td><a href="index.php?option=com_erp&view=gestionusuarios&layout=publicaext&estado=<?=$estado?>&id=<?=$usuario->id?>" class="<?=$btn?>" title="<?=$title?>"><i class="fa fa-star<?=$icon?>"></i></a></td>
                        <td><?=$usuario->nombre?></td>
                        <td><? switch($usuario->tipo){
                            case 'm':
                                $cargo = "Mensajero";
                                break;
                            case 'c':
                                $cargo = "Cobrador";
                                break;
                            case 'a':
                                $cargo = "Ataché";
                                break;
                        }
                        echo $cargo;    
                        ?></td>
                        <td>
                            <a href="index.php?option=com_erp&view=gestionusuarios&layout=editapersonal&id=<?=$usuario->id?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger" onclick="confirma(<?=$usuario->id?>)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                   <? }?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>



