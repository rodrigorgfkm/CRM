<?php defined('_JEXEC') or die;
$user =& JFactory::getUser();
use Joomla\CMS\Language\Text;

if($user->get('id') != ''){
	$session = JFactory::getSession();
	$acceso = $session->get('acceso');
	$ext = $session->get('extension');?>
<? if($session->get('ide') != ''){?>
<div class="row">
  <? if($session->get('ide') == 1){?>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-maroon">
      
      <div class="inner">
        <h3><?=getStatProductos()?></h3>
        <p><?=JText::_('COM_ERP_PRODUC')?></p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="index.php?option=com_erp&view=productos" class="small-box-footer"><?=JText::_('COM_ERP_VPRODUCR')?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <? }?>
  
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?=getStatUsuarios()?></h3>

        <p><?=JText::_('COM_ERP_USSIS')?></p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-people"></i>
      </div>
      <a href="index.php?option=com_erp&view=gestionusuarios" class="small-box-footer"><?=JText::_('COM_ERP_VUSE')?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-olive">
      <div class="inner">
        <h3><?=getStatRoles()?></h3>

        <p><?=JText::_('COM_ERP_ROLES')?>
</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-apps"></i>
      </div>
      <a href="index.php?option=com_erp&view=gestiongrupos" class="small-box-footer"><?=JText::_('COM_ERP_VROLES')?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

<style>
.fila5{
        width: 19.5%;
        display: inline-block;
    }
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {    
    .fila5{
        width: 100%;
        display: block;
    }
}
</style>
<? if($session->get('ide') == 1){?>
<div class="row">
  <!-- Left col -->
  <section class="col-lg-12">

    <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=JText::_('COM_ERP_IFORM')?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <? 
			$p = getStatProspectos();
			/*$p_1 = getStatsCRM(1);
			$p_2 = getStatsCRM(2);
			$p_3 = getStatsCRM(3);
			$p_4 = getStatsCRM(4);
			$p_5 = getStatsCRM(5);*/?>
           <? switch (getCRMEtapasCant()){
                   case '2':
                       $ancho = "col-md-6";
                       $margen = "";
                       break;
                   case '3':
                       $ancho = "col-md-4";
                       $margen = "";
                       break;
                   case '4':
                       $ancho = "col-md-3";
                       $margen = "";
                       break;
                   case '5':
                       $ancho = "fila5";
                       $margen = "margen";
                       break;
                   case '6':
                       $ancho = "col-md-2";
                       $margen = "margen";
                       break;
               }
            $num = 0;      
          ?>
            <div class="box-body">
               <?  foreach (getCRMEtapas() as $etapa){
                     $id_etapa = getStatsCRM($etapa->id);
                ?>
                    <div class="info-box <?=$etapa->color?> <?=$ancho?>" id="et_<?=$num?>">
                       <? $iconoe = explode('-',$etapa->icono);
                            if($iconoe[0]=='ion'){
                                $icono = 'ion '.$etapa->icono;
                            }else{
                                $icono = 'fa '.$etapa->icono;
                            }
                        ?>
                        <span class="info-box-icon"><i class="<?=$icono?>"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text"><?=$etapa->etapa?></span>
                          <span class="info-box-number"><?=$id_etapa?></span>

                          <div class="progress">
                            <div class="progress-bar" style="width: <?=round((($id_etapa/$p)*100), 2)?>%"></div>
                          </div>
                              <span class="progress-description">
                                <?=round((($id_etapa/$p)*100), 2)?>%
                              </span>
                        </div>
                    </div>                                    
               <? $num++;
                 }?>
            </div>
          </div>

  </section>
</div>
<? }}else{?>
<script>
location.href = 'index.php?option=com_erp&view=clientes&layout=editaempresaus&id=5058';
</script>
<? }?>
<? }else{vistaBloqueada();}?>