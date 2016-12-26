<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005-2016 Kraft Bernhard (kraftb@kraftb.at)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Captcha entry script for direct inclusion inside an image tag.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@kraftb.at>
 * @deprecated The use of this script is deprecated. It will get removed in the next version.
 *             Please switch to use the captcha as "eID" script.
 */

session_start();

$PATH_this = dirname(__FILE__) . '/';
define('PATH_site', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

// print_r($_SERVER);
$_GET['eID'] = 'captcha';
require(PATH_site . 'index.php');

