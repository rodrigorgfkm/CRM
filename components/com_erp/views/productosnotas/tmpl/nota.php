<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Notas de entrega') or validaAcceso('Administracion Productos')){?>
<?
$session = JFactory::getSession();
$ext = $session->get('extension');
$empresa = getEmpresa();
$p = getNota();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Nota de Entrega</h3>
      </div>
      <div class="box-body">        
            <div class="col-xs-12 row form-horizontal">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">Cliente</label>
                    <div class="col-xs-12 col-sm-10">
                        <?=$p->nombre.' '.$p->apellido?>
                    </div>
                </div>            
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">Empresa</label>
                    <div class="col-xs-12 col-sm-10">
                        <?=$p->empresa?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">Teléfono</label>
                    <div class="col-xs-12 col-sm-10">
                        <?=$p->fono?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">Celular</label>
                    <div class="col-xs-12 col-sm-10">
                        <?=$p->celular?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2">Correo elelctrónico</label>
                    <div class="col-xs-12 col-sm-10">
                        <?=$p->email?>
                    </div>
                </div>
            </div>
              <table class="table table-striped table-bordered" id="detalle_lista">
                <thead>
                  <tr>
                    <td width="50">Ítem</td>
                    <td width="100">Código</td>
                    <td width="80">Cantidad</td>
                    <td>Detalle</td>
                    <td width="100">P. Unitario</td>
                    <td width="100">P. Total</td>
                  </tr>
                </thead>
                <tbody>
                  <? $total = 0;
                  $n = 1;
                  foreach(getNotaDetalle() as $det){
                      $total+= $det->precio * $det->cantidad;?>
                  <tr id="tr_0">
                    <td><?=$n?></td>
                    <td><?=$det->codigo?></td>
                    <td><?=$det->cantidad?></td>
                    <td><?=$det->detalle?></td>
                    <td><?=$det->precio?></td>
                    <td><?=($det->precio * $det->cantidad)?></td>
                  </tr>
                  <? $n++;
                  }?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Descuento</b></td>
                    <td><?=$p->descuento?></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <th>Total</th>
                    <td><?=$total - $p->descuento?></td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align:center">                  
                    </td>
                  </tr>
                </tfoot>
              </table>
          <div class="hidden-xs col-xs-12">
              <a class="btn btn-info col-md-6" href="index.php?option=com_erp&view=productosnotas"><em class="fa fa-arrow-left"></em> Volver al Listado</a>
              <a class="btn btn-success col-md-6" rel="shadowbox;width=800" id="imprime" style="font-size:14px" href="index.php?option=com_erp&view=productosnotas&layout=imprime&id=<?=JRequest::getVar('id', '', 'get')?>&tmpl=component"><i class="fa fa-print"></i> Imprimir</a>
          </div>
          <script>
          function boton(){
              jQuery("#imprime").trigger('click')
              }
          boton();
          </script>
      </div>
    </div>
  </section>
</div>
<? }else{vistaBloqueada();}?>