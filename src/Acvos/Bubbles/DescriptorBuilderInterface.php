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
 * Descriptor builder
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface DescriptorBuilderInterface
{
    /**
     * Instantiates new descriptor object
     * @param  string $className Service class name
     * @return $this
     */
    public function startNew($className);

    /**
     * Adds dependency to the current descriptor under construction
     * @param string $type  Dependency type
     * @param string $name  Service parameter name
     * @param mixed  $value Dependency value
     * @return $this
     */
    public function addDependency($type, $name, $value);

    /**
     * Returns the descriptor being constructed
     * @return DescriptorInterface
     */
    public function build();
}