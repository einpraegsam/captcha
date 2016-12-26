<?php
namespace ThinkopenAt\Captcha;

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

use \TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Captcha static utility class.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@think-open.at>
 * @copyright 2016
 */
class Utility {

	/**
	 * Returns an image tag which will show the captcha image
	 *
	 * @param string $formId: The form ID which to use
	 * @return string The captcha img tag
	 */
	public static function makeCaptcha($formId = 'default') {
		// Todo: Let the "Utility" class be non-static so unit tests are possible.
		// Add a "StaticUtility" class for calling methods from within TypoScript, etc.
		// which is simply a wrapper around this non-static class (so instances of this
		// class have to get created in every "StaticUtility" method.
		//
		// Then create a method "getSiteUrl" and call "$this->getSiteUrl()" at this place.
		$captchaPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

		$captchaPath .= 'index.php?eID=captcha&rand=' . rand() . '&formId=' . $formId;
		$tag = '<img src="' . $captchaPath . '" alt="" />';
		return $tag;
	}

	/**
	 * This static public function can get called as TypoScript USER function
	 * to perform the captcha check. It will return "success" or "fail"
	 * which can get compared using an ".if" or "CASE"
	 *
	 * @param string $captchaValue: The captcha value which to check
	 * @param string $formId: The form ID which to use
	 * @return boolean Returns TRUE if the passed captcha value is correct
	 */
	public static function checkCaptchaFromTyposcript($captchaValue, $formId = 'default') {
		$formId = isset($conf['formId']) ? $conf['formId'] : 'default';
		if (self::checkCaptcha($captchaValue, $formId)) {
			return 'success';
		} else {
			return 'fail';
		}
	}

	/**
	 * This static public function can get called from custom code and will
	 * return "true" if the passed $captchaValue or TypoScript stdWrap content
	 * matches the stored captcha value.
	 *
	 * @param string $captchaValue: The captcha value which to check
	 * @param string $formId: The form ID which to use
	 * @return boolean Returns TRUE if the passed captcha value is correct
	 */
	public static function checkCaptcha($captchaValue, $formId = 'default') {
		$captchaSolved = false;

		// Get stored captcha string from session handler
		$sessionHandler = \TYPO3\CMS\Core\Utility\GeneralUtilits::makeInstance($this->conf['sessionHandler']);
		$storedCaptchaValue = (string)$sessionHandler->retrieveCaptcha($formId);
		// If no captcha value has been stored this counts as NOT solved!
		if (empty($storedCaptchaValue)) {
			return false;
		}

		if (!strcmp($captchaValue, $storedCaptchaValue) {
			$captchaSolved = true;
		}
		$sessionHandler->storeCaptcha('', $formId);
		return $captchaSolved;
	}

}

