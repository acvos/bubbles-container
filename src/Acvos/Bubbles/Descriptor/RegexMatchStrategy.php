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
     * Extracts value from given string based on the pattern
     * @param string $rawData string to be matched against the pattern
     * @return string
     */
    public function extractValue($rawData)
    {
        if (is_string($rawData)) {
            preg_match($this->pattern, (string) $rawData, $matches);

            if (count($matches) > 1) {
                return $matches[1];
            }
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($value)
    {
        if (!is_string($value)) {
            return false;
        }

        return (bool) preg_match($this->pattern, (string) $value);
    }

    /**
     * {@inheritdoc}
     */
    public function create($value)
    {
        $value = $this->extractValue($value);
        $descriptor = parent::create($value);

        return $descriptor;
    }
}
