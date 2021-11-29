<? defined('_JEXEC') or die;
$session = JFactory::getSession();  
$tipo = JRequest::getVar('tipo','','post');
$extension = JRequest::getVar('extension','','post');
if($tipo!="testimonio"){
    if($tipo=='nit'){
        $nit = $tipo.'_'.time().rand(0,50).'.'.$extension;
        $session->set('nit', $nit);
        //echo $session->get('nit');
        copy($_FILES['archivo']['tmp_name'],'media/com_erp/tmp/'.$nit);
    }elseif($tipo=='matricula'){
        $matricula = $tipo.'_'.time().rand(0,50).'.'.$extension;
        $session->set('matricula', $matricula);
        //echo $session->get('matricula');
        copy($_FILES['archivo']['tmp_name'],'media/com_erp/tmp/'.$matricula);
    }elseif($tipo=='poder'){
        $poder = $tipo.'_'.time().rand(0,50).'.'.$extension;
        $session->set('poder', $poder);
        //echo $session->get('poder');
        copy($_FILES['archivo']['tmp_name'],'media/com_erp/tmp/'.$poder);
    }
}else{    
    if(!$session->get('testimonios')){
        $testimonios = array();
        //echo "Testimonios NO esta definido";
    }else{
        $testimonios = $session->get('testimonios');
        //echo "Testimonios SI esta definido";
    }
    $nombret = $tipo.'_'.time().rand(0,50).'.'.$extension;
    array_push($testimonios,$nombret);
    //print_r($testimonios);
    $session->set('testimonios', $testimonios);
    //print_r($session->get('testimonios'));
    copy($_FILES['archivo']['tmp_name'],'media/com_erp/tmp/'.$nombret);
    //$session->clear('testimonios');
}
echo JRequest::getVar('id','','post');
?>