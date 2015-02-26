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
     * Initiates configuration process
     * @return $this
     */
    public function clear();

    /**
     * Returns the new descriptor
     * @return DescriptorInterface
     */
    public function build();
}