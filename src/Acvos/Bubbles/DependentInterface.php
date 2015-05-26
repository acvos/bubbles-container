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
 * Item that depends on other items
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
interface DependentInterface
{
    /**
     * Adds dependency
     * @param DescriptorInterface $dependency Dependency descriptor
     * @param string              $name       Dependency name (optional)
     * @return $this
     */
    public function addDependency(DescriptorInterface $dependency, $name = '');

    /**
     * Evaluates dependencies in given context
     * @param ContainerInterface $context Evaluation context
     * @return array
     */
    public function resolveDependencies(ContainerInterface $context);
}
