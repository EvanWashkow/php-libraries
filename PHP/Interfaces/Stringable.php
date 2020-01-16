<?php
declare( strict_types = 1 );

/**
 * Describes any object that can be (implicitly) converted to a string.
 * 
 * Defines the PHP magic method __toString()
 */
interface Stringable
{

    /**
     * Return a string which represents this object.
     * 
     * @return string
     */
    public function __toString(): string;
}