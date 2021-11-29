<?php
$db =& JFactory::getDBO();
$query = 'SELECT * FROM cgn_erp_conta_cuentas';
$db->setQuery($query);
$cuentas = $db->loadObjectList();

$query = 'SELECT * FROM cgn_erp_conta_cuentas_main';
$db->setQuery($query);
$cuentas_main = $db->loadObjectList();
foreach($cuentas as $cta){
    foreach ($cuentas_main as $main){
        if($cta->nombre == $main->nombre){
            $query = 'UPDATE cgn_erp_conta_cuentas SET id_origen = "'.$main->id.'" WHERE id = "'.$cta->id.'"';
            $db->setQuery($query);
            $db->query();
        }
    }
}
echo "terminado";
?>