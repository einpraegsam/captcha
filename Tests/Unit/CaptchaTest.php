<?php
namespace ThinkopenAt\Captcha\Tests;

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
class CaptchaTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * Test subject
     *
     * @var \ThinkopenAt\Captcha\Captcha
     */
    protected $subject = null;

    /**
     * Sets up this testcase
     */
    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getAccessibleMock(\ThinkopenAt\Captcha\Captcha::class, ['storeCaptchaInSession']);
    }

    /**
     * Test for "randomString"
     *
     * @test
     * @return void
     */
    public function randomStringTest()
    {
        // Seed random number generator with static value. This should yield
        // the same result at every invocation - assumed the "rand" algorithm
        // is implemented in the same way as on the machine this test has been
        // written on.
        srand(0);

        $result = $this->subject->_call('randomString', range('a', 'z'), 17);
        $this->assertEquals($result, 'vkuuxfithomqjnyxq');
    }

    /**
     * Test for "render"
     *
     * @test
     * @return void
     */
    public function renderTest()
    {
        srand(0);
        $_EXTKEY = 'captcha';
        include('typo3conf/ext/captcha/ext_localconf.php');
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['captcha']['useTTF'] = 1;

        $this->subject->initialize();

        // If the value passed to "storeCaptchaInSession" is different from "IXHF9"
        // the generated image will also be different.
        $this->subject->expects($this->once())->method('storeCaptchaInSession')->with('IXHF9');
        $this->subject->render();

        // Why does "ob_start" make the test risky?
        ob_start();
        $this->subject->output();
        $result = ob_get_clean();
        ob_end_clean();

        // Of course the generated image could differ from system to system due to
        // slight differences in image libraries, png compression, etc.
        // This test was written on: 
        // --------------------------------------------------------------------
        // Linux neodym.atoms.think-open.org 4.4.27-2-default #1 SMP Thu Nov 3 14:59:54 UTC 2016 (5c21e7c) x86_64 x86_64 x86_64 GNU/Linux
        // openSUSE Leap 42.2.20161108
        // --------------------------------------------------------------------
        $this->assertEquals(strlen($result), 815);
        $this->assertEquals(sha1($result), 'dca8351dd837425da48af083a5d8e4cf89a809e7');
    }

}

