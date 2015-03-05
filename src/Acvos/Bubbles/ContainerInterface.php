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
     * Finds and evaluates descriptor in this container
     * @param string $name local name
     * @return mixed
     * @throws DescriptorNotFoundException If there is no descriptor bound to given name
     */
    public function get($name);

    /**
     * Binds given name to a given descriptor.
     * @param string $name       Local name
     * @param mixed  $descriptor Value to bind to the name
     * @return $this
     * @throws ImmutableValueException If trying to bind the same name twice
     */
    public function register($name, $descriptor);

    /**
     * Returns descriptor bound to given name
     * @param  string $name Descriptor name
     * @return DescriptorInterface
     */
    public function getDescriptor($name);
}