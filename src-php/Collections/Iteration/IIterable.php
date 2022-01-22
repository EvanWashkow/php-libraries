<?php

declare(strict_types=1);

namespace PHP\Collections\Iteration;

/**
 * Describes an object with a set of values that can be traversed by a foreach() loop
 */
interface IIterable extends \IteratorAggregate
{
    /**
     * @internal Specified for additional clarity and to change the return type.
     *
     * @return Iterator
     * @throws void
     */
    public function getIterator(): Iterator;
}
