<?php defined('_JEXEC') or die;
$producto = getProducto(JRequest::getVar('id', '', 'post'))
?>
<!-- INICIO -->
                        	<div class="row-fluid">
                              <div class="span6">
                            	<img src="media/com_erp/productos/thumbs/<?=$producto->image?>" class="span4" style=" margin: 0 10px 5px 0">
                            	<h3 style=""><?=$producto->name?></h3>
                                <input type="hidden" name="campo_precio" id="campo_precio" value="<?=$producto->price?>">
                                <input type="hidden" name="campo_id" id="campo_id" value="<?=$producto->id?>">
                                <input type="hidden" name="campo_nombre" id="campo_nombre" value="<?=$producto->name?>">  
                              </div>
                              <div class="span6">
									<? $m = 0;
                                    $adic = '';
									$var_adi = '';
                                    foreach(getAdicionalesAsignados($producto->id) as $adi){
                                        $option_adi = '';
                                        $check_adi  = '';
                                        $var_adi.=	'
        variable_adi = jQuery("#com_'.$adi->id.'").val().split("_");
        adic['.$m.'] = "'.$adi->name.':"+variable_adi[0]+":"+variable_adi[1]+":"+variable_adi[2];
        prodadicional['.$m.'] = variable_adi[1];';
                                        foreach(getAdicionalItem($adi->id, $producto->id) as $item){
                                            if($item->precio == 0)
                                                $precio = '';
                                                else
                                                $precio = ' (+ '.$item->precio.')';
                                            $option_adi.= '<option style=" font-size:25px" value="'.$item->name.'_'.$item->precio.'_'.$item->id.'">'.$item->name.$precio.'</option>';
                                            
                                            }?>
                                <div class="row-fluid">
                                  <div class="span4"><?=$adi->name?></div>
                                  <div class="span8">
                                    <? echo '<select name="com_'.$adi->id.'" id="com_'.$adi->id.'" class="span12" onChange="calcula()"><option value="0_0_0" style=" font-size:25px"></option>'.$option_adi.'</select>';
									?>
                                  </div>
                                </div>
                                <? $m++;}
									$n = 0;
                                    $comp = '';
									$var = '';
                                    foreach(getComplementosAsignados($producto->id) as $com){
                                        $option = '';
                                        $check  = '';
                                        $var.=	'
        variable = jQuery("#com_'.$com->id.'").val().split("_");
        comp['.$n.'] = "'.$com->nombre.':"+variable[0]+":"+variable[1]+":"+variable[2];
        adicional['.$n.'] = variable[1];';
                                        foreach(getComplementoItem($com->id) as $item){
                                            if($item->price == 0)
                                                $precio = '';
                                                else
                                                $precio = ' (+ '.$item->price.')';
                                            $check.= '<label><input type="checkbox" name="'.$com->id.'[]" value="'.$item->id.'" style="display:inline"> '.$item->name.'</label>';
                                            $option.= '<option style=" font-size:25px" value="'.$item->name.'_'.$item->price.'_'.$item->id.'">'.$item->name.$precio.'</option>';
                                            
                                            }?>
                                <div class="row-fluid">
                                  <div class="span4"><?=$com->nombre?></div>
                                  <div class="span8">
                                    <? if($com->multiple == 0)
											echo '<select name="com_'.$com->id.'" id="com_'.$com->id.'" class="span12" onChange="calcula()"><option style=" font-size:25px" value="0_0_0"></option>'.$option.'</select>';
											else
											echo $check;
									?>
                                  </div>
                                </div>
                                <? $n++;}?>
                              </div>
                            </div>
<script>
function calcula(){
	var precio = jQuery('#campo_precio').val();
	var cantidad = jQuery('#campo_cantidad').val();
	var variable;
	var variable_adi;
	var total;
<?=$var_adi?>

<?=$var?>

	var add = 0;
	for(i=0; i<prodadicional.length; i++)
		add+= parseFloat(prodadicional[i]);
	for(i=0; i<adicional.length; i++)
		add+= parseFloat(adicional[i]);
	total = (parseFloat(precio) + add) * parseFloat(cantidad);
	jQuery('#campo_total').val(total);
	}
calcula();
</script>
<!-- FIN -->