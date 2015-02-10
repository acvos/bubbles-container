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
     * Service factory
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Service dependencies
     * @var array
     */
    private $dependencies = [];

    /**
     * Constructor
     * @param string $className Service class name
     */
    public function __construct($className)
    {
        $this->factory = new SequentialBindingFactory((string) $className);
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