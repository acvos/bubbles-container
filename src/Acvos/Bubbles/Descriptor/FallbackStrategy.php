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

/**
 * Default descriptor creation strategy. Applies to anything
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class FallbackStrategy extends AbstractCreationStrategy
{
    /**
     * {@inheritdoc}
     */
    public function appliesTo($value)
    {
        return true;
    }
}