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
 * Adapter for PHP's reflection classes specifically dealing with instance construction
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ConstructorReflector
{
    /**
     * Native PHP's reflector object
     * @var ReflectionClass
     */
    private $class;

    /**
     * The number of required constructor arguments
     * @var integer
     */
    private $requiredParameters = 0;

    /**
     * Total number of constructor arguments
     * @var integer
     */
    private $totalParameters = 0;

    /**
     * Constructor parameter names
     * @var array
     */
    private $parameterNames = [];

    /**
     * Constructor
     * @param string $className   Service class name
     * @param string $$methodName Constructor method name (optional)
     */
    public function __construct($className, $methodName = '__construct')
    {
        $this->class = new ReflectionClass($className);

        if ($this->class->hasMethod($methodName)) {
            $constructor = $this->class->getMethod($methodName);
            if ($constructor->isPublic()) {
                $this->totalParameters    = $constructor->getNumberOfParameters();
                $this->requiredParameters = $constructor->getNumberOfRequiredParameters();

                foreach ($constructor->getParameters() as $parameter) {
                    $this->parameterNames[] = $parameter->getName();
                }
            }
        }
    }

    /**
     * Checks whether given array is associative or sequential
     * @param  array   $array Array to check
     * @return boolean
     */
    private function isArrayAssociative(array $array)
    {
        foreach (array_keys($array) as $key) {
            if (!is_numeric($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extracts constructor parameters from given array
     * @param  array  $parameters All parameters
     * @return array
     */
    public function extractConstructorParameters(array $parameters)
    {
        if (!$this->isArrayAssociative($parameters)) {
            return $parameters;
        }

        $constructorParameters = [];
        foreach ($this->parameterNames as $name) {
            $constructorParameters[] = $parameters[$name];
        }

        return $constructorParameters;
    }

    /**
     * Creates new instance of the class with given constructor arguments
     * @throws BadConfigurationException if the number of given arguments
     * does not match the number of parameters expected by the class constructor
     */
    public function newInstanceArgs(array $parameters)
    {
        $givenParametersCount = count($parameters);
        if ($givenParametersCount < $this->requiredParameters
         || $givenParametersCount > $this->totalParameters) {
            throw new BadConfigurationException("$this->class->name expects $this->requiredParameters to $this->totalParameters constructor parameters, $givenParametersCount given");
        }

        $instance = $this->class->newInstanceArgs($parameters);

        return $instance;
    }
}
