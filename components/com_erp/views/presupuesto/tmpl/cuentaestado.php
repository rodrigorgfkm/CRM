<?php defined('_JEXEC') or die;
$id = JRequest::getVar('id', '', 'get');
$estado = JRequest::getVar('estado', '', 'get');
cambiaCNTcuentapresupuesto($id, $estado);
?>