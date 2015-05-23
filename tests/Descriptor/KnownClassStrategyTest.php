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

class KnownClassStrategyTest extends PHPUnit_Framework_TestCase
{
    private $mockFactory;
    private $testObject;

    public function setUp()
    {
        $this->generateMockFactory();

        $this->testObject = new KnownClassStrategy($this->mockFactory);
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

    public function allValues()
    {
        return [
            [null, false],
            [0, false],
            [100500, false],
            [91.6, false],
            ['', false],
            ['some string', false],
            ['100500', false],
            [true, false],
            [false, false],
            [[], false],
            [['a', 'b'], false],
            [new StdClass(), false],
            ['\StdClass', true],
            ['\Countable', false]
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
