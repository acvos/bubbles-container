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

use Acvos\Bubbles\DescriptorInterface;
use Acvos\Bubbles\ContainerInterface;

/**
 * Primitive immutable configuration parameter
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class Constant implements DescriptorInterface
{
    /**
     * Constant value
     * @var mixed
     */
    private $value;

    /**
     * Constructor
     * @param mixed $value Constant value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ContainerInterface $context)
    {
        return $this->value;
    }
}
