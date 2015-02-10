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
 * Standard service descriptor builder
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ServiceDescriptorBuilder implements DescriptorBuilderInterface
{
    /**
     * Service descriptor under construction
     * @var ServiceDescriptor
     */
    private $currentDescriptor;

    /**
     * Descriptor types indexed by dependency types
     * @var array
     */
    private $dependencyTypes = [];

    /**
     * Constructor
     * @param array $dependencyTypes Descriptor classes
     */
    public function __construct(array $dependencyTypes)
    {
        $this->dependencyTypes = $dependencyTypes;
    }

    /**
     * Returns dependency descriptor class name by dependency type
     * @param  string $type Dependency type
     * @return string
     */
    public function getDependencyClass($type)
    {
        if (!isset($this->dependencyTypes[(string) $type])) {
            throw new OptionNotSupportedException("Dependency type $type is not supported.");
        }

        return $this->dependencyTypes[(string) $type];
    }

    /**
     * {@inheritdoc}
     */
    public function startNew($className)
    {
        $this->currentDescriptor = new ServiceDescriptor($className);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addDependency($type, $name, $value)
    {
        $className = $this->getDependencyClass($type);
        $dependencyDescriptor = new $className($value);

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