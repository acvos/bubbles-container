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

use \ReflectionClass;

/**
 * Generic service factory with position-based (sequential) parameter binding
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class SequentialBindingFactory implements ServiceFactoryInterface
{
    /**
     * Fully qualified class name
     * @var string
     */
    private $className;

    /**
     * Constructor
     * @param string $className Service class name
     */
    public function __construct($className)
    {
        $this->className = (string) $className;
    }

    /**
     * Returns service class name
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters)
    {
        $reflector = new ReflectionClass($this->getClassName());
        $service = $reflector->newInstanceArgs($parameters);

        return $service;
    }
}