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
use StdClass;

class PositionalBindingFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $testObject = new PositionalBindingFactory('StdClass');
        $this->assertSame('StdClass', $testObject->getClassName());
    }

    /**
     * @expectedException Acvos\Bubbles\Service\BadConfigurationException
     */
    public function testConstructorWithBadClassName()
    {
        $testObject = new PositionalBindingFactory('No\Such\Class');
    }

    public function testCreate()
    {
        $testObject = new PositionalBindingFactory('StdClass');
        $product = $testObject->create([]);
        $this->assertInstanceOf('StdClass', $product);

        $testObject = new PositionalBindingFactory('ReflectionClass');
        $product = $testObject->create(['StdClass']);
        $this->assertInstanceOf('ReflectionClass', $product);
    }

    /**
     * @expectedException Acvos\Bubbles\Service\BadConfigurationException
     */
    public function testCreateWithNotEnoughParameters()
    {
        $testObject = new PositionalBindingFactory('ReflectionClass');
        $product = $testObject->create([]);
    }

    /**
     * @expectedException Acvos\Bubbles\Service\BadConfigurationException
     */
    public function testCreateWithExtraParameters()
    {
        $testObject = new PositionalBindingFactory('StdClass');
        $product = $testObject->create(['blah']);
    }
}
