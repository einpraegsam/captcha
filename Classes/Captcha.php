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
 * Captcha class.
 *
 * $Id$
 *
 * @author Kraft Bernhard <kraftb@think-open.at>
 * @copyright 2005-2016
 */
class Captcha {

	/**
	 * The image resource for the rendered captcha
	 *
	 * @var resource
	 */
	protected $imageObject = NULL;

	/**
	 * The characters of which the captcha should consist
	 *
	 * @var resource
	 */
	protected $captchaCharacters = array();

	/**	
	 * The captcha configuration
	 *
	 * @var integer
	 */
	protected $config = array();

	/**	
	 * Default background color (for R + G + B)
	 *
	 * @var integer
	 */
	var $backgroundColorDefault = 244;

	/**	
	 * Default text color (for R + G + B)
	 *
	 * @var integer
	 */
	var $textColorDefault = 0;

	/**	
	 * Default obfuscate color (for R + G + B)
	 *
	 * @var integer
	 */
	var $obfuscateColorDefault = 180;

	/**
	 * Allocates a color resource for the passed color string
	 *
	 * @param string $color: A hexa-decimal color string in the form "#rrggbb".
	 * @param string $default: Default value for R + G + B values if they are not defined in the passed color argument
	 * @return resource The allocated color ressource
	 */
	protected function getColorResourceFromString($color, $default = 0, $imageObject = NULL) {
		$red = $default;
		$green = $default;
		$blue = $default;
		if ($color = trim($color)) {
			if (substr($color, 0, 1) === '#') {
				$color = substr($color, 1);
			}
			if (strlen($color) === 3) {
				$red = hexdec(substr($color, 0, 1).substr($color, 0, 1));
				$green = hexdec(substr($color, 1, 1).substr($color, 1, 1));
				$blue = hexdec(substr($color, 2, 1).substr($color, 2, 1));
			} elseif (strlen($color) === 6) {
				$red = hexdec(substr($color, 0, 2));
				$green = hexdec(substr($color, 2, 2));
				$blue = hexdec(substr($color, 4, 2));
			}
		}
		if ($imageObject !== NULL) {
			return imagecolorallocate($imageObject, $red, $green, $blue);
		} else {
			return imagecolorallocate($this->imageObject, $red, $green, $blue);
		}
	}

	/**
	 * Generates a range of characters within the given bounds
	 *
	 * @param string $start: The character to start with
	 * @param string $end: The character to end with
	 * @return array An array containing the characters within the given bounds
	 */
	protected function getCharacterRange($start, $end) {
		$characters = array();
		$startChar = ord(substr($start, 0, 1));
		$endChar = ord(substr($end, 0, 1));
		if ($startChar > $endChar) {
			// Take care about a reversed range
			$tmp = $startChar;
			$startChar = $endChar;
			$endChar = $tmp;
		}
		for ($c = $startChar; $c <= $endChar; $c++) {
			$char = chr($c);
			$characters[$char] = $char;
		}
		return $characters;
	}

	/**
	 * Initialize captcha characters
	 *
	 * @return void
	 */
	protected function initializeCaptchaCharacters() {
		$numbers = $this->getCharacterRange('0', '9');
		$lowerChars = $this->getCharacterRange('a', 'z');
		$upperChars = $this->getCharacterRange('A', 'Z');
		$this->captchaCharacters = array();
		if (!$this->config['noNumbers']) {
			$this->captchaCharacters = array_merge($this->captchaCharacters, $numbers);
		}
		if (!$this->config['noLower']) {
			$this->captchaCharacters = array_merge($this->captchaCharacters, $lowerChars);
		}
		if (!$this->config['noUpper']) {
			$this->captchaCharacters = array_merge($this->captchaCharacters, $upperChars);
		}
		$excludeChars = $this->config['excludeChars'];
		for ($x = 0; $x <= strlen($excludeChars); $x++) {
			$char = substr($excludeChars, $x, 1);
			unset($this->captchaCharacters[$char]);
		}
		ksort($this->captchaCharacters);
		if (!count($this->captchaCharacters)) {
			throw new \Exception('No captcha characters configured');
		}
	}

	/**
	 * Render the the passed string distorted onto the image object
	 *
	 * @return ThinkopenAt\Captcha\Captchat This instance itself for method chaining
	 */
	protected function distortString($text) {
		// When no TTF get's used.
		$charx = 20;
		$chary = 20;
		$osx = 5;
		$osy = 0;

		$textColor = $this->getColorResourceFromString($this->config['textColor'], $this->textColorDefault);
		$backColor = $this->getColorResourceFromString($this->config['backgroundColor'], $this->backgroundColorDefault);

		$xpos = $this->config['xpos'];

		for ($x = 0; $x < strlen($text); $x++) {
			$char = substr($text, $x, 1);
			$da = rand(0, $this->config['angle']*2) - $this->config['angle'];
			$dx = (int)(rand(0, $this->config['diffx']*2) - $this->config['diffx']);
			$dy = (int)(rand(0, $this->config['diffy']*2) - $this->config['diffy']);
			if ($this->config['useTTF']) {
				$result = imagettftext(
					$this->imageObject,
					$this->config['fontSize'],
					$da,
					$xpos + $dx,
					$this->config['ypos'] + $dy + $this->config['fontSize'],
					$textColor,
					$this->config['fontFile'],
					$char
				);
				if ($this->config['bold']) {
					imagettftext(
						$this->imageObject,
						$this->config['fontSize'],
						$da,
						$xpos + $dx + 1,
						$this->config['ypos'] + $dy + $this->config['fontSize'],
						$textColor,
						$this->config['fontFile'],
						$char
					);
					imagettftext(
						$this->imageObject,
						$this->config['fontSize'],
						$da,
						$xpos + $dx + 1,
						$this->config['ypos'] + $dy + $this->config['fontSize'] + 1,
						$textColor,
						$this->config['fontFile'],
						$char
					);
					imagettftext(
						$this->imageObject,
						$this->config['fontSize'],
						$da,
						$xpos + $dx,
						$this->config['ypos'] + $dy + $this->config['fontSize'] + 1,
						$textColor,
						$this->config['fontFile'],
						$char
					);
				}
				$xpos += ($result[2] - $result[0]);
			} else {
				throw new \Exception('Support of "non-TTF" captcha rendering has been dropped! Sorry for any inconvenience!');
			}
			$xpos += $this->config['letterSpacing'];
		}
		return $this;
	}

	/**
	 * Render a noise (ellipses) onto the background
	 *
	 * @return ThinkopenAt\Captcha\Captcha This instance itself for method chaining
	 */
	protected function noiseBackground() {
		$obfuscationColor = $this->getColorResourceFromString($this->config['obfuscateColor'], $this->obfuscateColorDefault);
		for ($x = 0; $x < $this->config['noises']; $x++) {
			$cx = rand(0, $this->config['imageWidth']);
			$cy = rand(0, $this->config['imageHeight']);
			$cw = rand($this->config['imageWidth']/5, $this->config['imageWidth']);
			$ch = rand($this->config['imageHeight']/5, $this->config['imageHeight']);
			imageellipse($this->imageObject, $cx, $cy, $cw, $ch, $obfuscationColor);
			imageellipse($this->imageObject, $cx+1, $cy, $cw, $ch, $obfuscationColor);
			imageellipse($this->imageObject, $cx+1, $cy+1, $cw, $ch, $obfuscationColor);
			imageellipse($this->imageObject, $cx, $cy+1, $cw, $ch, $obfuscationColor);
		}
		return $this;
	}

	/**
	 * Generates a randomized string from the specified characters and the specified length
	 *
	 * @param string $characters: The characters from which to generated the random string
	 * @param integer $length: The length of the random string which to generate
	 * @return string The generated string
	 */
	protected function randomString($characters, $length) {
		$total = count($characters);
		$str = '';
		for ($x = 0; $x < $length; $x++) {
			$r = rand(0, $total - 1);
			$str .= $characters[$r];
		}
		return $str;
	}

	/**
	 * Initializes variables and character arrays
	 *
	 * @return ThinkopenAt\Captcha\Captchat This instance itself for method chaining
	 */
	public function initialize() {
		$this->config = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['captcha'];
		$this->initializeCaptchaCharacters();
		return $this;
	}

	/**
	 * Renders a captcha image into the "internal" imageObject variable
	 *
	 * @return ThinkopenAt\Captcha\Captchat This instance itself for method chaining
	 */
	public function render() {
		// Create the image resource
		$this->imageObject = imagecreate($this->config['imageWidth'], $this->config['imageHeight']);

		// Fill the image resource with background color
		$backColor = $this->getColorResourceFromString($this->config['backgroundColor'], $this->backgroundColorDefault);
		imagefill($this->imageObject, 0, 0, $backColor);

		$this->noiseBackground();

		// Generate text which is to be shown in captcha.
		$text = $this->randomString(array_values($this->captchaCharacters), $this->config['captchaLength']);
		$this->storeCaptchaInSession($text);

		// Create a distortet string (characters rotated and shifted)
		$this->distortString($text);
		
		return $this;
	}

	/**
	 * Outputs the internal "imageObject" variable as PNG image to the browser
	 *
	 * @return ThinkopenAt\Captcha\Captchat This instance itself for method chaining
	 */
	public function output($type = 'png') {
		@header('Content-type: image/' . $type);
		switch ($type) {
			case 'png':
				imagepng($this->imageObject);
			break;

			default:
				throw new \Exception('Invalid image type for captcha!');
			break;
		}
		return $this;
	}

	/**
	 * Store captcha text in session
	 *
	 * @param string $text: The captcha
	 * @return void
	 */
	protected function storeCaptchaInSession($text) {
		$sessionHandler = GeneralUtility::makeInstance($this->config['sessionHandler']);
		$formId = GeneralUtility::_GET('formId') ? : 'default';
		$sessionHandler->storeCaptcha($text, $formId);
	}

}

