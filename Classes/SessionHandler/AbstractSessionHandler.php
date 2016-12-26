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
 * Abstract session handling base class.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@think-open.at>
 * @copyright 2016
 */
abstract class AbstractSessionHandler {

	/**
	 * The session variable key
	 *
	 * @var string
	 */
	protected $sessionKey = 'tx_captcha_array';

	/**
	 * Store captcha text in TYPO3 session
	 *
	 * @param string $text: The captcha
	 * @return void
	 */
	public function storeCaptcha($text, $formId = 'default') {
		$data = $this->getSessionData();
		$data[$formId] = $text;
		$this->setSessionData($data);
	}

	/**
	 * Retrieve captcha text from TYPO3 session
	 *
	 * @param string $formId: A form id
	 * @return void
	 */
	public function retrieveCaptcha($formId = 'default') {
		$data = $this->getSessionData();

		// When PHP7 becomes standard:
		// return $data[$formId] ?? '';

		if (isset($data[$formId])) {
			return $data[$formId];
		} else {
			return '';
		}
	}

	/**
	 * Get session data
	 *
	 * @return data The session data for the captcha extension
	 */
	abstract protected function getSessionData();

	/**
	 * Set session data
	 *
	 * @param array $data: The session data for the captcha extension
	 * @return void
	 */
	abstract protected function setSessionData($data);

}

