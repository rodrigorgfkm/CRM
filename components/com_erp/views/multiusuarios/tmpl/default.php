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
    jQuery('.sucursal').on('change', function(){        
        jQuery.ajax({
                    url:"index.php?option=com_erp&view=multiusuarios&layout=cambiasucursal&tmpl=blank",
                    type:"POST",
                    data:{id_usuario:jQuery(this).siblings('input').attr('id'), id_sucursal: jQuery(this).val()}
                    })
        jQuery(this).siblings('span').show(500);
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
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo-e</th>
            <th width="100">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <? foreach(getSUsuarios() as $usuario){
				if($usuario->block == 0){
					$estado = 'check';
					$btn = 'btn btn-success';
					$title = 'Bloquear usuario';
					}else{
					$estado = 'ban';
					$btn = 'btn btn-danger';
					$title = 'Habilitar usuario';
					}
					?>
          <tr>
            <td><?=$usuario->name?></td>
            <td><?=$usuario->username?></td>
            <td><?=$usuario->email?></td>
            <td>
              <a href="index.php?option=com_erp&view=multiusuarios&layout=edita&id=<?=$usuario->id?>" class="btn btn-info btn-sm" title="Edit">
                <i class="fa fa-pencil"></i>
              </a>
              <a href="index.php?option=com_erp&view=multiusuarios&layout=publica&estado=<?=$usuario->block?>&id=<?=$usuario->id?>" class="<?=$btn?> btn-sm" title="<?=$title?>"><i class="fa fa-<?=$estado?>"></i></a>
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