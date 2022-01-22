<?php

declare(strict_types=1);

namespace PHP\Interfaces;

/**
 * Describes any object that can be (implicitly) converted to a string.
 *
 * Defines the PHP magic method __toString()
 */
interface IStringable
{
    /**
     * Convert this object to a string
     *
     * @return string
     */
    public function __toString(): string;
}
