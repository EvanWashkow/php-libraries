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
    /*******************************************************************************************************************
    *                                                 CONSTRUCTOR METHODS
    *******************************************************************************************************************/


    /**
     * Create a new Enumeration string instance
     *
     * @param string $value A value from the set of enumerated constants
     * @throws \DomainException If the value is not a constant of this class
     * @throws MalformedEnumException If an Enum constant is not public or not a string
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
    }


    /**
     * Sanitizes the value before it is set by the constructor.
     *
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     *
     * @param mixed $value The value to sanitize before setting.
     * @return string The value after sanitizing.
     * @throws \DomainException If the value is not supported
     * @throws MalformedEnumException If an Enum constant is not public or not a string
     */
    protected function sanitizeValue($value): string
    {
        return parent::sanitizeValue($value);
    }




    /*******************************************************************************************************************
    *                                                         MAIN
    *******************************************************************************************************************/


    /**
     * @internal Final: the value is non-mutable once it is set by the constructor.
     *
     * @return string
     */
    final public function getValue(): string
    {
        return parent::getValue();
    }


    /**
     * Returns the current value of this Enumeration
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
