<?php defined('_JEXEC') or die;?>
<!-- INICIO -->
                            	<option style=" font-size:25px" value="0">Asignar mesero</option>
                                <? foreach(getMeseros(JRequest::getVar('id', '', 'post')) as $mesero){?>
                                <option style=" font-size:25px" value="<?=$mesero->id?>" style=" font-size:17px"><?=$mesero->name?></option>
                                <? }?>
<!-- FIN -->