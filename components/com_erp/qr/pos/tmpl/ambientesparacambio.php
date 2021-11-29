<?php defined('_JEXEC') or die;
?>
<!-- INICIO -->
			      <div class="row-fluid" id="ambientesdisponibles">
                  	<? foreach(getAmbientes() as $ambiente){
						  if($ambiente->cant != 0 && $ambiente->ambiente != 'Sin ambiente'){?>
			          <a href="#" class="btn btn-info span4" onclick="cargaAmbienteparaCambio(<?=$ambiente->id?>)" style="font-size:20px;padding: 10px 6px">
					  	<?=$ambiente->ambiente?>
                      </a>
                      <? }}?>
                  </div>
<!-- FIN -->