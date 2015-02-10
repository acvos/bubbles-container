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
interface ContainerInterface
{
    /**
     * Registeres new descriptor with the container
     * @param  string              $name       local name
     * @param  DescriptorInterface $descriptor descriptor object
     * @return $this
     */
    public function describe($name, DescriptorInterface $descriptor);

    /**
     * Finds and evaluates descriptor in this container
     * @param string $name local name
     * @return mixed
     * @throws DescriptorNotFoundException If there is no descriptor bound to given name
     */
    public function get($name);
}