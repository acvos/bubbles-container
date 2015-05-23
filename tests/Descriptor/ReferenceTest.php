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

class ReferenceTest extends PHPUnit_Framework_TestCase
{
    const TEST_VALUE = 'I am a reference';

    private $testObject;

    public function setUp()
    {
        $this->testObject = new Reference(self::TEST_VALUE);
    }

    public function testResolve()
    {
        $mockContainer = $this
            ->getMockBuilder('Acvos\Bubbles\ContainerInterface')
            ->getMock();

        $mockContainer
            ->expects($this->once())
            ->method('get')
            ->with(self::TEST_VALUE)
            ->will($this->returnValue('it works!'));

        $result = $this->testObject->resolve($this->mockContainer);
        $this->assertSame('it works!', $result);
    }
}
