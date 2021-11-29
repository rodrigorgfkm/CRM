<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){
$session = JFactory::getSession();
$asociado = $session->get('r_asociado');
$registro = $session->get('r_registro');
$id_categoria = $session->get('r_id_categoria');
$id_cobrador = $session->get('r_id_cobrador');
$id_mesajero = $session->get('r_id_mensajero');
$id_tipo = $session->get('r_id_tipo');
$id_estado = $session->get('r_id_estado');
$id_actividad = $session->get('r_id_actividad');
?>
<style>
    @media print{
        .btn{
            display: none;
        }
    }
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-users"></i>
		<!-- Título de la vista -->
        <h3 class="box-title text-center">Rengel Importaciones <br> La Paz - Bolivia </h3>		
        <h3 class="box-title pull-right">Fecha: <?=date('d/m/Y')?></h3>		
        <!-- Algunos botones si son necesarios -->
        <div class="box-body" >
          <center>
              <h3>REPORTE EJECUTIVO</h3>
          </center>
        </div>
      </div>
      <div class="box-body">
        <button type="button" class="btn btn-success col-xs-12 print" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
         <table>
             <thead>
                 <th width="80">Registro</th>
                 <th width="200">Asociado</th>
                 <th width="60">Tipo</th>
                 <th width="60">NIT</th>
                 <th width="80">Capital</th>
                 <th width="100">Inscrito Por</th>
                 <th width="80">Categoría</th>
                 <th width="100">Cobrador</th>
                 <th width="100">Mensajería</th>
                 <th width="60">Poder</th>
             </thead>
             <tbody>
                <? foreach(getClientesrep(1) as $cliente){
                    /*echo '<pre>';
                    print_r($cliente);
                    echo '</pre>';*/
                ?>
                <tr>
                    <td><?=$cliente->registro?></td>
                    <td><?=$cliente->empresa?></td>
                    <td><?=$cliente->sociedad?></td>
                    <td><?=$cliente->nit?></td>
                    <td><?=$cliente->capital?></td>
                    <td><? getUsuario($cliente->id_usuario_registro);
                        echo $usuario_inscribe->name?></td>
                    <td><?=$cliente->categoria?></td>                    
                    <td><? foreach(getUsuariosext() as $usuario){
                            if($usuario->id==$cliente->id_usuario_cobrador){?>
						        <?=$usuario->nombre?></option>
				        <?  }
                        }?>
                    </td>
                    <td><? foreach(getUsuariosext() as $usuario){
                            if($usuario->id==$cliente->id_usuario_mensajero){?>
						        <?=$usuario->nombre?></option>
				        <?  }
                        }?>
                    </td>
                    <td><?=$cliente->poder?></td>
                </tr>
                <? }?>
             </tbody>
         </table>
         <button type="button" class="btn btn-success col-xs-12 print" onclick="window.print()"><i class="fa fa-print"></i> Imprimir</button>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>