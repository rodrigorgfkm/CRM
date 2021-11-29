<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Contabilidad Comprobante nuevo')){
    $id = JRequest::getVar('id','','get');
    $n = JRequest::getVar('n','','get');
    $p = getPais();
    $cheque = getLBcheque($id);
        //print_r($cheque);
    $n++;
    $cuentabanco = getLBcuenta($cheque->id_cuenta);
    $lim_det = 80;    
    /*$val_imp = $compra->total * (100-$p->impuesto) / 100;
    $monto =  $compra->total - $val_imp;*/
	$fila = '<tr id="tr_'.$n.'" class="fv_'.$cheque->id_cuenta.'"><td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td><td><div class="input-group"><input name="codigo[]" type="text" class="form-control validate[required]" id="codigo_'.$n.'" value="" onKeyUp="buscaCodigo(this.id)"><div class="input-group-btn"><button type="button" class="btn btn-info" id="buscar_'.$n.'" onClick="popup(this.id)"><em class="fa fa-search"></em></button></div></div><input type="hidden" name="id_cta[]" id="id_cta_'.$n.'" value=""><input type="hidden" name="id_aux[]" id="id_aux_'.$n.'" value="0"><div id="lista_producto_'.$n.'" class="div_cuenta"></div></td><td><input name="cuenta[]" readonly type="text" class="form-control validate[required, maxSize['.$lim_det.']]" id="descripcion_'.$n.'" value=""></td><td><input name="detalle[]" type="text" class="form-control validate[maxSize['.$lim_det.']]" id="detalle_'.$n.'" value="'.$cuentabanco->banco.' - '.$cuentabanco->cuenta.' ('.$cheque->detalle.')"><input type="hidden" name="id_factura[]" id="id_factura_'.$n.'"></td><td><input name="debe[]" type="text" class="form-control validate[required] text-right" id="debe_'.$n.'" onKeyUp="monto(this.id)" value="0.00"></td><td><input name="haber[]" type="text" class="form-control validate[required] text-right" id="haber_'.$n.'" onKeyUp="monto(this.id)" value="'.$cheque->monto.'"></td><td><a class="btn bg-orange botonelimina" id="0"><i class="fa fa-trash"></i></a></td></tr>';
	echo $fila;    
    codigoRename();
	echo "<script>
            parent.datos('".$fila.$ihidden."', 'tr_".$n."', '".($n+1)."');
            window.parent.Shadowbox.close();    
        </script>";
	}else{vistaBloqueada();}?>
