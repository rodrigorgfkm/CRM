<?php defined('_JEXEC') or die;
$db =& JFactory::getDBO();
$query = 'SELECT * FROM cta_2018 WHERE CTA_CODIGO LIKE "4%"';
$db->setQuery($query);
$cuentas = $db->loadObjectList();
$constante = 759;
function contardigitos($num){
    $c = 0;
    while($num > 0){
        $num = floor($num/10);
        $c++;
    }
    return $c;
}
function quitarcomillas($texto){
    $resultado = str_replace("'", "", $texto);
    $nuevotexto = str_replace('"', "", $resultado);
    return $nuevotexto;
}
$lft=0;
$rgt=0;
$lft = $constante;
$rgt = $lft+$constante;
$nieto = 0;
$hijo = 0;
$padre = 0;
foreach ($cuentas as $cuenta){    
    $invertir = invertir($cuenta->CTA_CODIGO);
    $digitos = contardigitos($invertir);
    $revertir = invertir($invertir);
    if($digitos==1){//nivel 1 PADRE
        /*if($padre>0){
            $query = 'SELECT lft FROM cgn_erp_conta_cuentas WHERE id = "'.$id_padren1.'"';
            $db->setQuery($query);
            $lft = $db->loadResult(); 
            $lft++;
        }*/
        $query = 'INSERT INTO cgn_erp_conta_cuentas(`id_empresa`, `id_padre`, `id_gestion`, `codigo`, `nombre`, `lft`,`rgt`, `nivel`) VALUES(';
        $query.= '"1"';
        $query.= ',"0"';
        $query.= ',"20"';
        $query.= ',"'.$revertir.'"';
        $query.= ',"'.quitarcomillas($cuenta->CTA_NOMBRE).'"';
        $query.= ',"'.$lft.'"';//LFT
        $query.= ',"'.($constante+1).'"';//RGT
        $query.= ',"1")';
        $db->setQuery($query);  
		$db->query();
        //echo $query;
        $query_id = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query_id);
        $id_padren1 = $db->loadResult();
    }elseif($digitos==3){//nivel 2 HIJO
        if($hijo==0){
            $hijo++;
            $query = 'SELECT lft FROM cgn_erp_conta_cuentas WHERE id = "'.$id_padren1.'"';
            $db->setQuery($query);
            $lft = $db->loadResult(); 
            $lft++;
            $aux = $lft;            
        }else{
            $aux+=2;
            $lft=$aux+1;
        }
        
        $query = 'INSERT INTO cgn_erp_conta_cuentas(`id_empresa`, `id_padre`, `id_gestion`, `codigo`, `nombre`, `lft`,`rgt`, `nivel`) VALUES(';
        $query.= '"1"';
        $query.= ',"'.$id_padren1.'"';
        $query.= ',"20"';
        $query.= ',"'.$revertir.'"';
        $query.= ',"'.quitarcomillas($cuenta->CTA_NOMBRE).'"';
        $query.= ',"'.$lft.'"';//LFT
        $query.= ',"'.$rgt.'"';//RGT
        $query.= ',"2")';
        $db->setQuery($query);  
		$db->query();
                       
        //echo $query;
        $query_id = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query_id);
        $id_padren2 = $db->loadResult(); 
    }elseif($digitos==6){//nivel 3 NIETO
        if($nieto==0){
            $nieto++;
            $query = 'SELECT lft FROM cgn_erp_conta_cuentas WHERE id = "'.$id_padren2.'"';
            $db->setQuery($query);
            $lft = $db->loadResult(); 
            $lft++;
            $aux = $lft;            
        }else{
            $aux+=2;
            $lft=$aux;
        }
        
        $query= 'INSERT INTO cgn_erp_conta_cuentas(`id_empresa`, `id_padre`, `id_gestion`, `codigo`, `nombre`, `lft`,`rgt`, `nivel`) VALUES(';
        $query.= '"1"';
        $query.= ',"'.$id_padren2.'"';
        $query.= ',"20"';
        $query.= ',"'.$revertir.'"';
        $query.= ',"'.quitarcomillas($cuenta->CTA_NOMBRE).'"';
        $query.= ',"'.$lft.'"';//LFT
        $query.= ',"'.$rgt.'"';//RGT
        $query.= ',"3");';
        $db->setQuery($query);  
		$db->query();
        
        $query = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query);
        $id_padren3 = $db->loadResult();
    }else{//nivel 4 BISNIETO      
       /* if($aux == 0){
            $query = 'SELECT lft FROM cgn_erp_conta_cuentas WHERE id = "'.$id_padren3.'"';
            $db->setQuery($query);
            $lft = $db->loadResult(); 
            $lft++;
            $aux = $lft;
        }else{*/
            $aux = $aux+1;
        //}
        $query = 'INSERT INTO cgn_erp_conta_cuentas(`id_empresa`, `id_padre`, `id_gestion`, `codigo`, `nombre`, `lft`,`rgt`, `nivel`) VALUES(';
        $query.= '"1"';
        $query.= ',"'.$id_padren3.'"';
        $query.= ',"20"';
        $query.= ',"'.$cuenta->CTA_CODIGO.'"';
        $query.= ',"'.quitarcomillas($cuenta->CTA_NOMBRE).'"';
        $query.= ',"'.$aux.'"';//LFT
        $aux++;
        $query.= ',"'.$aux.'"';//RGT
        $query.= ',"4");';        
        $db->setQuery($query);  
		$db->query();
        
        $query = 'SELECT LAST_INSERT_ID()';
        $db->setQuery($query);
        $id_padren4 = $db->loadResult();        
        
    }
    if($id_padren1){
        $rgt_final = $constante*2;
        $query_up = 'UPDATE cgn_erp_conta_cuentas SET rgt = "'.$rgt_final.'" WHERE id = "'.$id_padren1.'"';
        $db->setQuery($query_up);
		$db->query();
    }
    if($id_padren2){
        $rgt_final--;
        $query_up = 'UPDATE cgn_erp_conta_cuentas SET rgt = "'.$rgt_final.'" WHERE id = "'.$id_padren2.'"';
        $db->setQuery($query_up);
		$db->query();
    }
    if($id_padren3){
        $rgt_final--;
        $query_up = 'UPDATE cgn_erp_conta_cuentas SET rgt = "'.$rgt_final.'" WHERE id = "'.$id_padren3.'"';
        $db->setQuery($query_up);
		$db->query();
    }
    /*if($constante==40){
        break;
    }*/
    $constante++;
    echo $$constante;
}
?>