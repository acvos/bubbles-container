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
 * Reference to a configuration object within evaluation context
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class Reference implements DescriptorInterface
{
    /**
     * Reference object name
     * @var string
     */
    private $linkName;

    /**
     * Constructor
     * @param string $linkName Reference object name
     */
    public function __construct($linkName)
    {
        $this->linkName = (string) $linkName;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ContainerInterface $context)
    {
        return $context->get($this->linkName);
    }
}
