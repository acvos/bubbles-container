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
 * Strategy adapter for descriptor factory.
 * Applies to srings matching certain pattern.
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class RegexMatchStrategy extends AbstractCreationStrategy
{
    /**
     * Value pattern
     * @var string
     */
    private $pattern;

    /**
     * Constructor
     * @param DescriptorFactoryInterface $factory Descriptor factory
     * @param  string                    $pattern Value pattern
     */
    public function __construct(DescriptorFactoryInterface $factory, $pattern)
    {
        parent::__construct($factory);
        $this->pattern = (string) $pattern;
    }

    /**
     * Returns value pattern
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($value)
    {
        $test = preg_match($this->pattern, (string) $value);

        return $test;
    }

    /**
     * {@inheritdoc}
     */
    public function create($value)
    {
        preg_match($this->pattern, (string) $value, $matches);
        $descriptor = $this->getFactory()->create($matches[1]);

        return $descriptor;
    }
}
