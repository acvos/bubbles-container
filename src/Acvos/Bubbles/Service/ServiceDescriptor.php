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

use Acvos\Bubbles\DescriptorInterface;
use Acvos\Bubbles\ContainerInterface;
use Acvos\Bubbles\ImmutableValueException;

/**
 * Service configuration
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ServiceDescriptor implements DescriptorInterface
{
    /**
     * Service instance
     * @var object
     */
    private $instance;

    /**
     * Service factory (immutable)
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Service dependencies
     * @var array
     */
    private $dependencies = [];

    /**
     * Defines service factory based on given service class name
     * @param  string $className Service class name
     * @return $this
     */
    public function setClass($className)
    {
        $factory = new SequentialBindingFactory((string) $className);
        $this->setFactory($factory);

        return $this;
    }

    /**
     * Sets service factory
     * @param  ServiceFactoryInterface $factory Service factory
     * @return $this
     * @throws ImmutableValueException If factory has been already set
     */
    public function setFactory(ServiceFactoryInterface $factory)
    {
        if ($this->factory !== null) {
            throw new ImmutableValueException("Service factory has been already set");
        }

        $this->factory = $factory;

        return $this;
    }

    /**
     * Returns service factory
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Returns service dependencies
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Adds service dependency
     * @param string              $name       Dependency name
     * @param DescriptorInterface $descriptor Dependency descriptor object
     * @return $this
     */
    public function setDependency($name, DescriptorInterface $descriptor)
    {
        if (isset($this->dependencies[(string) $name])) {
            throw new ImmutableValueException("Service dependencies are immutable");
        }

        $this->dependencies[(string) $name] = $descriptor;

        return $this;
    }

    /**
     * Evaluates dependency descriptors in given context
     * @return array
     */
    public function resolveDependencies(ContainerInterface $context)
    {
        $values = [];
        foreach ($this->dependencies as $name => $descriptor) {
            $values[$name] = $descriptor->resolve($context);
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ContainerInterface $context)
    {
        if (!is_object($this->instance)) {
            $parameters = $this->resolveDependencies($context);
            $service = $this->factory->create($parameters);
            $this->instance = $service;
        }

        return $this->instance;
    }
}