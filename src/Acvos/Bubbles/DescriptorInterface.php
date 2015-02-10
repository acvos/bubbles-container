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
 * Configuration item
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface DescriptorInterface
{
    /**
     * Returns described item in given context
     * @param  ContainerInterface $context Container providing evaluation context
     * @return mixed
     */
    public function resolve(ContainerInterface $context);
}