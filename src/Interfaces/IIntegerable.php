<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

/**
 * Describes an object that can be converted to PHP's integer type (machine-dependant bit size)
 */
interface IIntegerable
{

    /**
     * Convert this object to an integer
     * 
     * @return int Machine-dependent bit size
     */
    public function toInt(): int;
}