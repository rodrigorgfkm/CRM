<?php defined('_JEXEC') or die;
$tr_persona = '';
$cn_persona = 0;
foreach(getclientesEmergente() as $cliente){
	  if($cliente->vigente == 1){
		  $cn_persona++;
		  $tr_persona.= '<tr><td><a style="cursor:pointer" onClick="parent.cargaCliente(\''.$cliente->id.'\',\''.$cliente->apellido.' '.$cliente->nombre.'\',\''.$com->fono_domicilio.'\',\''.$com->celular.'\',\''.$com->email.'\', \''.$cliente->cant.'\')">'.$cliente->apellido.' '.$cliente->nombre.'</a></td></tr>';
	  }}

$tr_empresa = '';
$cn_empresa = 0;
foreach(getclientesEmergente('e') as $cliente){
	  if($cliente->vigente == 1){
		  $cn_empresa++;
		  $tr_empresa.= '<tr><td><a style="cursor:pointer" onClick="parent.cargaCliente(\''.$cliente->id.'\',\''.$cliente->empresa.'\',\''.$com->fono_domicilio.'\',\''.$com->celular.'\',\''.$com->email.'\', \''.$cliente->cant.'\')">'.$cliente->empresa.'</a></td></tr>';
	  }}
if($cn_empresa > 0 && $cn_persona > 0)
	$span = 'span6';
	else
	$span = 'span12';
?>
<!-- INICIO -->
						<div style="background:#FFF; padding:5px; border:1px solid #CCC; border-radius:4px; width:500px; position:relative">
                        	<div class="row-fluid">
                              <? //if($cn_persona > 0){?>
                              <div class="12">
                                <div class="row-fluid">
                                    <div class="span12">
                                      <h4 class="span8">Lista de Personas</h4>
                                      <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-mini"><em class="icon-remove icon-white"></em></a></div>
                                    </div>
                                </div>             
                                <table class="table table-bordered table-striped table_vam" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?
                                        foreach(getclientesEmergente() as $cliente){
											if($cliente->empresa == ''){
												$cli = $cliente->nombre.' '.$cliente->apellido;
												$tit = '';
												$fono = getDatoCom($cliente->id, 1);
												}else{
												$cli = $cliente->empresa;
												$tit = '<br /><span style="font-size:10px">Titular'.$cliente->nombre.' '.$cliente->apellido.'</span>';
												$fono = getDatoCom($cliente->id, 7);
												}
											$celu = getDatoCom($cliente->id, 2);
											$email= getDatoCom($cliente->id, 3);
											?>
										<tr>
                                        	<td><a href="" onClick="parent.cargaCliente('<?=$cliente->id?>','<?=$cliente->empresa?>','<?=$fono?>','<?=$celu?>','<?=$email?>', '<?=$cliente->cant?>')"><?=$cli?></a><?=$tit?></td>
                                        </tr>
										<? }
										?>
                                        <? //$tr_persona?>
                                    </tbody>
                                </table>
                              </div>
                              <? /*}
							  if($cn_empresa > 0){?>
                              <div class="<?=$span?>">
                            <div class="row-fluid">
                                <div class="span8">
                                  <h4>Lista de Empresas <? getclientesEmergente('e')?></h4></div>
                                <div class="span4" style="text-align:right"><a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-mini"><em class="icon-remove icon-white"></em></a></div>
                            </div>             
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th>Nombre</th>
									</tr>
								</thead>
								<tbody>
									<?=$tr_empresa?>
								</tbody>
							</table>
                          </div>
                          	  <? }*/?>
                            </div>
                        </div>
<!-- FIN -->