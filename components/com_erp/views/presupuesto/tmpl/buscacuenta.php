<? 
$n = 1;
$cuenta = '';
foreach(getCNTcuentaspre($id) as $cta){
    $cuenta.='<tr>
      <td>'.$n.'</td>
      <td>'.codigoRename($cta->codigo).'</td>
      <td>'.$cta->nombre_completo.'</td>
      <td class="text-center">';
        if(!hasChild($cta->id)){
          $checked = $cta->presupuesto==1?'checked':'';
          $cuenta.='<input type="checkbox" id="id_cta_contable_'.$cta->id.'" data-toggle="toggle" '.$checked.' class="checks" value="'.$cta->id.'">';
        }
      $cuenta.='</td>
    </tr>';
     $n++;
}
echo $cuenta;
?>