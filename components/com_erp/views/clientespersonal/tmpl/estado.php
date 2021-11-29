<?php defined('_JEXEC') or die;?>
<? if(validaAcceso('Recibos')){?>
<style>
/* 
Generic Styling, for Desktops/Laptops 
*/
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    /* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 25% !important; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;        
	}
	tbody td{ min-height: 35px}
	td:nth-of-type(1):before { content: "Monto:"; font-weight: bold;}
	/*td:nth-of-type(1) { display: none}*/
	td:nth-of-type(2):before { content: "Estado:"; font-weight: bold}
	td:nth-of-type(3):before { content: "Registrado por:"; font-weight: bold}
	td:nth-of-type(4):before { content: "Fecha y Hora:"; font-weight: bold}	
	/*td:nth-of-type(6){ padding: 5px !important; height:auto}*/
}
</style>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-comments-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Estado de Cuenta</h3>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table_vam" id="dt_gal">
            <thead>
                <tr>
                    <th width="100">Monto</th>
                    <th width="100">Estado</th>
                    <th>Registrado por</th>
                    <th width="200">Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                <? foreach(getClienteCuenta() as $cuenta){
                    if($cuenta->monto < 0){
                        $monto = $cuenta->monto * (-1);
                        $estado = 'Pago';
                        }else{
                        $estado = 'Adeuda';
                        $monto = $cuenta->monto;
                        }
                        ?>
                <tr>
                    <td><?=$monto?></td>
                    <td><?=$estado?></td>
                    <td><?=$cuenta->usuario?></td>
                    <td><?=$cuenta->fecha?></td>
                </tr>
                <? }?>
            </tbody>
        </table>
      </div>      
    </div>
  </section>
</div>
<? }else{
    vistaBloqueada();
}?>