<?php /* C:\xampp\htdocs\cnc\administrator\components\com_akeeba\ViewTemplates\Manage\default.blade.php */ ?>
<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/** @var  \Akeeba\Backup\Admin\View\Manage\Html $this */
?>
<?php if(version_compare(JVERSION, '3.999.999', 'lt')): ?>
<?php echo \JHtml::_('formbehavior.chosen'); ?>
<?php endif; ?>

<?php if($this->promptForBackupRestoration): ?>
    <?php echo $this->loadAnyTemplate('admin:com_akeeba/Manage/howtorestore_modal'); ?>
<?php endif; ?>

<div class="akeeba-block--info">
    <h4><?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_HOWDOIRESTORE_LEGEND'); ?></h4>
    <p>
		<?php echo \JText::sprintf('COM_AKEEBA_BUADMIN_LABEL_HOWDOIRESTORE_TEXT_' . (AKEEBA_PRO ? 'PRO' : 'CORE'), 'https://www.akeebabackup.com/videos/1212-akeeba-backup-core/1618-abtc04-restore-site-new-server.html', 'index.php?option=com_akeeba&view=Transfer', 'https://www.akeebabackup.com/latest-kickstart-core.zip'); ?>
    </p>
    <p>
        <?php if(!AKEEBA_PRO): ?>
            <?php echo \JText::sprintf('COM_AKEEBA_BUADMIN_LABEL_HOWDOIRESTORE_TEXT_CORE_INFO_ABOUT_PRO', 'https://www.akeebabackup.com/products/akeeba-backup.html'); ?>
        <?php endif; ?>
    </p>
</div>

<div id="j-main-container">
    <form action="index.php" method="post" name="adminForm" id="adminForm" class="akeeba-form">

        <section class="akeeba-panel--33-66 akeeba-filter-bar-container">
            <div class="akeeba-filter-bar akeeba-filter-bar--left akeeba-form-section akeeba-form--inline">
                <div class="akeeba-filter-element akeeba-form-group">
                    <input type="text" name="description" placeholder="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_DESCRIPTION'); ?>"
                           id="filter_description"
                           value="<?php echo $this->escape($this->fltDescription); ?>"
                           title="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_DESCRIPTION'); ?>" />
                </div>

                <div class="akeeba-filter-element akeeba-form-group akeeba-filter-joomlacalendarfix">
                    <?php echo \JHtml::_('calendar', $this->fltFrom, 'from', 'from', '%Y-%m-%d', array('class' => 'input-small')); ?>
                </div>

                <div class="akeeba-filter-element akeeba-form-group akeeba-filter-joomlacalendarfix">
                    <?php echo \JHtml::_('calendar', $this->fltTo, 'to', 'to', '%Y-%m-%d', array('class' => 'input-small')); ?>
                </div>

                <div class="akeeba-filter-element akeeba-form-group">
                    <button class="akeeba-btn--grey akeeba-btn--icon-only akeeba-btn--small akeeba-hidden-phone"
                            type="submit" title="<?php echo \JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
                        <span class="akion-search"></span>
                    </button>
                </div>

                <div class="akeeba-filter-element akeeba-form-group">
                    <?php /* Joomla 3.x: Chosen does not work with attached event handlers, only with inline event scripts (e.g. onchange) */ ?>
                    <?php if(version_compare(JVERSION, '3.999.999', 'lt')): ?>
                        <?php echo \JHtml::_('select.genericlist', $this->profilesList, 'profile', ['list.select' => $this->fltProfile, 'list.attr' => ['class' => 'advancedSelect', 'onchange' => 'document.forms.adminForm.submit();'], 'id' => 'comAkeebaManageProfileSelector']); ?>
                    <?php else: ?>
                        <?php echo \JHtml::_('select.genericlist', $this->profilesList, 'profile', ['list.select' => $this->fltProfile, 'list.attr' => ['class' => 'advancedSelect'], 'id' => 'comAkeebaManageProfileSelector']); ?>
                    <?php endif; ?>

                </div>
            </div>

			<div class="akeeba-filter-bar akeeba-filter-bar--right">
				<?php echo \JHtml::_('FEFHelper.browse.orderheader', null, $this->sortFields, $this->getPagination(), $this->lists->order, $this->lists->order_Dir); ?>
			</div>
        </section>

        <table class="akeeba-table akeeba-table--striped" id="itemsList">
            <thead>
            <tr>
                <th width="32">
                    <?php echo \JHtml::_('FEFHelper.browse.checkall'); ?>
                </th>
                <th width="48" class="akeeba-hidden-phone">
					<?php echo FOF30\Utils\FEFHelper\BrowseView::sortGrid('id', 'COM_AKEEBA_BUADMIN_LABEL_ID') ?>
                </th>
                <th>
					<?php echo FOF30\Utils\FEFHelper\BrowseView::sortGrid('description', 'COM_AKEEBA_BUADMIN_LABEL_DESCRIPTION') ?>
                </th>
                <th class="akeeba-hidden-phone">
					<?php echo FOF30\Utils\FEFHelper\BrowseView::sortGrid('profile_id', 'COM_AKEEBA_BUADMIN_LABEL_PROFILEID') ?>
                </th>
                <th width="80">
                    <?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_DURATION'); ?>
                </th>
                <th width="40">
                    <?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_STATUS'); ?>
                </th>
                <th width="80" class="akeeba-hidden-phone">
                    <?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_SIZE'); ?>
                </th>
                <th class="akeeba-hidden-phone">
                    <?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_MANAGEANDDL'); ?>
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="11" class="center">
                    <?php echo $this->pagination->getListFooter(); ?>

                </td>
            </tr>
            </tfoot>
            <tbody>
            <?php if(empty($this->items)): ?>
                <tr>
                    <td colspan="11" class="center">
                        <?php echo \JText::_('COM_AKEEBA_BACKUP_STATUS_NONE'); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if( ! (empty($this->items))): ?>
				<?php $id = 1; $i = 0; ?>
                <?php foreach($this->items as $record): ?>
					<?php
					$id = 1 - $id;
					list($originDescription, $originIcon) = $this->getOriginInformation($record);
					list($startTime, $duration, $timeZoneText) = $this->getTimeInformation($record);
					list($statusClass, $statusIcon) = $this->getStatusInformation($record);
					$profileName = $this->getProfileName($record);
					?>
                    <tr class="row<?php echo $id; ?>">
                        <td><?php echo \JHtml::_('grid.id', ++$i, $record['id']); ?></td>
                        <td class="akeeba-hidden-phone">
                            <?php echo $this->escape($record['id']); ?>

                        </td>
                        <td>
						<span class="<?php echo $originIcon; ?> akeebaCommentPopover" rel="popover"
                              title="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_ORIGIN'); ?>"
                              data-content="<?php echo $this->escape($originDescription); ?>"></span>
                            <?php if( ! (empty($record['comment']))): ?>
                                <span class="akion-help-circled akeebaCommentPopover" rel="popover"
                                      data-content="<?php echo $this->escape($record['comment']); ?>"></span>
                            <?php endif; ?>
                            <a href="<?php echo $this->escape(JUri::base()); ?>index.php?option=com_akeeba&view=Manage&task=showcomment&id=<?php echo $this->escape($record['id']); ?>">
                                <?php echo $this->escape(empty($record['description']) ? JText::_('COM_AKEEBA_BUADMIN_LABEL_NODESCRIPTION') : $record['description']); ?>


                            </a>
                            <br />
                            <div class="akeeba-buadmin-startdate" title="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_START'); ?>">
                                <small>
                                    <span class="akion-calendar"></span>
                                    <?php echo $this->escape($startTime); ?> <?php echo $this->escape($timeZoneText); ?>

                                </small>
                            </div>
                        </td>
                        <td class="akeeba-hidden-phone">
                            #<?php echo $this->escape((int)$record['profile_id']); ?>. <?php echo $this->escape($profileName); ?>


                            <br />
                            <small>
                                <em><?php echo $this->escape($this->translateBackupType($record['type'])); ?></em>
                            </small>
                        </td>
                        <td>
                            <?php echo $this->escape($duration); ?>

                        </td>
                        <td>
						<span class="<?php echo $statusClass; ?> akeebaCommentPopover" rel="popover"
                              title="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_STATUS'); ?>"
                              data-content="<?php echo \JText::_('COM_AKEEBA_BUADMIN_LABEL_STATUS_' . $record['meta']); ?>">
							<span class="<?php echo $statusIcon; ?>"></span>
						</span>
                        </td>
                        <td class="akeeba-hidden-phone">
                            <?php if($record['meta'] == 'ok'): ?>
                                <?php echo $this->escape($this->formatFilesize($record['size'])); ?>


                            <?php elseif($record['total_size'] > 0): ?>
                                <i><?php echo $this->formatFilesize($record['total_size']); ?></i>
                                <?php else: ?>
                                &mdash;
                            <?php endif; ?>
                        </td>
                        <td class="akeeba-hidden-phone">
                            <?php echo $this->loadAnyTemplate('admin:com_akeeba/Manage/manage_column', ['record' => &$record]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="akeeba-hidden-fields-container">
            <input type="hidden" name="option" id="option" value="com_akeeba" />
            <input type="hidden" name="view" id="view" value="Manage" />
            <input type="hidden" name="boxchecked" id="boxchecked" value="0" />
            <input type="hidden" name="task" id="task" value="default" />
            <input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->escape($this->lists->order); ?>" />
            <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $this->escape($this->lists->order_Dir); ?>" />
            <input type="hidden" name="<?php echo $this->container->platform->getToken(true); ?>" value="1" />
        </div>
    </form>
</div>
