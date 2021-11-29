<?php defined('_JEXEC') or die;?>
<? //if(validaAcceso('Registro de Clientes')){?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-text-o"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Reporte completo</h3>
      </div>
      <div class="box-body">
         <table>
             <thead>
                 <th></th>
             </thead>
             <tbody>
                 <? foreach(getRepCompleto() as $reporte){?>
                     <tr>
                         <td></td>
                     </tr>
                 <? }?>
             </tbody>
         </table>
      </div>
    </div>
  </section>
</div>
<? /*}else{
    vistaBloqueada();
}*/?>