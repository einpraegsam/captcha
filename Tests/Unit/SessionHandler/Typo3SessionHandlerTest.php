<?php
namespace ThinkopenAt\Captcha\Tests\SessionHandler;

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
use ThinkopenAt\Captcha\SessionHandler\PhpSessionHandler;

/**
 * Testcase class for ThinkopenAt\Captcha\SessionHandler\PhpSessionHandler
 */
class Typo3SessionHandlerTest extends AbstractSessionHandlerTest
{

    /**
     * Name of class being tested
     *
     * @var string
     */
    protected $sessionHandlerClass = 'ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler';

    /**
     * Frontend user mockup object
     *
     * @var object
     */
    protected $frontendUser = null;

    /**
     * Sets up this testcase
     */
    protected function setUp()
    {
        parent::setUp();
        $this->frontendUser = $this->getAccessibleMock('TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication', ['getSessionData', 'setAndSaveSessionData']);
        $this->sessionHandler->_set('frontendUser', $this->frontendUser);
    }

    /**
     * Test for "setSessionData" and "getSessionData"
     *
     * @test
     * @return void
     */
    public function canSetGetSessionData()
    {
        $this->frontendUser->expects($this->once())->method('setAndSaveSessionData')->with('ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler', $this->testDataArray);
        $this->frontendUser->expects($this->once())->method('getSessionData')->with('ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler')->will($this->returnValue($this->testDataArray));
        parent::canSetGetSessionData();
    } 
  
    /**
     * Test for "storeCaptcha" and "retrieveCaptcha"
     *
     * @test
     * @return void
     */
    public function canStoreRetrieveCaptcha()
    {
        $data = array(
            'default' => $this->testDataString
        );
        $this->frontendUser->expects($this->at(0))->method('getSessionData')->with('ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler')->will($this->returnValue(null));
        $this->frontendUser->expects($this->at(1))->method('setAndSaveSessionData')->with('ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler', $data);
        $this->frontendUser->expects($this->at(2))->method('getSessionData')->with('ThinkopenAt\Captcha\SessionHandler\Typo3SessionHandler')->will($this->returnValue($data));
        parent::canStoreRetrieveCaptcha();
    }

}

