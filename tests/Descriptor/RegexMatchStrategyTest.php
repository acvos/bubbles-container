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

class RegexMatchStrategyTest extends PHPUnit_Framework_TestCase
{
    const TEST_PATTERN = '/#(.*)#/';

    private $mockFactory;
    private $testObject;

    public function setUp()
    {
        $this->generateMockFactory();

        $this->testObject = new RegexMatchStrategy($this->mockFactory, self::TEST_PATTERN);
    }

    public function generateMockFactory()
    {
        $this->mockFactory = $this
            ->getMockBuilder('Acvos\Bubbles\DescriptorFactoryInterface')
            ->getMock();
    }

    public function testConstructor()
    {
        $factory = $this->testObject->getFactory();
        $this->assertSame($this->mockFactory, $factory);

        $pattern = $this->testObject->getPattern();
        $this->assertSame(self::TEST_PATTERN, $pattern);
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

        $result = $this->testObject->create('#' . $testValue . '#');
        $this->assertSame($testResult, $result);
    }

    public function matchingValues() {
        return [
            ['#some string value#', 'some string value'],
            ['#some string# #and again#', 'some string# #and again'],
            ['#200300#', '200300']
        ];
    }

    /**
     * @dataProvider matchingValues
     */
    public function testExtractValue($provided, $expected)
    {
        $result = $this->testObject->extractValue($provided);
        $this->assertSame($expected, $result);
    }

    public function badValues() {
        return [
            [null],
            [0],
            [100500],
            [91.6],
            [''],
            ['some string'],
            ['100500'],
            [true],
            [false],
            [[]],
            [['a', 'b']],
            [new StdClass()],
            ['\StdClass'],
            ['\Countable']
        ];
    }

    /**
     * @dataProvider badValues
     * @expectedException Acvos\Bubbles\Descriptor\BadArgumentException
     */
    public function testExtractValueWithBadArguments($provided)
    {
        $result = $this->testObject->extractValue($provided);
    }

    public function allValues()
    {
        $values = array_merge(
            array_map(function ($value) {
                return [$value[0], false];
            }, $this->badValues()),
            array_map(function ($value) {
                return [$value[0], true];
            }, $this->matchingValues())
        );

        return $values;
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
