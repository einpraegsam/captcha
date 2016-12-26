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
class Typo3SessionHandler extends AbstractSessionHandler implements SessionHandlerInterface {

	/**
	 * The session variable key
	 *
	 * @var string
	 */
	protected $sessionKey = self::class;

	/**
	 * An "fe_user" object instance. Required for session access.
	 *
	 * @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
	 */
	protected $frontendUser = null;

	/**
	 * Constructor for session handling class
	 *
	 * @return void
	 */
	public function __construct() {
        if (basename($_SERVER['PHP_SELF']) !== 'phpunit') {
		    $this->frontendUser = \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser();
        }
	}

	/**
	 * Get session data
	 *
	 * @return data The session data for the captcha extension
	 */
	protected function getSessionData() {
		$data = $this->frontendUser->getSessionData($this->sessionKey);
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
		$this->frontendUser->setAndSaveSessionData($this->sessionKey, $data);
	}

}

