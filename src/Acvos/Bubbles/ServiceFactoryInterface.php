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
 * Service factory
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface ServiceFactoryInterface
{
    /**
     * Instantiates service
     * @param  array $parameters Instantiation parameters
     * @return object
     */
    public function create(array $parameters);
}