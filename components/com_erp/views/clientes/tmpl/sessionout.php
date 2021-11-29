<? defined('_JEXEC') or die;
$session = JFactory::getSession();
if(JRequest::getVar('ok','','post')==1){
    $ruta = "media/com_erp/tmp";
    if(!$session->get('nit')){
        $archivo = $session->get('nit');
        unlink($ruta.$archivo);
    }
    if(!$session->get('matricula')){
        $archivo = $session->get('matricula');
        unlink($ruta.$archivo);
    }
    if($session->get('poder')){
        $archivo = $session->get('poder');
        unlink($ruta.$archivo);
    }
    if(count($session->get('testimonios'))>0){
        $archarray = $session->get('testimonios');
        foreach ($archarray as $filetestim){
            unlink($ruta.$filetestim);
        }
    }
    $session->clear('testimonios');
    $session->clear('nit');
    $session->clear('matricula');
    $session->clear('poder');        
}
?>