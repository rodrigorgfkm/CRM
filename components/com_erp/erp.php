<?php
defined('_JEXEC') or die('Restricted access');


$user =& JFactory::getUser();
$session = JFactory::getSession();
$controller = JControllerLegacy::getInstance('erp');

require_once( 'components/com_erp/assets/funciones.php' );
require_once( 'components/com_erp/queries.php' );

foreach(getExtensiones() as $ext)
	$extension[$ext->cod] = $ext;
$session->set('extension',$extension);

require_once( 'components/com_erp/Verhoeff.php' );
require_once( 'components/com_erp/queries_facturacion.php' );
require_once( 'components/com_erp/queries_crm.php' );
require_once( 'components/com_erp/queries_contabilidad.php' );
require_once( 'components/com_erp/queries_librobancos.php' );

getAccesos();

if(JRequest::getVar('tmpl', '', 'get') != 'blank')
	scriptCSS();

$view = JRequest::getVar('view', '', 'get');

// Perform the Request task
if($user->get('id') != '' || $view == 'registroempresa'){
	$input = JFactory::getApplication()->input;
	$controller->execute($input->getCmd('task'));
	 
	// Redirect if set by the controller
	$controller->redirect();
	}else{
	?>
	<script>
      location.href = 'index.php?option=com_users&view=login';
    </script>
	<? 
	}