<?php
/*
 * This file is part of the Bubbles package.
 *
 * Copyright (c) 2015 Anton Chernikov <achernikov@acvos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acvos\Bubbles;

use PHPUnit_Framework_TestCase;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    private $mockFactory;
    private $testObject;

    public function setUp()
    {
        $this->mockFactory = $this
            ->getMockBuilder('Acvos\Bubbles\DescriptorFactoryInterface')
            ->getMock();

        $this->testObject = new Container($this->mockFactory);
    }

    public function testConstructor()
    {
        $factory = $this->testObject->getDescriptorFactory();
        $this->assertSame($this->mockFactory, $factory);

        $descriptor = $this->testObject->getCurrentDescriptor();
        $this->assertNull($descriptor);

        $count = count($this->testObject);
        $this->assertSame(0, $count);
    }
}
