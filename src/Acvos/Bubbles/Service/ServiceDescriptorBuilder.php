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

use Acvos\Bubbles\DescriptorBuilderInterface;
use Acvos\Bubbles\DescriptorFactoryInterface;

/**
 * Standard service descriptor builder
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ServiceDescriptorBuilder implements DescriptorBuilderInterface
{
    /**
     * Service descriptor under construction
     * @var DescriptorInterface
     */
    private $currentDescriptor;

    /**
     * Descriptor factories indexed by types
     * @var array
     */
    private $descriptorFactories = [];

    /**
     * Service descriptor factory
     * @var DescriptorFactoryInterface
     */
    private $mainFactory = [];

    /**
     * Constructor
     * @param array                      $descriptorFactories Descriptor factories
     * @param DescriptorFactoryInterface $mainFactory         Service descriptor factory
     */
    public function __construct(array $descriptorFactories, DescriptorFactoryInterface $mainFactory)
    {
        $this->mainFactory = $mainFactory;

        foreach ($descriptorFactories as $key => $value) {
            $this->descriptorFactories[$this->normalizeName($key)] = $value;
        }
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
     * Returns descriptor factory by its type
     * @param  string $type Descriptor type
     * @return DescriptorFactoryInterface
     */
    public function getFactory($type)
    {
        $type = $this->normalizeName($type);
        if (!isset($this->descriptorFactories[$type])) {
            throw new OptionNotSupportedException("Unsupported descriptor type: $type");
        }

        return $this->descriptorFactories[$type];
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->currentDescriptor = $this->mainFactory->create([]);

        return $this;
    }

    /**
     * Sets service class
     * @param string $className Service class name
     * @return $this
     */
    public function setClass($className)
    {
        $this->currentDescriptor->setClass($className);

        return $this;
    }

    /**
     * Adds dependency to the current descriptor under construction
     * @param string $type  Dependency type
     * @param string $name  Service parameter name
     * @param mixed  $value Dependency value
     * @return $this
     */
    public function addDependency($type, $name, $value)
    {
        $dependencyDescriptor = $this
            ->getFactory($type)
            ->create([$value]);

        $this->currentDescriptor
            ->setDependency($name, $dependencyDescriptor);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return $this->currentDescriptor;
    }
}