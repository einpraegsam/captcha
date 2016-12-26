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
 * Abstract testcase base class for ThinkopenAt\Captcha\SessionHandler\AbstractSessionHandler
 */
abstract class AbstractSessionHandlerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * Name of class being tested
     *
     * @var string
     */
    protected $sessionHandlerClass = '';

    /**
     * Test subject
     *
     * @var \ThinkopenAt\Captcha\SessionHandler\SessionHandlerInterface
     */
    protected $sessionHandler = null;

    /**
     * Test data array
     *
     * @var array
     */
    protected $testDataArray = array(
        'test' => '123',
        'sub' => array(
            'apple' => 'strawberry',
            'kiwi' => 'orange',
        ),
    );

    /**
     * Test data string
     *
     * @var string
     */
    protected $testDataString = 'test123-ABC';

    /**
     * Sets up this testcase
     */
    protected function setUp()
    {
        parent::setUp();
        if (!class_exists($this->sessionHandlerClass)) {
            throw new \Exception('Invalid session handler class!');
        }
        $this->sessionHandler = $this->getAccessibleMock($this->sessionHandlerClass, ['dummy']);
    }

    /**
     * Test for "setSessionData" and "getSessionData"
     *
     * @test
     * @return void
     */
    public function canSetGetSessionData()
    {
        $this->sessionHandler->_call('setSessionData', $this->testDataArray);
        $check = $this->sessionHandler->_call('getSessionData');
        $this->assertEquals($this->testDataArray, $check);
    }

    /**
     * Test for "storeCaptcha" and "retrieveCaptcha"
     *
     * @test
     * @return void
     */
    public function canStoreRetrieveCaptcha()
    {
        $this->sessionHandler->_call('storeCaptcha', $this->testDataString);
        $check = $this->sessionHandler->_call('retrieveCaptcha');
        $this->assertEquals($this->testDataString, $check);
    }

}

