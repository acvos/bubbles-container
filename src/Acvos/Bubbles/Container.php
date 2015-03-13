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
 * DI container
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class Container implements ContainerInterface
{
    /**
     * Service and parameter descriptors bound to local names
     * @var array
     */
    private $scope = [];

    /**
     * Currently active descriptor
     * @var DescriptorInterface
     */
    private $currentDescriptor;

    /**
     * Default descriptor factory
     * @var DescriptorFactoryInterface
     */
    private $descriptorFacotry;

    /**
     * Constructor
     * @param DescriptorFactoryInterface $descriptorFacotry Default descriptor factory
     */
    public function __construct(DescriptorFactoryInterface $descriptorFacotry)
    {
        $this->descriptorFacotry = $descriptorFacotry;
    }

    /**
     * Returns descriptor factory
     * @return DescriptorFactoryInterface
     */
    public function getDescriptorFactory()
    {
        return $this->descriptorFacotry;
    }

    /**
     * Normalizes name string
     * @param  string $name Name
     * @return string
     */
    public function normalizeName($name)
    {
        return strtolower(trim($name));
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->scope);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptor($name)
    {
        if (!isset($this->scope[$name])) {
            throw new DescriptorNotFoundException("Unknown name: $name");
        }

        $descriptor = $this->scope[$name];

        return $descriptor;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        $descriptor = $this->getDescriptor($name);
        $value = $descriptor->resolve($this);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function register($name, $descriptor)
    {
        $name = $this->normalizeName($name);
        if (isset($this->scope[$name])){
            throw new ImmutableValueException("Container content is immutable: $name");
        }

        if (!$descriptor instanceof DescriptorInterface) {
            $descriptor = $this->descriptorFacotry->create($descriptor);
        }

        $this->currentDescriptor = $descriptor;
        $this->scope[$name] = $descriptor;

        return $this;
    }

    /**
     * Positions current descriptor cursor at given name
     * @param  string $name Descriptor name
     * @return $this
     */
    public function select($name)
    {
        $this->currentDescriptor = $this->getDescriptor($name);

        return $this;
    }

    /**
     * Returns current descriptor
     * @return DescriptorInterface
     */
    public function getCurrentDescriptor()
    {
        return $this->currentDescriptor;
    }

    /**
     * Adds dependency to the latest registered descriptor
     * @param string $name  Dependency binding name
     * @param mixed  $value Dependency value
     * @return $this
     * @throws NotSupportedException If current descriptor does not support dependencies
     */
    public function addDependency($name, $value)
    {
        if (!$value instanceof DescriptorInterface) {
            $value = $this->descriptorFacotry->create($value);
        }

        if (!method_exists($this->currentDescriptor, 'setDependency')) {
            $className = get_class($this->currentDescriptor);
            throw new NotSupportedException("Cannot add dependency to an independent descriptor: $className");
        }

        $this->currentDescriptor->setDependency($name, $value);

        return $this;
    }
}
