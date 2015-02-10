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
class Container implements ContainerInterface
{
    /**
     * Service and parameter descriptors bound to local names
     * @var array
     */
    private $scope = [];

    /**
     * Normalizes name string
     * @param  string $name Name
     * @return string
     */
    public function normalizeName($name)
    {
        return strtolower(trim($name));
    }

    /**
     * {@inheritdoc}
     */
    public function describe($name, DescriptorInterface $descriptor)
    {
        $name = $this->normalizeName($name);
        $this->scope[$name] = $descriptor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if (!isset($this->scope[$name])){
            throw new DescriptorNotFoundException("Unknown name: $name");
        }

        $descriptor = $this->scope[$name];

        return $descriptor->resolve($this);
    }
}