<?php defined('_JEXEC') or die;
$cat = getCategoria(JRequest::getVar('id', '', 'post'));
?>
<!-- INICIO -->
                            	<div id="bloqueo" style="background-color:rgba(255,255,255,0.5); position:absolute; width:100%; height:100%"></div>
								<? $cont = 0;
								foreach(cargaMenu(JRequest::getVar('id', '', 'post')) as $menu){
									if(($cont % 4) == 0)
										echo '<div class="row-fluid" style="margin-top:10px">';?>
                                <div class="food span3">
                                	<a class="btn span12" data-toggle="modal" data-backdrop="static" href="#producto" onClick="cargaProducto(<?=$menu->id?>)">
                                        <img src="media/com_erp/productos/thumbs/<?=$menu->image?>" class="span6"/>
                                        <div class="span6">
											<?=$menu->name?>
                                            <br>
                                            <em><strong>$ <?=round($menu->price)?></strong></em>
                                        </div>
                                    </a>
                                </div>
								<? 
									if((($cont + 1) % 4) == 0)
										echo '</div>';
									$cont++;
								}
								if((($cont) % 4) != 0)
									echo '</div>';
								?>
                            	<script>
									if(jQuery('#campo_pedido').val() != '')
										jQuery('#bloqueo').hide();
									cantitem(<?=$cont?>);
									titulo('<?=$cat->name?>')
								</script>
<!-- FIN -->