<?php
/*
 * This file is part of the Bubbles package.
 *
 * Copyright (c) 2015 Anton Chernikov <achernikov@acvos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Acvos\Bubbles\Descriptor;

use Acvos\Bubbles\DescriptorFactoryInterface;

/**
 * Polymorphic factory for descriptors.
 * Creates descriptor object based on the value it will be representing
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class PolymorphicDescriptorFactory implements DescriptorFactoryInterface
{
    /**
     * Descriptor creation strategies
     * @var array
     */
    private $strategies = [];

    /**
     * Default descriptor creation strategy
     * @var CreationStrategyInterface
     */
    private $defaultStrategy;

    /**
     * Constructor
     * @param array                     $strategies      Descriptor creation strategies
     * @param CreationStrategyInterface $defaultStrategy Fallback strategy
     */
    public function __construct(array $strategies, CreationStrategyInterface $defaultStrategy)
    {
        $this->strategies      = $strategies;
        $this->defaultStrategy = $defaultStrategy;
    }

    /**
     * Returns descriptor factory applicable to given value
     * @param  mixed $value Descriptor value
     * @return DescriptorFactoryInterface
     */
    public function getStrategy($value)
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->appliesTo($value)) {
                return $strategy;
            }
        }

        return $this->defaultStrategy;
    }

    /**
     * {@inheritdoc}
     */
    public function create($value)
    {
        $strategy = $this->getStrategy($value);
        $product = $strategy->create($value);

        return $product;
    }
}