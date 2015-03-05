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
 * Strategy adapter for descriptor factories
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface CreationStrategyInterface extends DescriptorFactoryInterface
{
    /**
     * Checks if this strategy applies to given value or not
     * @param  mixed $value Value to check
     * @return boolean
     */
    public function appliesTo($value);
}