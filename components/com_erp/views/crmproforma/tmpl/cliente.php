<?php defined('_JEXEC') or die;

//if(validaAcceso('Clientes Proforma')){?

?>

<!-- INICIO -->

<div class="row" style="position: absolute; top:-20px;">

  <section class="col-lg-12" >

    <div class="box box-success">     

      <div class="pull-right">

        <a onClick="parent.cerrarVentana('lista_cliente')" class="btn btn-danger btn-xs"><em class="fa fa-remove"></em></a>

      </div>		

      <div class="box-body" style="border:1px solid #666; border-radius: 5px;width:420px;background:#FFFFFF;">

        <table class="table table-bordered table-striped table_vam" id="tabladinamica" >

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

                            /* $fono = getDatoCom($cliente->id, 1); */

                            $tipo = 'p';

                            }else{

                            $cli = $cliente->empresa;

                          /*   if($cliente->nombre != '' || $cliente->apellido != '')

                            $tit = '<br /><span style="font-size:10px">Titular: '.$cliente->nombre.' '.$cliente->apellido.'</span>';

                            $fono = getDatoCom($cliente->id, 7);

                            $tipo = 'e'; */

                            }

                        $fono = $cliente->fono_empresa;
                        $celu = $cliente->celular;
                        $email= $cliente->correo;

                        ?>

                    <tr>

                        <td><a style="cursor:pointer" onClick="parent.cargaCliente('<?=$cliente->id?>','<?=$cli?>','<?=$fono?>','<?=$celu?>','<?=$email?>', '<?=$tipo?>', '0')"><?=$cli?></a><?=$tit?></td>

                    </tr>

                    <? }?>

                </tbody>

            </table>

      </div>

    </div>

  </section>

</div>

<!-- FIN -->

<? //}else{vistaBloqueada(); }?