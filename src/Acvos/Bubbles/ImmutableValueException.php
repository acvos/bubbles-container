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

use \RuntimeException;

/**
 * Runtime error: attempt to change immutable value
 *
 * @author Anton Chernikov <achernikov@acvos.com>
 */
class ImmutableValueException extends RuntimeException
{
}