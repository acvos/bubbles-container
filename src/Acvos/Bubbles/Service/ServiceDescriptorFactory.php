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

use Acvos\Bubbles\DescriptorFactoryInterface;

/**
 * Generic descriptor factory
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ServiceDescriptorFactory implements DescriptorFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($value)
    {
        $serviceFactory = new GenericServiceFactory($value);
        $product = new ServiceDescriptor($serviceFactory);

        return $product;
    }
}