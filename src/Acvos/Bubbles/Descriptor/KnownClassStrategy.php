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
use Exception;

/**
 * Strategy adapter for object descriptor factory.
 * Applies to srings containing known class names.
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class KnownClassStrategy extends AbstractCreationStrategy
{
    /**
     * {@inheritdoc}
     */
    public function appliesTo($value)
    {
        if (!is_string($value)) {
            return false;
        }

        return class_exists($value);
    }
}
