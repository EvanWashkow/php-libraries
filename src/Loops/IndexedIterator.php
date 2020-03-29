<?php
declare( strict_types = 1 );

namespace PHP\Loops;

use PHP\Exceptions\NotFoundException;

/**
 * Uses integer indices to traverse an Iterable item in a foreach() loop, retrieving the item's value for that index.
 * 
 * In order to use this class, extend it and define getValue()
 */
abstract class IndexedIterator extends Iterator
{

    /** @var ?int $current The current index position. */
    private $current;

    /** @var int $start The index to start at. */
    private $start;

    /** @var int $end The index to end at. */
    private $end;

    /** @var int $increment Value to increment (or decrement) the index by (on goToNext()) */
    private $increment;


    /**
     * Create a new integer-indexed iterator to traverse an Iterable
     * 
     * In order to specify no items, specify an invalid ending index. i.e. start = 0, end = -1, increment = 1;
     * or start = 0, end = 1, increment = -1.
     * 
     * @param int $start     The index to start at.
     * @param int $end       The index to end at. Will return the value at that index.
     * @param int $increment Value to increment (or decrement) the index by (on goToNext()).
     */
    public function __construct( int $start, int $end, int $increment )
    {
        $this->start     = $start;
        $this->end       = $end;
        $this->increment = $increment;
        $this->current   = null;
    }


    public function rewind(): void
    {
        $this->current = $this->start;
    }


    public function hasCurrent(): bool
    {
        return (
            ( null !== $this->current ) &&
            (
                ( 0 < $this->increment )
                    ? $this->start <= $this->end   // Iterating forwards
                    : $this->end   <= $this->start // Iterating backwards
            )
        );
    }


    public function getKey()
    {
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException( 'Iterator at an invalid position. There is no key.' );
        }
        return $this->start;
    }


    public function goToNext(): void
    {
        throw new NotFoundException( __FUNCTION__ . '() is not implemented, yet.' );
    }
}