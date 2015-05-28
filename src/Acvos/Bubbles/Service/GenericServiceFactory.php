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
     * Inject dependency into a service instance using setter method
     * @param  object $instance Service object
     * @param  string $name     Dependency name
     * @param  mixed  $value    Dependency value
     * @return $this
     * @throws BadConfigurationException If setter method is not found for the dependency
     */
    private function setterInjection($instance, $name, $value)
    {
        if (is_callable([$instance, $name])) {
            $methodName = $name;
        } elseif (is_callable([$instance, 'set' . ucfirst($name)])) {
            $methodName = 'set' . ucfirst($name);
        } else {
            throw new BadConfigurationException("Setter method not found for $name");
        }

        $instance->$methodName($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters)
    {
        $reflector = new ConstructorReflector($this->className);
        $constructorParameters = $reflector->extractConstructorParameters($parameters);

        if (count($constructorParameters) === 0) {
            $service = new $this->className();
        } else {
            $service = $reflector->newInstanceArgs($constructorParameters);
        }

        $setterParameters = array_diff_key($parameters, $constructorParameters);
        foreach ($setterParameters as $name => $value) {
            $this->setterInjection($service, $name, $value);
        }

        return $service;
    }
}
