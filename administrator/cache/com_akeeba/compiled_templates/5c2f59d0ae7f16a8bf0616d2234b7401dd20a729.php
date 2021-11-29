<?php /* C:\xampp\htdocs\cnc\administrator\components\com_akeeba\ViewTemplates\ControlPanel\profile.blade.php */ ?>
<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

/** @var $this \Akeeba\Backup\Admin\View\ControlPanel\Html */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * Call this template with:
 * [
 * 	'returnURL' => 'index.php?......'
 * ]
 * to set up a custom return URL
 */
?>
<?php if(version_compare(JVERSION, '3.999.999', 'lt')): ?>
	<?php echo \JHtml::_('formbehavior.chosen'); ?>
<?php endif; ?>

<div class="akeeba-panel">
	<form action="index.php" method="post" name="switchActiveProfileForm" id="switchActiveProfileForm">
		<input type="hidden" name="option" value="com_akeeba" />
		<input type="hidden" name="view" value="ControlPanel" />
		<input type="hidden" name="task" value="SwitchProfile" />
		<?php if(isset($returnURL)): ?>
		<input type="hidden" name="returnurl" value="<?php echo $returnURL; ?>" />
		<?php endif; ?>
		<input type="hidden" name="<?php echo $this->container->platform->getToken(true); ?>" value="1" />

	    <label>
			<?php echo \JText::_('COM_AKEEBA_CPANEL_PROFILE_TITLE'); ?>: #<?php echo $this->profileId; ?>


		</label>

		<?php /* Joomla 3.x: Chosen does not work with attached event handlers, only with inline event scripts (e.g. onchange) */ ?>
		<?php if(version_compare(JVERSION, '3.999.999', 'lt')): ?>
			<?php echo \JHtml::_('select.genericlist', $this->profileList, 'profileid', ['list.select' => $this->profileId, 'id' => 'comAkeebaControlPanelProfileSwitch', 'list.attr' => ['class' => 'advancedSelect', 'onchange' => 'document.forms.switchActiveProfileForm.submit();']]); ?>
		<?php else: ?>
			<?php echo \JHtml::_('select.genericlist', $this->profileList, 'profileid', ['list.select' => $this->profileId, 'id' => 'comAkeebaControlPanelProfileSwitch', 'list.attr' => ['class' => 'advancedSelect']]); ?>
		<?php endif; ?>

		<button class="akeeba-btn akeeba-hidden-phone" type="submit">
			<span class="akion-forward"></span>
			<?php echo \JText::_('COM_AKEEBA_CPANEL_PROFILE_BUTTON'); ?>
		</button>
	</form>
</div>
