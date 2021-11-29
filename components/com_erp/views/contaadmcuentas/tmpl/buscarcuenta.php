<? defined('_JEXEC') or die('Restricted access');?>
<?
$id = JRequest::getVar('gest','','post');
$n = 1;
$cadena = '';
foreach(getCNTcuentas($id_gestion) as $cta){
    if($cta->codigo == 0){
        $pcuenta = getCNTcuenta($cta->id_padre);
        $codigo = '';
        $cta_id = $pcuenta->id;
        $cta_codigo = $pcuenta->codigo;
        $cta_nombre = $pcuenta->nombre.' ('.$cta->nombre.')';
        $id_auxiliar = $cta->id;
        }else{
        $codigo = codigoRename($cta->codigo);
        $cta_id = $cta->id;
        $cta_codigo = $cta->codigo;
        $cta_nombre = $cta->nombre;
        $id_auxiliar = 0;
    }
$cadena .= '
<tr>
    <td>'.$n.'</td>
    <td>'.$codigo.'</td>
    <td>'.$cta->nombre_completo.'</td>
    <td>';
    if(!hasChild($cta->id)){
        $cadena .='<a class="btn btn-success btn-xs" onClick="envia(`'.$cta_id.'`, `'.filtroCadena2($cta_nombre).'`, `'.codigoRename($cta_codigo).'`, `'.$id.'`, `'.$id_auxiliar.'`)">
            <em class="fa fa-pencil"></em> Cargar
        </a>';
    }
    $cadena.='</td>
</tr>';
$n++;}
echo $cadena;
?>