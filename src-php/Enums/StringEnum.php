<?php

declare(strict_types=1);

namespace PHP\Enums;

use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\Interfaces\IStringable;

/**
 * Allows users to define (and select from) a strict set of constant strings.
 *
 * All constants must be public and strings.
 */
abstract class StringEnum extends Enum implements IStringable
{
    // CONSTRUCTOR METHODS

    /**
     * Create a new Enumeration string instance.
     *
     * @param string $value A value from the set of enumerated constants
     *
     * @throws \DomainException       If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum constant is not public or not a string
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    /**
     * Returns the current value of this Enumeration.
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    // MAIN

    /**
     * @internal final: the value is non-mutable once it is set by the constructor
     */
    final public function getValue(): string
    {
        return parent::getValue();
    }

    /**
     * Sanitizes the value before it is set by the constructor.
     *
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     *
     * @param mixed $value the value to sanitize before setting
     *
     * @throws \DomainException       If the value is not supported
     * @throws MalformedEnumException If an Enum constant is not public or not a string
     *
     * @return string the value after sanitizing
     */
    protected function sanitizeValue($value): string
    {
        return parent::sanitizeValue($value);
    }
}
