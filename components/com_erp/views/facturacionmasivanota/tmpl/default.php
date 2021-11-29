<?php defined('_JEXEC') or die;?>
<?// if(validaAcceso('Administrador')){?>
<?
$user =& JFactory::getUser();
$empresa = getEmpresa();
$usuario = getUsuario($user->get('id'));
?>
<? if($usuario->group_id == 8){?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Texto al Notas Al Debito</h3>
      </div>
      <div class="box-body">
    <?
        $lim_emp = 50;
        $lim_nit = 20;
        $lim_sig = 15;
    ?>
      <div>
          <a href="index.php?option=com_erp&view=facturacionmasivanota&layout=nuevo" class="btn bg-purple pull-right"><i class="fa fa-plus"></i> Nuevo Texto</a>
      </div>
      <table class="table table-striped table-bordered">
       <thead>
           <th>Estado</th>
           <th>Texto</th>
           <th width="150">Acciones</th>
       </thead>
        <tbody>
            <? foreach(gettextoNotasD() as $notas){
                if($notas->estado==1){
                    $boton = 'success';
                    $icono = 'star';
                }else{
                    $boton = 'default';
                    $icono = 'star-o';
                }
            ?>
                <tr>
                    <td><button type="button" class="btn btn-sm btn-<?=$boton?>"><i class="fa fa-<?=$icono?>"></i></button></td>
                    <td><?=$notas->texto?></td>
                    <td>
                        <a href="index.php?option=com_erp&view=facturacionmasivanota&layout=edita&id=<?=$notas->id?>" class="btn btn-success"><i class="fa fa-edit"></i> Editar</a>
                        <a href="index.php?option=com_erp&view=facturacionmasivanota&layout=elimina&id=<?=$notas->id?>" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
            <? }?>
        </tbody>
      </table>
      <div>
          <button type="button" class="btn btn-xs btn-success"><i class="fa fa-star"></i></button> <b>Texto Habilidato</b> <br>
          <button type="button" class="btn btn-xs btn-default"><i class="fa fa-star-o"></i></button> <b>Texto Deshabilitado</b>
      </div>
    <? 
    }else{?>
		<h3>No tiene privilegios para ver este contenido</h3>
	<? }?>
      </div>
    </div>
  </section>
</div>
<?// }else{vistaBloqueada(); }?>