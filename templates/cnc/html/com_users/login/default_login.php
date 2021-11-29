<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$session = JFactory::getSession();

if(date('U') > ($session->get('tiempo') + (60)*4)){
	$session->clear('intentos');    
}

if($session->get('intentos') == '' ){
	$session->clear('intentos');
	$session->set('intentos', 1);
	
	$session->clear('tiempo');
    $session->clear('estimate');
}

JHtml::_('behavior.keepalive');
?>
<script>
jQuery(document).on('ready',function(){
   	var segundos, minutos, estimado;   
    estimado = jQuery('#estimado').val()
    minutos = estimado;
    segundos = Math.abs(jQuery('#segundos_a').val()-59);
    setInterval(function(){
        if(segundos>(-1)){
            if(segundos<10){
                jQuery('.seg').html('0'+segundos);
                if(segundos==0 && minutos==0){
                    location.href="index.php";                    
                }
            }else{
                jQuery('.seg').html(segundos);
            }
            jQuery('.minut').html(minutos);
        }else{
            segundos=59;
            if(minutos>0){
                minutos--;
                jQuery('.minut').html(minutos);
            }
            jQuery('.seg').html(segundos);
        }
        segundos--;      
    }, 1000); 
    
})
</script>
<? 
if($session->get('intentos') < 4){    
?>
<div class="login-logo" style="margin-bottom:0px; padding-bottom:0px">
  <img src="templates/cnc/dist/img/cnc.jpg" width="100%"/>
</div>
<!-- /.login-logo -->
<div class="login-box-body">
  <p class="login-box-msg">Iniciar sesión</p>

  <form autocomplete="off" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well">
    <div class="form-group has-feedback">
      <input type="text" name="username" id="username" autocomplete="off" class="form-control" placeholder="Usuario">
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="Contraseña">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <?php if ($this->tfa): ?>
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label><?php echo $this->form->getField('secretkey')->label; ?></label>
          <?php echo $this->form->getField('secretkey')->input; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
      <div class="col-xs-6" style="padding-left:0px">
        <div class="checkbox icheck">
          <label>
            <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" style="margin-left:0px; position:relative" style="width:auto"/> Recordarme
          </label>
        </div>
      </div>
      <?php endif; ?>
      <!-- /.col -->
      <div class="col-xs-6" style="padding-right:0px">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Autenticarse</button>
        <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
        <?php echo JHtml::_('form.token'); ?>
      </div>
      <!-- /.col -->
    </div>
    
      
    
  </form>
  <!-- /.social-auth-links -->

  <?php
  $usersConfig = JComponentHelper::getParams('com_users');
  if ($usersConfig->get('allowUserRegistration')) : ?>
  <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>" class="text-center"><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
  <?php endif; ?>
  <?
      $intentos = $session->get('intentos') + 1;
      $session->clear('intentos');
      $session->set('intentos', $intentos);
      $session->set('tiempo', date('U'));
  ?>
</div>
<style>
    .botones{
        display: flex;
    }
    .botones a{
        margin-left: 5px;
    }
@media (max-width: 768px){
    .botones{
        display: block
    }
    .botones a{
        margin-left: 0;
    }
    a.pull-right{
        margin-top: 10px;
    }
}
</style>
<div class="login-box-body" style="padding-top:0">
	<div class="row">
    	<div class="col-xs-12 botones">
            <a class="btn btn-default col-xs-12 col-sm-6" href="<?php echo JRoute::_('index.php?option=com_users&view=reset&tmpl=login'); ?>">
                <em class="glyphicon glyphicon-lock"></em>
              Olvidé mi contraseña
            </a>
            <a class="btn btn-default pull-right col-xs-12 col-sm-6" href="<?php echo JRoute::_('index.php?option=com_users&view=remind&tmpl=login'); ?>">
                <em class="glyphicon glyphicon-user"></em>
              Olvidé mi usuario
            </a>
        </div>
    </div>
</div>
<? }else{
    if($session->get('tiempo') == ''){
        $session->set('tiempo', date('U'));                
    }
    if($session->get('estimate')==''){
        $lapso = date('i')+5;
        $session->set('estimate', $lapso);
    }   
    $estimado = $session->get('estimate')-date('i');            
    echo '<div class="col-xs-12 text-center well" style="margin-top:150px">
            <h3>Debe esperar aproximadamente <span class="minut"></span>:<span class="seg"></span> segundos para poder volver a intentarlo</h3>
            <input type="hidden" id="segundos_a" value="'.date('s').'">
            <input type="hidden" id="estimado" value="'.$estimado.'">                    
         </div>';
}?>