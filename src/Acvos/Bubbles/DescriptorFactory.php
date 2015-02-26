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

use \ReflectionClass;

/**
 * Generic descriptor factory
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class DescriptorFactory implements DescriptorFactoryInterface
{
    /**
     * Descriptor class
     * @var string
     */
    private $class;

    /**
     * Constructor
     * @param string $class Descriptor class
     */
    public function __construct($class)
    {
        $this->class = (string) $class;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $arguments = [])
    {
        $reflector = new ReflectionClass($this->class);
        $product = $reflector->newInstanceArgs($arguments);

        return $product;
    }
}