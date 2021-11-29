<?php /* C:\xampp\htdocs\cnc\administrator\components\com_akeeba\ViewTemplates\Manage\manage_column.blade.php */ ?>
<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

use Akeeba\Backup\Admin\Helper\Utils;

/** @var  \Akeeba\Backup\Admin\View\Manage\Html $this */
/** @var  array $record */

if (!isset($record['remote_filename']))
{
	$record['remote_filename'] = '';
}

$archiveExists    = $record['meta'] == 'ok';
$showManageRemote = in_array($record['meta'], array(
		'ok', 'remote'
	)) && !empty($record['remote_filename']) && (AKEEBA_PRO == 1);
$showUploadRemote = $this->permissions['backup'] && $archiveExists && empty($record['remote_filename']) && ($this->enginesPerProfile[$record['profile_id']] != 'none') && ($record['meta'] != 'obsolete') && (AKEEBA_PRO == 1);
$showDownload     = $this->permissions['download'] && $archiveExists;
$showViewLog      = $this->permissions['backup'] && isset($record['backupid']) && !empty($record['backupid']);
$postProcEngine   = '';
$thisPart         = '';
$thisID           = urlencode($record['id']);

if ($showUploadRemote)
{
	$postProcEngine   = $this->enginesPerProfile[$record['profile_id']];
	$showUploadRemote = !empty($postProcEngine);
}

?>
<div style="display: none">
    <div id="akeeba-buadmin-<?php echo (int)$record['id']; ?>" tabindex="-1">
        <div class="akeeba-renderer-fef">
            <h4><?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_BACKUPINFO'); ?></h4>

            <p>
                <strong><?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVEEXISTS'); ?></strong>
                <br />
                <?php if($record['meta'] == 'ok'): ?>
                    <span class="akeeba-label--success">
				<?php echo \JText::_('JYES'); ?>
			</span>
                <?php else: ?>
                    <span class="akeeba-label--failure">
				<?php echo \JText::_('JNO'); ?>
			</span>
                <?php endif; ?>
            </p>
            <p>
                <strong><?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVEPATH' . ($archiveExists ? '' : '_PAST')); ?></strong>
                <br />
                <span class="akeeba-label--information">
				<?php echo $this->escape(Utils::getRelativePath(JPATH_SITE, dirname($record['absolute_path']))); ?>

				</span>
            </p>
            <p>
                <strong><?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_ARCHIVENAME' . ($archiveExists ? '' : '_PAST')); ?></strong>
                <br />
                <code>
                    <?php echo $this->escape($record['archivename']); ?>

                </code>
            </p>
        </div>

    </div>

    <?php if($showDownload): ?>
        <div id="akeeba-buadmin-download-<?php echo (int)$record['id']; ?>" tabindex="-2" role="dialog">
            <div class="akeeba-renderer-fef">
                <div class="akeeba-block--warning">
                    <h4>
                        <?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_TITLE'); ?>
                    </h4>
                    <p>
                        <?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_WARNING'); ?>
                    </p>
                </div>

                <?php if($record['multipart'] < 2): ?>
                    <a class="akeeba-btn--primary--small comAkeebaManageDownloadButton"
                       data-id="<?php echo $this->escape($record['id']); ?>">
                        <span class="akion-ios-download"></span>
                        <?php echo \JText::_('COM_AKEEBA_BUADMIN_LOG_DOWNLOAD'); ?>
                    </a>
                <?php endif; ?>
                <?php if($record['multipart'] >= 2): ?>
                    <div>
                        <?php echo \JText::sprintf('COM_AKEEBA_BUADMIN_LBL_DOWNLOAD_PARTS', (int)$record['multipart']); ?>
                    </div>
                    <?php for($count = 0; $count < $record['multipart']; $count++): ?>
                    <?php if($count > 0): ?>
                    &bull;
                <?php endif; ?>
                <a class="akeeba-btn--small--dark comAkeebaManageDownloadButton"
                   data-id="<?php echo $this->escape($record['id']); ?>"
                   data-part="<?php echo $this->escape($count); ?>">
                    <span class="akion-android-download"></span>
                    <?php echo \JText::sprintf('COM_AKEEBA_BUADMIN_LABEL_PART', $count); ?>
                </a>
                <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if($showManageRemote): ?>
    <div style="padding-bottom: 3pt;">
        <a class="akeeba-btn--primary akeeba_remote_management_link"
           data-management="index.php?option=com_akeeba&view=RemoteFiles&tmpl=component&task=listactions&id=<?php echo (int)$record['id']; ?>"
           data-reload="index.php?option=com_akeeba&view=Manage"
        >
            <span class="akion-cloud"></span>
            <?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_REMOTEFILEMGMT'); ?>
        </a>
    </div>
<?php elseif($showUploadRemote): ?>
    <a class="akeeba-btn--primary akeeba_upload"
       data-upload="index.php?option=com_akeeba&view=Upload&tmpl=component&task=start&id=<?php echo (int)$record['id']; ?>"
       data-reload="index.php?option=com_akeeba&view=Manage"
       title="<?php echo \JText::sprintf('COM_AKEEBA_TRANSFER_DESC', JText::_("ENGINE_POSTPROC_{$postProcEngine}_TITLE")); ?>">
        <span class="akion-android-upload"></span>
        <?php echo \JText::_('COM_AKEEBA_TRANSFER_TITLE'); ?>
        (<em><?php echo $this->escape($postProcEngine); ?></em>)
    </a>
<?php endif; ?>

<div style="padding-bottom: 3pt">
    <?php if($showDownload): ?>
        <a class="akeeba-btn--<?php echo $showManageRemote || $showUploadRemote ? 'small--grey' : 'green'; ?> akeeba_download_button"
           data-dltarget="#akeeba-buadmin-download-<?php echo (int)$record['id']; ?>"
        >
            <span class="akion-android-download"></span>
            <?php echo \JText::_('COM_AKEEBA_BUADMIN_LOG_DOWNLOAD'); ?>
        </a>
    <?php endif; ?>

    <?php if($showViewLog): ?>
        <a class="akeeba-btn--grey akeebaCommentPopover"
           <?php echo ($record['meta'] != 'obsolete') ? '' : 'disabled="disabled"'; ?>

           href="index.php?option=com_akeeba&view=Log&tag=<?php echo $this->escape($record['tag']); ?>.<?php echo $this->escape($record['backupid']); ?>&profileid=<?php echo (int)$record['profile_id']; ?>"
           data-original-title="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_LOGFILEID'); ?>"
           data-content="<?php echo $this->escape($record['backupid']); ?>">
            <span class="akion-ios-search-strong"></span>
            <?php echo \JText::_('COM_AKEEBA_LOG'); ?>
        </a>
    <?php endif; ?>

    <a class="akeeba-btn--grey--small akeebaCommentPopover akeeba_showinfo_link"
       data-infotarget="#akeeba-buadmin-<?php echo (int)$record['id']; ?>"
       data-content="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LBL_BACKUPINFO'); ?>"
    >
        <span class="akion-information-circled"></span>
    </a>
</div>
