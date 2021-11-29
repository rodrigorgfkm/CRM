<?php defined('_JEXEC') or die;
if(validaAcceso('Administrador')){
	scriptCSS();
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
	tbody td{ min-height: 20px}
	td:nth-of-type(1):before { content: "Nombre: "; font-weight: bold}
	td:nth-of-type(2):before { content: "Usuario: "; font-weight: bold}
	td:nth-of-type(3):before { content: "Correo-e: "; font-weight: bold}
	td:nth-of-type(4) { display: none}
	td:nth-of-type(5):before { content: ""; }
	td:nth-of-type(5){ padding: 5px !important; height:35px}
}
</style>
<script>
jQuery(document).on('ready',function(){
    jQuery('body').on('change','.sucursal', function(){        
        jQuery.ajax({
                    url:"index.php?option=com_erp&view=gestionusuarios&layout=cambiasucursal&tmpl=blank",
                    type:"POST",
                    data:{id_usuario:jQuery(this).siblings('input').attr('id'), id_sucursal: jQuery(this).val()}
                    })
        jQuery(this).siblings('span').show(500);
        jQuery(this).siblings('span').hide(3000);
    })
})
</script>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Usuarios</h3>
      </div>
      <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo-e</th>
            <th>Sucursales</th>
            <th width="220">Suc. Predeterminado</th>
            <th width="120">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getUsuarios() as $usuario){
				if($usuario->block == 0){
					$estado = '';
					$btn = 'btn btn-warning';
					$title = 'Bloquear usuario';
					}else{
					$estado = 'close';
					$btn = 'btn btn-danger';
					$title = 'Habilitar usuario';
					}
					?>
          <tr>
            <td><?=$usuario->name?></td>
            <td><?=$usuario->username?></td>
            <td><?=$usuario->email?></td>
            <td style="font-size:11px">
            	<? foreach(getUsuarioSucursal($usuario->id) as $suc){
					echo '- '.$suc->nombre.' ('.$suc->departamento.')<br>';
					}?>
            </td>
            <td>
              <? if(count(getUsuarioSucursal($usuario->id))!=0){?>
               <select name="" class="form-control sucursal" style="width:100%;">
                    <? foreach(getUsuarioSucursal($usuario->id) as $sucursal){
					   if($sucursal->predeterminado==1){?>
					       <option value="<?=$sucursal->id?>" selected><?=$sucursal->nombre.' ('.$sucursal->departamento.')'?></option>
					<? }else{?>
                           <option value="<?=$sucursal->id?>"><?=$sucursal->nombre.' ('.$sucursal->departamento.')'?></option>
                    <? }
                    }
                        ?>
               </select>
                    <span class="text-success" style="display:none">Se cambio de Sucursal Predeterminada</span>
                    <input type="hidden" id="<?=$usuario->id?>">
               <? }?>
            </td>
            <td>
              <a href="index.php?option=com_erp&view=gestionusuarios&layout=sucursales&id=<?=$usuario->id?>" class="btn btn-info">
              	<i class="fa fa-industry"></i>
              </a>
              <a href="index.php?option=com_erp&view=gestionusuarios&layout=edita&id=<?=$usuario->id?>" class="btn btn-success" title="Edit">
              	<i class="fa fa-pencil"></i>
              </a>
              <? if($usuario->group_id != 8){?>
              <a href="index.php?option=com_erp&view=gestionusuarios&layout=publica&estado=<?=$usuario->block?>&id=<?=$usuario->id?>" class="<?=$btn?>" title="<?=$title?>"><i class="fa fa-eye-slash<?=$estado?>"></i></a>
              <? }?>
              <!--<? if($usuario->group_id != 8){?>
              <a href="index.php?option=com_erp&view=gestionusuarios&layout=edita&id=<?=$usuario->id?>" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></a>
              <? }?>-->
            </td>
          </tr>
          <? }?>
        </tbody>
      </table>
      </div>
    </div>
  </section>
</div>
<?
}else{
	vistaBloqueada();
	}
?>