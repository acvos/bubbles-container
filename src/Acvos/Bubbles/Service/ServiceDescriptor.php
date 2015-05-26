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
class ServiceDescriptor implements ServiceDescriptorInterface
{
    /**
     * Service instance
     * @var object
     */
    private $instance;

    /**
     * Service factory (immutable)
     * @var ServiceFactoryInterface
     */
    private $factory;

    /**
     * Service dependencies
     * @var array
     */
    private $dependencies = [];

    /**
     * Constructor
     * @param string $factory Service factory
     */
    public function __construct(ServiceFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function addDependency(DescriptorInterface $dependency, $name = '')
    {
        if (!empty($name)) {
            $name = (string) $name;
            if (isset($this->dependencies[$name])) {
                throw new ImmutableValueException("Service dependencies are immutable");
            }

            $this->dependencies[$name] = $dependency;
        } else {
            $this->dependencies[] = $dependency;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
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
