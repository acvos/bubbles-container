<?php
/*
 * This file is part of the Bubbles package.
 *
 * Copyright (c) 2015 Anton Chernikov <achernikov@acvos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acvos\Bubbles\Service;

use PHPUnit_Framework_TestCase;

class ServiceDescriptorTest extends PHPUnit_Framework_TestCase
{
    private $testObject;
    private $mockServiceFactory;

    public function setUp()
    {
        $this->mockServiceFactory = $this
            ->getMockBuilder('Acvos\Bubbles\Service\ServiceFactoryInterface')
            ->getMock();

        $this->testObject = new ServiceDescriptor($this->mockServiceFactory);
    }

    public function generateMockDescriptor($resolvedWith)
    {
        $mock = $this
            ->getMockBuilder('Acvos\Bubbles\DescriptorInterface')
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('resolve')
            ->will($this->returnValue($resolvedWith));

        return $mock;
    }

    public function testDependencies()
    {
        $mockDependency1 = $this->generateMockDescriptor('service 1');
        $mockDependency2 = $this->generateMockDescriptor('service two');

        $this->testObject->addDependency('dependency 1', $this->mockDependency);
        $this->testObject->addDependency('dependency 2', $this->mockDependency);

        $mockContainer = $this
            ->getMockBuilder('Acvos\Bubbles\ContainerInterface')
            ->getMock();

        $expectedResult = [
            'dependency 1' => 'service 1',
            'dependency 2' => 'service two'
        ];

        $result = $this->testObject->resolveDependencies($mockContainer);
        $this->assertSame($expectedResult, $result);
    }

    public function testResolve()
    {
        $expected = 'some service object';

        // The service should be a singleton, thus $this->once() here
        $this->mockServiceFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($resolvedWith));

        $mockContainer = $this
            ->getMockBuilder('Acvos\Bubbles\ContainerInterface')
            ->getMock();

        $result = $this->testObject->resolve($mockContainer);
        $this->assertSame($expected, $result);

        // Check that the same object is returned the second time
        $result = $this->testObject->resolve($mockContainer);
        $this->assertSame($expected, $result);
    }
}
