<?php

declare(strict_types=1);

namespace PHP\Enums;

use PHP\Enums\Exceptions\MalformedEnumException;
use PHP\Interfaces\IIntegerable;

/**
 * Allows users to define (and select from) a strict set of constant integers.
 *
 * All constants must be public and integers.
 */
abstract class IntegerEnum extends Enum implements IIntegerable
{
    // CONSTRUCTOR METHODS

    /**
     * Create a new Enumeration integer instance.
     *
     * @param int $value A value from the set of enumerated constants
     *
     * @throws \DomainException       If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum constant is not public or not an integer
     */
    public function __construct(int $value)
    {
        parent::__construct($value);
    }

    // MAIN

    /**
     * @internal final: the value is non-mutable once it is set by the constructor
     */
    final public function getValue(): int
    {
        return parent::getValue();
    }

    /**
     * @internal final: the value is non-mutable once it is set by the constructor
     */
    final public function toInt(): int
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
     * @throws MalformedEnumException If an Enum constant is not public or not an integer
     *
     * @return int the value after sanitizing
     */
    protected function sanitizeValue($value): int
    {
        return parent::sanitizeValue($value);
    }
}
