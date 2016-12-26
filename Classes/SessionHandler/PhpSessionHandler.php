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
 * Captcha session handling utility.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@think-open.at>
 * @copyright 2016
 */
class PhpSessionHandler extends AbstractSessionHandler implements SessionHandlerInterface {

	/**
	 * Constructor for session handling class
	 *
	 * @return void
	 */
	public function __construct() {
        if (basename($_SERVER['PHP_SELF']) !== 'phpunit') {
            session_start();
        }
	}

	/**
	 * Store captcha text in PHP session
	 *
	 * @param string $text: The captcha
	 * @return void
	 */
	public function storeCaptcha($text, $formId = 'default') {
		parent::storeCaptcha($text, $formId);

		// TODO: Remove in version 3.0
		// The following line is here for backward compatibility reasons.
		$_SESSION['tx_captcha_string'] = $data;
	}

	/**
	 * Get session data
	 *
	 * @return data The session data for the captcha extension
	 */
	protected function getSessionData() {
		$data = $_SESSION[$this->sessionKey];
		return is_array($data) ? $data : array();
	}

	/**
	 * Set session data
	 *
	 * @param array $data: The session data for the captcha extension
	 * @return void
	 */
	protected function setSessionData($data) {
		if (!is_array($data)) {
			$data = array();
		}
		$_SESSION[$this->sessionKey] = $data;
	}

}

