<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!empty($this->msg))
{
	echo $this->msg;
}
else
{
	$lang      = JFactory::getLanguage();
	$myrtl     = $this->newsfeed->rtl;
	$direction = " ";

		if ($lang->isRtl() && $myrtl == 0)
		{
			$direction = " redirect-rtl";
		}
		elseif ($lang->isRtl() && $myrtl == 1)
		{
			$direction = " redirect-ltr";
		}
		elseif ($lang->isRtl() && $myrtl == 2)
		{
			$direction = " redirect-rtl";
		}
		elseif ($myrtl == 0)
		{
			$direction = " redirect-ltr";
		}
		elseif ($myrtl == 1)
		{
			$direction = " redirect-ltr";
		}
		elseif ($myrtl == 2)
		{
			$direction = " redirect-rtl";
		}
		$images = json_decode($this->item->images);
	?>
              <div id="contentwrapper">
                <div class="main_content">
                    <div class="row-fluid">
						<div class="span12">
							<h3 class="heading">
                            
		<?php if ($this->item->published == 0) : ?>
			<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>
		<a href="<?php echo $this->item->link; ?>" target="_blank">
		<?php echo str_replace('&apos;', "'", $this->item->name); ?></a>
                            
                            </h3>

	<div class="newsfeed<?php echo $this->pageclass_sfx?><?php echo $direction; ?>">

	<?php if ($this->params->get('show_feed_description')) : ?>
		<div class="feed-description">
			<?php echo str_replace('&apos;', "'", $this->rssDoc->description); ?>
		</div>
	<?php endif; ?>

	<!-- Show items -->
	<?php if (!empty($this->rssDoc[0])) { ?>
	<ol>
		<?php for ($i = 0; $i < $this->item->numarticles; $i++) { ?>
	<?php if (empty($this->rssDoc[$i])) { break; } ?>
	<?php
		$uri = !empty($this->rssDoc[$i]->guid) || !is_null($this->rssDoc[$i]->guid) ? $this->rssDoc[$i]->guid : $this->rssDoc[$i]->uri;
		$uri = substr($uri, 0, 4) != 'http' ? $this->item->link : $uri;
		$text = !empty($this->rssDoc[$i]->content) || !is_null($this->rssDoc[$i]->content) ? $this->rssDoc[$i]->content : $this->rssDoc[$i]->description;
	?>
			<li>
				<?php if (!empty($this->rssDoc[$i]->uri)) : ?>
					<a href="<?php echo $this->rssDoc[$i]->uri; ?>" target="_blank">
					<?php  echo $this->rssDoc[$i]->title; ?></a>
				<?php else : ?>
					<strong><?php  echo '<a target="_blank" href="' . $this->rssDoc[$i]->uri . '">' . $this->rssDoc[$i]->title . '</a>'; ?></strong>
				<?php  endif; ?>
				<?php if ($this->params->get('show_item_description') && !empty($text)) : ?>
					<div class="feed-item-description">
					<?php if ($this->params->get('show_feed_image', 0) == 0)
					{
						$text = JFilterOutput::stripImages($text);
					}
					$text = JHtml::_('string.truncate', $text, $this->params->get('feed_character_count'));
						echo str_replace('&apos;', "'", $text);
					?>
					</div>
				<?php endif; ?>
				</li>
			<?php } ?>
			</ol>
		<?php } ?>
	</div>
<?php } ?>
						</div>
					</div>
              	  </div>
              </div>
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<? require_once( 'components/com_erp/assets/menu_home.php' );?>
			</div>