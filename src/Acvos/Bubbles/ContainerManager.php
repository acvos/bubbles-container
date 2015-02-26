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

use Acvos\Bubbles\Service\ServiceDescriptorBuilder;

/**
 * System facade
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ContainerManager
{
    /**
     * Service descriptor builder
     * @var ServiceDescriptorBuilder
     */
    private $builder;

    /**
     * Constant descriptor factory
     * @var DescriptorFactory
     */
    private $constantFactory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->constantFactory = new DescriptorFactory('Acvos\Bubbles\Constant');
        $serviceFactory = new DescriptorFactory('Acvos\Bubbles\Service\ServiceDescriptor');
        $referenceFactory = new DescriptorFactory('Acvos\Bubbles\Reference');

        $descriptorFactories = [
            'constant'  => $this->constantFactory,
            'service'   => $serviceFactory,
            'reference' => $referenceFactory
        ];

        $this->builder = new ServiceDescriptorBuilder($descriptorFactories, $serviceFactory);
    }

    /**
     * Returns descriptor builder
     * @return ServiceDescriptorBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Creates new container
     * @return Container
     */
    public function spawn()
    {
        $container = new Container($this->constantFactory);

        return $container;
    }
}