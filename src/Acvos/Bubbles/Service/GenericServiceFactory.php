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

/**
 * Generic service factory
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class GenericServiceFactory implements ServiceFactoryInterface
{
    /**
     * Fully qualified class name
     * @var string
     */
    private $className;

    /**
     * Constructor
     * @param string $className Service class name
     * @throws BadConfigurationException If the given class does not exist
     */
    public function __construct($className)
    {
        if (!class_exists($className)) {
            throw new BadConfigurationException("Class not found: $className");
        }

        $this->className = (string) $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters)
    {
        if (count($parameters) === 0) {
            $service = new $this->className();
        } else {
            $reflector = new ConstructorReflector($this->className);
            $constructorParameters = $reflector->extractConstructorParameters($parameters);
            $service = $reflector->newInstanceArgs($constructorParameters);
        }

        return $service;
    }
}
