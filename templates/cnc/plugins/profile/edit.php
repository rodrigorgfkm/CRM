<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
	<script type="text/javascript">
		Joomla.twoFactorMethodChange = function(e)
		{
			var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

			jQuery.each(jQuery('#com_users_twofactor_forms_container>div'), function(i, el) {
				if (el.id != selectedPane)
				{
					jQuery('#' + el.id).hide(0);
				}
				else
				{
					jQuery('#' + el.id).show(0);
				}
			});
		}
	</script>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">Editar Perfil</h3>
<form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
	<?php // Iterate through the form fieldsets and display each one. ?>
	<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
		<?php $fields = $this->form->getFieldset($group); ?>
		<?php if (count($fields)) : ?>
		<fieldset>
			<?php // If the fieldset has a label set, display it as the legend. ?>
			<?php if (isset($fieldset->label)) : ?>
			<legend>
				<?php echo JText::_($fieldset->label); ?>
			</legend>
			<?php endif;?>
			<?php // Iterate through the fields in the set and display them. ?>
			<?php foreach ($fields as $field) : ?>
			<?php // If the field is hidden, just display the input. ?>
				<?php if ($field->hidden) : ?>
					<?php echo $field->input; ?>
				<?php else : ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
							<?php endif; ?>
						</div>
						<div class="controls">
							<?php if ($field->fieldname == 'password1') : ?>
								<?php // Disables autocomplete ?> <input type="text" style="display:none">
							<?php endif; ?>
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endif;?>
			<?php endforeach;?>
		</fieldset>
		<?php endif;?>
	<?php break; endforeach;?>

		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
				<a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="profile.save" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
						</div>
					</div>
              	  </div>
              </div>
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_home.php' );?>
			</div>