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
     * Default descriptor factory
     * @var DescriptorFactoryInterface
     */
    private $defaultDescriptorFacotry;

    /**
     * Constructor
     * @param DescriptorFactoryInterface $defaultDescriptorFacotry Default descriptor factory
     */
    public function __construct(DescriptorFactoryInterface $defaultDescriptorFacotry)
    {
        $this->defaultDescriptorFacotry = $defaultDescriptorFacotry;
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
    public function register($name, DescriptorInterface $descriptor)
    {
        $name = $this->normalizeName($name);
        $this->scope[$name] = $descriptor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if (!isset($this->scope[$name])){
            throw new DescriptorNotFoundException("Unknown name: $name");
        }

        $descriptor = $this->scope[$name];

        return $descriptor->resolve($this);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if (isset($this->scope[$name])){
            throw new ImmutableValueException("Container content is immutable: $name");
        }

        $descriptor = $this->defaultDescriptorFacotry->create([$value]);
        $this->register($name, $descriptor);

        return $this;
    }
}
