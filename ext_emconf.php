<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "captcha".
 *
 * Auto generated 29-11-2016 12:27
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Captcha Library',
  'description' => 'Generates an image with an obfuscated text string which a user must repeat in a form field. Captchas are used to prevent bots from using various types of computing services. Applications include preventing bots from taking part in online polls, submitting entries in a guest book etc. This captcha extension for TYPO3 is meant to be used by multiple other extensions.',
  'category' => 'fe',
  'version' => '2.0.2',
  'state' => 'stable',
  'author' => 'Bernhard Kraft',
  'author_email' => 'kraft@webconsulting.at',
  'author_company' => 'think-open.at GmbH',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '6.2.0-8.2.99',
      'php' => '5.1.0-0.0.0',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'uploadfolder' => false,
  'createDirs' => NULL,
  'clearcacheonload' => false,
);

