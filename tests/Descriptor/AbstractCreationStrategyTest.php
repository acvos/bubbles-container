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

class AbstractCreationStrategyTest extends PHPUnit_Framework_TestCase
{
    const CLASS_UNDER_TEST = 'Acvos\Bubbles\Descriptor\AbstractCreationStrategy';

    private $mockFactory;
    private $testObject;

    public function setUp()
    {
        $this->generateMockFactory();

        $this->testObject = $this
            ->getMockForAbstractClass(self::CLASS_UNDER_TEST, [$this->mockFactory]);
    }

    public function generateMockFactory()
    {
        $this->mockFactory = $this
            ->getMockBuilder('Acvos\Bubbles\DescriptorFactoryInterface')
            ->getMock();
    }

    public function testCreate()
    {
        $testValue = 'blah';
        $testResult = 'something';

        $this->mockFactory
            ->expects($this->once())
            ->method('create')
            ->with($testValue)
            ->will($this->returnValue($testResult));

        $result = $this->testObject->create($testValue);
        $this->assertSame($testResult, $result);
    }
}
