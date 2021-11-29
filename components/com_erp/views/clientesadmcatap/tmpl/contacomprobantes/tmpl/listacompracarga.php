<?php 
defined('_JEXEC') or die;?>

<? if(validaAcceso('Contabilidad Comprobante nuevo')){

	$p = getPais();

	$id = JRequest::getVar('id', '', 'get');

	$f = getFactura($id);

	$imp = $f->total * ($p->impuesto/100);

	$det = getFacturaDetalle($id);

	$n = JRequest::getVar('n', '', 'get');

	$det_imp = getLCV('lc');

	$fila = '';

    $compra = getCompra($id);        

    $val_imp = $compra->total * (100-$p->impuesto) / 100;

    $monto =  $compra->total - $val_imp;

    //print_r($det_imp);

	$n++;

    $lim_det = 50;

	$fila.= '<tr id="tr_'.$n.'" class="fc_'.$id.'"><td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td><td><input name="codigo[]" readonly type="text" class="form-control validate[required]" id="codigo_'.$n.'" value="'.$det_imp->c_codigo.'"><input type="hidden" name="id_cta[]" id="id_cta_'.$n.'" value="'.$det_imp->id_relacion.'"><input type="hidden" name="id_aux[]" id="id_aux_'.$n.'" value="0"></td><td><input name="cuenta[]" readonly type="text" class="form-control validate[required]" id="cuenta_'.$n.'" value="'.$det_imp->c_nombre.'"></td><td><input name="detalle[]" type="text" class="form-control validate[maxSize['.$lim_det.']]" id="detalle_'.$n.'" value="'.$compra->empresa.' - '.$compra->nit.'"><input type="hidden" name="id_factura[]" id="id_factura_'.$n.'" value="0"><input type="hidden" name="id_compra[]" value="'.$compra->id.'"></td><td><input name="debe[]" type="text" class="form-control validate[required] text-right" id="debe_'.$n.'" onKeyUp="monto(this.id)" value="'.$val_imp.'"></td><td><input name="haber[]" type="text" class="form-control validate[required] text-right" id="haber_'.$n.'" onKeyUp="monto(this.id)" value="0.00"></td><td><a class="btn bg-purple botoneliminacomp" id="0"><i class="fa fa-trash"></i></a></td></tr>';

    

    $n++;

    $fila.= '<tr id="tr_'.$n.'" class="fc_'.$id.'"><td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td><td><input name="codigo[]" readonly type="text" class="form-control validate[required]" id="codigo_'.$n.'" value="'.$det_imp->codigo.'"><input type="hidden" name="id_cta[]" id="id_cta_'.$n.'" value="'.$det_imp->id_impuesto.'"><input type="hidden" name="id_aux[]" id="id_aux_'.$n.'" value="0"></td><td><input name="cuenta[]" readonly type="text" class="form-control validate[required]" id="cuenta_'.$n.'" value="'.$det_imp->i_nombre.'"></td><td><input name="detalle[]" type="text" class="form-control validate[maxSize['.$lim_det.']]" id="detalle_'.$n.'" value="---"><input type="hidden" name="id_factura[]" id="id_factura_'.$n.'" value="0"></td><td><input name="debe[]" type="text" class="form-control validate[required] text-right" id="debe_'.$n.'" onKeyUp="monto(this.id)" value="'.$monto.'"></td><td><input name="haber[]" type="text" class="form-control validate[required] text-right" id="haber_'.$n.'" onKeyUp="monto(this.id)" value="0.00"></td><td><a class="btn bg-purple botoneliminacomp" id="0"><i class="fa fa-trash"></i></a></td></tr>';

    codigoRename();	

    //echo $fila;

	echo "<script>

            parent.datos('".$fila."', 'tr_".$n."', '".($n+1)."');

            window.parent.Shadowbox.close();    

        </script>";	

	}else{vistaBloqueada();}?>

