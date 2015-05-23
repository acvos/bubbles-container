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
 * Abstract adapter turning factories into creation strategies.
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
abstract class AbstractCreationStrategy implements CreationStrategyInterface
{
    /**
     * Descriptor factory
     * @var DescriptorFactoryInterface
     */
    private $factory;

    /**
     * Constructor
     * @param DescriptorFactoryInterface $factory Descriptor factory
     */
    public function __construct(DescriptorFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function appliesTo($value);

    /**
     * {@inheritdoc}
     */
    public function create($value)
    {
        return $this->factory->create($value);
    }
}
