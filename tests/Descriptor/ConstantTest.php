<?php
/*
 * This file is part of the Bubbles package.
 *
 * Copyright (c) 2015 Anton Chernikov <achernikov@acvos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acvos\Bubbles\Descriptor;

use PHPUnit_Framework_TestCase;

class ConstantTest extends PHPUnit_Framework_TestCase
{
    const TEST_VALUE = 'I am a constant';

    private $testObject;

    public function setUp()
    {
        $this->testObject = new Constant(self::TEST_VALUE);
    }

    public function testResolve()
    {
        $this->mockContainer = $this
            ->getMockBuilder('Acvos\Bubbles\ContainerInterface')
            ->getMock();

        $result = $this->testObject->resolve($this->mockContainer);
        $this->assertSame(self::TEST_VALUE, $result);
    }
}
