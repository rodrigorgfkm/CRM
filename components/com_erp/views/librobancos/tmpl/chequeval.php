<?
$idbanco = JRequest::getVar('banco','','post');
echo getLBchequerahasta($idbanco)+1;
?>