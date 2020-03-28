<?php
declare( strict_types = 1 );

namespace PHP\Loops;

/**
 * Describes a set of values that can be traversed by a foreach() loop
 */
interface Enumerable extends \IteratorAggregate
{


    /**
     * @internal Specified for additional clarity and to change the return type.
     * 
     * @return Enumerator
     */
    public function getIterator(): Enumerator;
}