<?
function newForm(){
	$db =& JFactory::getDBO();
	
	$name = JRequest::getVar('name', '', 'post');
	$last = JRequest::getVar('last', '', 'post');
	$middle = JRequest::getVar('middle', '', 'post');
	$gen = JRequest::getVar('gen', '', 'post');
	$birth = JRequest::getVar('birth', '', 'post');
	
	$mstate = JRequest::getVar('mstate', '', 'post');
	$respperson = JRequest::getVar('respperson', '', 'post');
	$address = JRequest::getVar('address', '', 'post');
	$city = JRequest::getVar('city', '', 'post');
	$state = JRequest::getVar('state', '', 'post');
	
	$zip = JRequest::getVar('zip', '', 'post');
	$hphone = JRequest::getVar('hphone', '', 'post');
	$wphone = JRequest::getVar('wphone', '', 'post');
	$cphone = JRequest::getVar('cphone', '', 'post');
	$soc_num = JRequest::getVar('soc_num', '', 'post');
	
	$employer = JRequest::getVar('employer', '', 'post');
	$spouse = JRequest::getVar('spouse', '', 'post');
	$phealth = JRequest::getVar('phealth', '', 'post');
	$pnum_poli = JRequest::getVar('pnum_poli', '', 'post');
	$shealth = JRequest::getVar('shealth', '', 'post');
	
	$snum_poli = JRequest::getVar('snum_poli', '', 'post');
	$emergency = JRequest::getVar('emergency', '', 'post');
	$emergencyn = JRequest::getVar('emergencyn', '', 'post');
	$carepsy = JRequest::getVar('carepsy', '', 'post');
	$pcpphone = JRequest::getVar('pcpphone', '', 'post');
	
	$referrals = JRequest::getVar('referrals', '', 'post');
	$email = JRequest::getVar('email', '', 'post');
	
	$query = 'INSERT INTO #__form(
	`name`, `last`, `middle`, `gen`, `birth`, 
	`mstate`, `respperson`, `address`, `city`, `state`, 
	`zip`, `hphone`, `wphone`, `cphone`, `soc_num`, 
	`employer`, `spouse`, `phealth`, `pnum_poli`, `shealth`, 
	`snum_poli`, `emergency`, `emergencyn`, `carepsy`, `pcpphone`, 
	`referrals`, `email`, `hour`, `date`
	) VALUES(';
	
	$query.= '"'.$name.'"';
	$query.= ', "'.$last.'"';
	$query.= ', "'.$middle.'"';
	$query.= ', "'.$gen.'"';
	$query.= ', "'.$birth.'"';
	
	$query.= ', "'.$mstate.'"';
	$query.= ', "'.$respperson.'"';
	$query.= ', "'.$address.'"';
	$query.= ', "'.$city.'"';
	$query.= ', "'.$state.'"';
	
	$query.= ', "'.$zip.'"';
	$query.= ', "'.$hphone.'"';
	$query.= ', "'.$wphone.'"';
	$query.= ', "'.$cphone.'"';
	$query.= ', "'.$soc_num.'"';
	
	$query.= ', "'.$employer.'"';
	$query.= ', "'.$spouse.'"';
	$query.= ', "'.$phealth.'"';
	$query.= ', "'.$pnum_poli.'"';
	$query.= ', "'.$shealth.'"';
	
	$query.= ', "'.$snum_poli.'"';
	$query.= ', "'.$emergency.'"';
	$query.= ', "'.$emergencyn.'"';
	$query.= ', "'.$carepsy.'"';
	$query.= ', "'.$pcpphone.'"';
	
	$query.= ', "'.$referrals.'"';
	$query.= ', "'.$email.'"';
	$query.= ', NOW()';
	$query.= ', NOW()';
	
	$query.= ')';
	$db->setQuery($query);  
	$db->query();
	}
function confirmForm(){
	$db =& JFactory::getDBO();  
	
	$id = JRequest::getVar('id', '', 'post');
	
	$query = 'UPDATE #__form SET available = "1" WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$db->query();
	}
function getForms(){
	$db =& JFactory::getDBO();  
	
	$query = 'SELECT * FROM #__form ORDER BY `date`, `hour` DESC';
	$db->setQuery($query);  
	$regs = $db->loadObjectList();
	
	return $regs;
	}
function getForm($id = ''){
	$db =& JFactory::getDBO();
	
	if($id == '')
		$id = JRequest::getVar('id', '', 'get');
	  
	$query = 'SELECT * FROM #__form WHERE id = "'.$id.'"';
	$db->setQuery($query);  
	$reg = $db->loadObject();
	
	return $reg;
	}
?>