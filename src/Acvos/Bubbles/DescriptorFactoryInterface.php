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
 * Descriptor factory
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface DescriptorFactoryInterface
{
    /**
     * Produces new descriptor
     * @param  array  $arguments Constructor arguments
     * @return object
     */
    public function create(array $arguments = []);
}