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
use StdClass;

class FallbackStrategyTest extends PHPUnit_Framework_TestCase
{
    private $mockFactory;
    private $testObject;

    public function setUp()
    {
        $this->mockFactory = $this
            ->getMockBuilder('Acvos\Bubbles\DescriptorFactoryInterface')
            ->getMock();

        $this->testObject = new FallbackStrategy($this->mockFactory);
    }

    public function testConstructor()
    {
        $factory = $this->testObject->getFactory();
        $this->assertSame($this->mockFactory, $factory);
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

    public function allValues()
    {
        return [
            [null, true],
            [0, true],
            [100500, true],
            [91.6, true],
            ['', true],
            ['some string', true],
            ['100500', true],
            [true, true],
            [false, true],
            [[], true],
            [['a', 'b'], true],
            [new StdClass(), true],
            ['\StdClass', true],
            ['\Countable', true]
        ];
    }

    /**
     * @dataProvider allValues
     */
    public function testAppliesTo($provided, $expected)
    {
        $result = $this->testObject->appliesTo($provided);
        $this->assertSame($expected, $result);
    }
}
