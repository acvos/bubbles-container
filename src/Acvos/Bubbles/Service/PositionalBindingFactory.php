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
class PositionalBindingFactory implements ServiceFactoryInterface
{
    const CONSTRUCTOR_METHOD_NAME = '__construct';

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
     * Returns service class name
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * {@inheritdoc}
     * @throws BadConfigurationException if the number of given parameters
     * does not match the number of parameters expected by the class constructor
     */
    public function create(array $parameters)
    {
        $className = $this->getClassName();
        $reflector = new ReflectionClass($className);

        if ($reflector->hasMethod(self::CONSTRUCTOR_METHOD_NAME)) {
            $constructParameterCount = $reflector
                ->getMethod(self::CONSTRUCTOR_METHOD_NAME)
                ->getNumberOfParameters();
        } else {
            $constructParameterCount = 0;
        }

        $givenParametersCount = count($parameters);
        if ($constructParameterCount !== $givenParametersCount) {
            throw new BadConfigurationException("$className expects $constructParameterCount constructor parameters, $givenParametersCount given");
        } elseif ($constructParameterCount > 0) {
            $service = $reflector->newInstanceArgs($parameters);
        } else {
            $service = new $className();
        }

        return $service;
    }
}