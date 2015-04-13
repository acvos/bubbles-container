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
     * @throws  BadArgumentException If [this condition is met]
     */
    public function extractValue($rawData)
    {
        if (!is_string($rawData)) {
            throw new BadArgumentException('Regex can only be applied to strings');
        }

        $pattern = $this->getPattern();
        $result = preg_match($pattern, $rawData, $matches);
        if (!$result) {
            throw new BadArgumentException("No matches found for $pattern in $rawData");
        }

        return $matches[1];
    }

    /**
     * {@inheritdoc}
     */
    public function appliesTo($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $result = (bool) preg_match($this->getPattern(), $value);

        return $result;
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
