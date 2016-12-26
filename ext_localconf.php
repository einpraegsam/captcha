<?php
defined('TYPO3_MODE') or die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['captcha'] = 'EXT:captcha/Resources/Public/Scripts/captcha.php';

$_EXTCONF = unserialize($_EXTCONF);    // unserializing the configuration so we can use it here
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = array(
	'useTTF' => (int)($_EXTCONF['useTTF']) ? 1 : 0,
	'sessionHandler' => (int)($_EXTCONF['usePHPsession']) ? 'ThinkopenAt\Captcha\SessionHandler\PhpSessionHandler' : 'ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler',
	'imageHeight' => (int)($_EXTCONF['imgHeight']) ? : 35,
	'imageWidth' => (int)($_EXTCONF['imgWidth']) ? : 135,
	'captchaLength' => (int)($_EXTCONF['captchaChars']) ? : 5,
	'noNumbers' => (int)($_EXTCONF['noNumbers']) ? true : false,
	'noLower' => (int)($_EXTCONF['noLower']) ? true : false,
	'noUpper' => (int)($_EXTCONF['noUpper']) ? true : false,
	'letterSpacing' => (int)($_EXTCONF['letterSpacing']) ? : 10,
	'fontSize' => (int)($_EXTCONF['fontSize']) ? : 16,
	'fontFile' => trim($_EXTCONF['fontFile']) ? : PATH_site . 'typo3conf/ext/captcha/Resources/Private/Fonts/vera.ttf',
	'bold' => (int)($_EXTCONF['bold']) ? true : false,
	'angle' => (int)($_EXTCONF['angle']) ? : 35,
	'diffx' => (int)($_EXTCONF['diffx']) ? : 0,
	'diffy' => (int)($_EXTCONF['diffy']) ? : 2,
	'xpos' => (int)($_EXTCONF['xpos']) ? : 3,
	'ypos' => (int)($_EXTCONF['ypos']) ? : 4,
	'noises' => (int)($_EXTCONF['noises']) ? : 6,
	'backgroundColor' => trim($_EXTCONF['backcolor']) ? : '#f4f4f4',
	'textColor' => trim($_EXTCONF['textcolor']) ? : '#000000',
	'obfuscateColor' => trim($_EXTCONF['obfusccolor']) ? : '#828482',
	'excludeChars' => trim($_EXTCONF['excludeChars']) ? : '',
);

