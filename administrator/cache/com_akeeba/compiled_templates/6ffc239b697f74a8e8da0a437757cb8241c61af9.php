<?php /* C:\xampp\htdocs\cnc\administrator\components\com_akeeba\ViewTemplates\ControlPanel\sidebar_status.blade.php */ ?>
<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

/** @var $this \Akeeba\Backup\Admin\View\ControlPanel\Html */

// Protect from unauthorized access
defined('_JEXEC') or die();

?>
<div class="akeeba-panel">
    <header class="akeeba-block-header">
        <h3><?php echo \JText::_('COM_AKEEBA_CPANEL_LABEL_STATUSSUMMARY'); ?></h3>
    </header>

    <div>
        <?php /* Backup status summary */ ?>
        <?php echo $this->statusCell; ?>


        <?php /* Warnings */ ?>
        <?php if($this->countWarnings): ?>
            <div>
                <?php echo $this->detailsCell; ?>

            </div>
            <hr />
        <?php endif; ?>

        <?php /* Version */ ?>
        <p class="ak_version">
            <?php echo \JText::_('COM_AKEEBA'); ?> <?php echo AKEEBA_PRO ? 'Professional ' : 'Core';; ?> <?php echo AKEEBA_VERSION; ?> (<?php echo AKEEBA_DATE; ?>)
        </p>

        <?php /* Changelog */ ?>
        <a href="#" id="btnchangelog" class="akeeba-btn--primary">CHANGELOG</a>

        <div id="akeeba-changelog" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
            <div class="akeeba-renderer-fef">
                <div class="akeeba-panel--info">
                    <header class="akeeba-block-header">
                        <h3>
                            <?php echo \JText::_('CHANGELOG'); ?>
                        </h3>
                    </header>
                    <div id="DialogBody">
                        <?php echo $this->formattedChangelog; ?>

                    </div>
                </div>
            </div>
        </div>

        <?php /* Donation CTA */ ?>
        <?php if( ! (AKEEBA_PRO)): ?>
            <a
                    href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KDVQPB4EREBPY&source=url"
                    class="akeeba-btn-green">
                Donate via PayPal
            </a>
        <?php endif; ?>

        <?php /* Reload update information */ ?>
        <?php if(!AKEEBA_PRO): ?>
            <p style="margin: 0.5em 0">
                <a href="index.php?option=com_akeeba&view=ControlPanel&task=reloadUpdateInformation"
                   class="akeeba-btn--dark">
                    <?php echo \JText::_('COM_AKEEBA_CPANEL_MSG_RELOADUPDATE'); ?>
                </a>
            </p>
        <?php else: ?>
            <a href="index.php?option=com_akeeba&view=ControlPanel&task=reloadUpdateInformation"
               class="akeeba-btn--dark">
                <?php echo \JText::_('COM_AKEEBA_CPANEL_MSG_RELOADUPDATE'); ?>
            </a>
        <?php endif; ?>

        <?php /* Pro upsell */ ?>
        <?php if(!AKEEBA_PRO && (time() - $this->lastUpsellDismiss < 1296000)): ?>
            <p style="margin: 0.5em 0">
                <a href="https://www.akeebabackup.com/landing/akeeba-backup.html"
                   class="akeeba-btn--ghost--small">
                    <span class="aklogo-backup-j"></span>
                    <?php echo \JText::_('COM_AKEEBA_CONTROLPANEL_BTN_LEARNMORE'); ?>
                </a>
            </p>
        <?php endif; ?>
    </div>
</div>
