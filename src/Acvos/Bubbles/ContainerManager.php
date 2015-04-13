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

use Acvos\Bubbles\Service\ServiceDescriptorFactory;
use Acvos\Bubbles\Descriptor\GenericDescriptorFactory;
use Acvos\Bubbles\Descriptor\FallbackStrategy;
use Acvos\Bubbles\Descriptor\KnownClassStrategy;
use Acvos\Bubbles\Descriptor\RegexMatchStrategy;
use Acvos\Bubbles\Descriptor\PolymorphicDescriptorFactory;

/**
 * System facade
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ContainerManager
{
    /**
     * Service descriptor factory
     * @var PolymorphicDescriptorFactory
     */
    private $factory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $constantFactory   = new GenericDescriptorFactory('Acvos\Bubbles\Descriptor\Constant');
        $defaultStrategy   = new FallbackStrategy($constantFactory);

        $serviceFactory    = new ServiceDescriptorFactory();
        $serviceStrategy   = new KnownClassStrategy($serviceFactory);

        $referenceFactory  = new GenericDescriptorFactory('Acvos\Bubbles\Descriptor\Reference');
        $referenceStrategy = new RegexMatchStrategy($referenceFactory, '/^@(.*)$/');

        $strategies = [$referenceStrategy, $serviceStrategy];

        $this->factory = new PolymorphicDescriptorFactory($strategies, $defaultStrategy);
    }

    /**
     * Returns descriptor factory
     * @return PolymorphicDescriptorFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Creates new container
     * @return Container
     */
    public function spawn()
    {
        $container = new Container($this->factory);

        return $container;
    }
}