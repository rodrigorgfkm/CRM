<?php defined('_JEXEC') or die;?>
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Lista de Clientes</h3>		
      </div>
      <div class="box-body">
          <table class="table table-bordered table-striped table_vam" id="dt_gal">
                <thead>
                    <tr>
                        <th width="20">N&ordm;</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach(getclientesEmergente() as $cliente){
                          if($cliente->vigente == 1){
                              $n++;
                              $com = getClientesCom($cliente->id);
                          ?>
                    <tr>
                        <td><?=$n?></td>
                        <td><a style="cursor:pointer" onClick="parent.cargaCliente('<?=$cliente->id?>','<?=$cliente->apellido.' '.$cliente->nombre?>','<?=$com->fono_domicilio?>','<?=$com->celular?>','<?=$com->email?>', '<?=$cliente->cant?>')"><?=$cliente->apellido.' '.$cliente->nombre?></a></td>
                    </tr>
                    <? }}?>
                </tbody>
            </table>
      </div>
    </div>
  </section>
</div>
<!-- FIN -->