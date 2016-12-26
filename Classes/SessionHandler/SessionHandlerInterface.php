<?php
namespace ThinkopenAt\Captcha\SessionHandler;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


/**
 * Interface definition for session handling class.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@think-open.at>
 * @copyright 2016
 */
interface SessionHandlerInterface {

	/**
	 * Store captcha text in PHP/TYPO3 session
	 *
	 * @param string $text: The captcha
	 * @return void
	 */
	public function storeCaptcha($text, $formId = 'default');

	/**
	 * Retrieve captcha text from PHP/TYPO3 session
	 *
	 * @param string $formId: A form id
	 * @return void
	 */
	public function retrieveCaptcha($formId = 'default');

}

