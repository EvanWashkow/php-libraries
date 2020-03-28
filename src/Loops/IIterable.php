<?php
declare( strict_types = 1 );

namespace PHP\Loops;

/**
 * Describes a set of values that can be traversed by a foreach() loop
 */
interface IIterable extends \IteratorAggregate
{


    /**
     * @internal Specified for additional clarity and to change the return type.
     * 
     * @return Iterator
     */
    public function getIterator(): Iterator;
}