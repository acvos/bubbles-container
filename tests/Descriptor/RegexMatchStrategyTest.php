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
    const TEST_PATTERN = '/^#(.*)#$/';

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

    public function allValues()
    {
        return [
            [null, false, ''],
            [0, false, ''],
            [100500, false, ''],
            [91.6, false, ''],
            ['', false, ''],
            ['some string', false, ''],
            ['100500', false, ''],
            ['#this will do#', true, 'this will do'],
            ['#200300#', true, '200300'],
            [true, false, ''],
            [false, false, ''],
            [[], false, ''],
            [['a', 'b'], false, ''],
            [new StdClass(), false, ''],
            ['\StdClass', false, ''],
            ['\Countable', false, '']
        ];
    }

    /**
     * @dataProvider allValues
     */
    public function testExtractValue($provided, $ignored, $expected)
    {
        $result = $this->testObject->extractValue($provided);
        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider allValues
     */
    public function testAppliesTo($provided, $expected, $ignored)
    {
        $result = $this->testObject->appliesTo($provided);
        $this->assertSame($expected, $result);
    }
}
