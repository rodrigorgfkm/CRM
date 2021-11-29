<?php defined('_JEXEC') or die;
if(validaAcceso('Contabilidad Comprobantes')){
$comprobante = getComprobante();
?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-file-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Detalle del Comprobante Nro <?=$comprobante->id?></h3>
      </div>
      <div class="box-body">
        <form action="" method="post" name="form" id="form" class="form-horizontal" role="form">
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Tipo
                 </label>
                 <div class="col-xs-12 col-sm-4">                     
                    <? foreach(getTipoComprobantes() as $tipo){
                         if($comprobante->id_tipo==$tipo->id){
                            $cmt = $tipo->tipo;
                    ?>
                            <input type="text" name="tipo" class="form-control" value="<?=$tipo->tipo?>" readonly>                            
                    <? }
                    }?>                        
                 </div>
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Fecha de Creación
                 </label>
                 <div class="col-xs-12 col-sm-4">
                    <input type="text" name="fecha" class="form-control" id="fecha" value="<?=fecha($comprobante->fec_creacion)?>" readonly>
                 </div>
             </div>
             <div class="form-group">
                 <label for="" class="col-xs-12 col-sm-2 control-label">
                     Tipo de Cambio 
                 </label>
                 <div class="col-xs-12 col-sm-4">
                    <input name="cambio" type="text" class="form-control validate[required]" id="focusedInput" value="<?=$comprobante->tipo_cambio?>" readonly>
                 </div>
                 <label for="" class="col-xs-12 col-sm-2 control-label" id="encabezado_text"  <?=$comprobante->id_tipo<3?'':'style="display:none"'?>>
                     <? switch($comprobante->id_tipo){
                            case '1':
                            $texto = 'Hemos abonado a';
                            break;
                            case '2':
                            $texto = 'Hemos recibido de';
                            break;
                        }?>
                        <?=$texto?> 
                 </label>
                 <div class="col-xs-12 col-sm-4"  <?=$comprobante->id_tipo<3?'':'style="display:none"'?>>
                    <input type="text"  class="form-control validate[required]" readonly name="cliente_nombre" id="id_cliente_nombre" value="<?=$comprobante->cliente?>">
                 </div>
             </div>
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$comprobante->id_cliente?>" readonly>
                  <div class="id_padre" style="height:0px; overflow:visible; position:absolute; display:none; z-index:10000">
                    <div style="border:1px solid #ccc; border-radius:5px; margin-top:5px; padding:10px; background:#FFF; width:300px">
                    <table cellpadding="0" width="300" cellspacing="0" border="0" class="table table-striped table-bordered" id="tabladinamica">
                        <thead>
                            <tr>
                                <th width="30">N&ordm;</th><th>Beneficiario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $n = 1;
                            foreach(clientes() as $c){
                                if($c->empresa == '')
                                    $nombre = $c->nombre.' '.$c->apellido;
                                    else
                                    $nombre = $c->empresa;?>
                            <tr>
                                <td><?=$n?></td>
                                <td><a onClick="asigna('<?=$nombre?>','<?=$c->id?>')"><?=$nombre?></a></td>
                            </tr>
                            <? $n++;}?>
                        </tbody>
                    </table>
                      <div><a onClick="ocultaCuentas()" class="btn btn-block btn-success">Cerrar</a></div>
                    </div>
                  </div>
                 <div class="form-group">
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                         Por concepto de 
                     </label>
                     <div class="col-xs-12 col-sm-4">
                         <input name="detalle" id="detalle" type="text" class="form-control validate[required]" readonly value="Reversión al comprobante: <?=$comprobante->detalle?>">
                     </div>
                     <label for="" class="col-xs-12 col-sm-2 control-label">
                          Gestión
                     </label>
                     <div class="col-xs-12 col-sm-4">                       
                           <? $gestion = getGestion($comprobante->id_gestion);?>
                           <input type="text" class="form-control" value="<?=$gestion->gestion?>" readonly>
                           <input type="hidden" name="" value="<?=$comprobante->id_gestion?>">
                     </div>
                 </div>
                 <div class="table-responsive">
                     <table class="table table-striped" id="tabla_detalle">
                          <thead>
                            <tr>
                              <th width="90">C&oacute;digo</th>
                              <th>Cuenta Contable</th>
                              <th>Detalle</th>
                              <th width="100">Debe</th>
                              <th width="100">Haber</th>
                              <th width="42"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?
                            $n = 0;
                            $total_debe = 0;
                            $total_haber = 0;
                            foreach(getComprobanteDetalle() as $detalle){
                                $total_debe+= $detalle->debe;
                                $total_haber+= $detalle->haber;
                            ?>
                            <tr id="tr_<?=$n?>">
                              <td>
                              <input name="codigo[]" readonly type="text" class="form-control validate[required]" id="codigo_<?=$n?>" style="width:100%" value="<?=$detalle->codigo?>">
                              <input type="hidden" name="id[]" id="id_<?=$n?>" value="<?=$detalle->id_cuenta?>"></td>
                              <td><input name="cuenta[]" readonly type="text" class="form-control validate[required]" id="descripcion_<?=$n?>" style="width:100%" value="<?=$detalle->cuenta?>"></td>
                              <td><input name="detalle[]" readonly type="text" class="form-control validate[required]" id="descripcion_<?=$n?>" style="width:100%" value="<?=$detalle->detalle?>"></td>
                              <td><input name="debe[]" readonly type="text" class="form-control validate[required]" id="debe_<?=$n?>" style="width:100%; text-align:right" onKeyUp="monto(this.id)" value="<?=$detalle->debe?>"></td>
                              <td><input name="haber[]" readonly type="text" class="form-control validate[required]" id="haber_<?=$n?>" style="width:100%; text-align:right" onKeyUp="monto(this.id)" value="<?=$detalle->haber?>"></td>
                              <td></td>
                            </tr>
                            <? $n++;}?>
                          </tbody>
                          <tfoot>
                          <tr>
                              <td colspan="3" style="text-align:right"><strong>Total</strong></td>
                              <td><input name="total_debe" readonly type="text" class="form-control validate[required]" id="total_debe" style="width:100%; text-align:right" value="<?=$total_debe?>"></td>
                              <td><input name="total_haber" readonly type="text" class="form-control validate[required]" id="total_haber" style="width:100%; text-align:right" value="<?=$total_haber?>"></td>
                            <td></td>
                            </tr>
                            <tr>
                              <td colspan="5">                                
                              </td>
                            </tr>
                          </tfoot>
                      </table>
                 </div>
                 <div class="col-xs-12">
                    <a class="btn btn-info col-xs-12 col-sm-4" href="index.php?option=com_erp&view=contacomprobantes"><i class="fa fa-arrow-left"></i> Volver al Listado</a>
                    <a class="btn btn-success col-xs-12 col-sm-4 pull-right" href="index.php?option=com_erp&view=contacomprobantes&layout=imprimecomprobante&id=<?=$comprobante->id?>&t=<?=$cmt?>&tmpl=component" rel="shadowbox; width=950"><i class="fa fa-print"></i> Imprimir</a>
                    <!--<button class="btn btn-success col-xs-12 col-sm-3 btn-sm" id="envia" type="submit"><i class="fa fa-floppy-o"></i> Revertir Comprobante</button>-->                   
                 </div>
                  <script>
                  $n = <?=$n?>;
                  </script>
            </form>
      </div>      
    </div>
  </section>
</div>
<? }else{ vistaBloaqueada();}?>