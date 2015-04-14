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
     * Returns number of parameters expected by the constructor method
     * of a given reflection class object in following format:
     *     [minCount, maxCount]
     * @param ReflectionClass $reflector Reflector object
     * @return array
     */
    public function countConstructorParameters(ReflectionClass $reflector)
    {
        $maxCount = 0;
        $requiredCount = 0;

        if ($reflector->hasMethod(self::CONSTRUCTOR_METHOD_NAME)) {
            $constructor = $reflector->getMethod(self::CONSTRUCTOR_METHOD_NAME);

            if ($constructor->isPublic()) {
                $maxCount = $constructor->getNumberOfParameters();
                $requiredCount = $constructor->getNumberOfRequiredParameters();
            }
        }

        return [$requiredCount, $maxCount];
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

        list($requiredParameterCount, $maxParameterCount) = $this
            ->countConstructorParameters($reflector);

        $givenParametersCount = count($parameters);
        if ($givenParametersCount < $requiredParameterCount
         || $givenParametersCount > $maxParameterCount) {
            throw new BadConfigurationException("$className expects $requiredParameterCount to $maxParameterCount constructor parameters, $givenParametersCount given");
        } elseif ($givenParametersCount > 0) {
            $service = $reflector->newInstanceArgs($parameters);
        } else {
            $service = new $className();
        }

        return $service;
    }
}
