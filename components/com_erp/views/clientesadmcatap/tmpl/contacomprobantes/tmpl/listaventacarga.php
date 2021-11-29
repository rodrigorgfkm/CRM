<?php 
defined('_JEXEC') or die;?>
<? if(validaAcceso('Contabilidad Comprobante nuevo')){
    
    createTemporalFact();  
	
    $id_facts = JRequest::getVar('facturas','','post');
	$p = getPais();
	
	$n = JRequest::getVar('n', '', 'post');    
	$det_imp = getLCV('lv');
	
    $cont = 0;
    $inputs = array();
    $lim_det = 50;
	
    foreach($id_facts  as $id){
        getFacturaDetalleCuenta($id);
	    array_push($inputs,$id);
        $cont++;
    }
	
    $ihidden = '<input type="hidden" name="id_factura_agrupada[]" value="'.$inputs.'">';
	
	$fila = '';
    $c = 0;
	
	foreach(getTemporalFact() as $d){
		$n++;
		$cta = getCNTcuenta($d->id_cuenta);
		$fila.= '<tr id="tr_'.$n.'" class="fv_'.$d->id_cuenta.'"><td style="vertical-align:middle; text-align:center;"><i class="fa fa-arrows-v" style="padding:0 5px; cursor:pointer"></i></td><td><input name="codigo[]" readonly type="text" class="form-control validate[required]" id="codigo_'.$n.'" value="'.$d->codigo.'"><input type="hidden" name="id_cta[]" id="id_cta_'.$n.'" value="'.$d->id_cuenta.'"><input type="hidden" name="id_aux[]" id="id_aux_'.$n.'" value="0"></td><td><input name="cuenta[]" readonly type="text" class="form-control validate[required, maxSize['.$lim_det.']]" id="descripcion_'.$n.'" value="'.$d->cuenta.'"></td><td><input name="detalle[]" type="text" class="form-control" id="detalle_'.$n.'" value="'.$d->cuenta.' --"><input type="hidden" name="id_factura[]" id="id_factura_'.$n.'" value="0"></td><td><input name="debe[]" type="text" class="form-control validate[required] text-right" id="debe_'.$n.'" onKeyUp="monto(this.id)" value="0.00"></td><td><input name="haber[]" type="text" class="form-control validate[required] text-right" id="haber_'.$n.'" onKeyUp="monto(this.id)" value="'.$d->monto.'"></td><td><a class="btn bg-orange botonelimina"><i class="fa fa-trash"></i></a></td></tr>';
		}
    codigoRename();
    echo $fila;
    clearTemporalFact();
	echo "<script>
            parent.datos('".$fila.$ihidden."', 'tr_".$n."', '".($n+1)."');
            window.parent.Shadowbox.close();    
        </script>";
	}else{vistaBloqueada();}?>
