<?php
/**
 * @package     FrameworkOnFramework
 * @subpackage  database
 * @copyright   Copyright (C) 2010-2021 Nicholas K. Dionysopoulos / Akeeba Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * This file is adapted from the Joomla! Platform. It is used to iterate a database cursor returning F0FTable objects
 * instead of plain stdClass objects
 */

// Protect from unauthorized access
defined('F0F_INCLUDED') or die;

/**
 * Query Building Class.
 *
 * @since       11.1
 * @deprecated  Will be removed when the minimum supported PHP version no longer includes the deprecated PHP `mysql` extension
 */
class F0FDatabaseQueryMysql extends F0FDatabaseQueryMysqli
{
}
