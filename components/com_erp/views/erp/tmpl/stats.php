<?
if(validaAcceso('ERP Estadisticas')){
$stats = getCRMfechaDia();
echo '<pre>';
print_r($stats);
echo '</pre>';


foreach($stats as $stat) {  
  foreach($stat as $campo => $valor)  
    echo $campo, ': ', $valor, '<br/>';  
  echo '<hr/>';  
}  
?>
<? }else{vistaBloqueada();}?>