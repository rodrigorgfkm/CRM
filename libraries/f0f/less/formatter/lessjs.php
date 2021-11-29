<?php
/**
 * @package     FrameworkOnFramework
 * @subpackage  less
 * @copyright   Copyright (C) 2010-2021 Nicholas K. Dionysopoulos / Akeeba Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// Protect from unauthorized access
defined('F0F_INCLUDED') or die;

/**
 * This class is taken verbatim from:
 *
 * lessphp v0.3.9
 * http://leafo.net/lessphp
 *
 * LESS css compiler, adapted from http://lesscss.org
 *
 * Copyright 2012, Leaf Corcoran <leafot@gmail.com>
 * Licensed under MIT or GPLv3, see LICENSE
 *
 * @package  FrameworkOnFramework
 * @since    2.0
 */
class F0FLessFormatterLessjs extends F0FLessFormatterClassic
{
	public $disableSingle = true;

	public $breakSelectors = true;

	public $assignSeparator = ": ";

	public $selectorSeparator = ",";
}