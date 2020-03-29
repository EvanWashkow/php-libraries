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

    /** @var int $current The current index position. */
    private $current;

    /** @var int $end The index to end at. */
    private $end;

    /** @var int $increment Value to increment (or decrement) the index by (on goToNext()) */
    private $increment;

    /** @var bool $isForward Determines the direction of the increment. Optimizes hasCurrent() check. */
    private $isForward;

    /** @var int $start The index to start at. */
    private $start;


    /**
     * Create a new integer-indexed iterator to traverse an Iterable
     * 
     * In order to specify no items, specify an invalid ending index. i.e. start = 0, end = -1, increment = 1;
     * or start = 0, end = 1, increment = -1.
     * 
     * @param int $start     The index to start at (inclusive).
     * @param int $end       The index to end at (inclusive).
     * @param int $increment Value to increment (or decrement) the index by (on goToNext()).
     * @throws \DomainException If increment is zero.
     */
    public function __construct( int $start, int $end, int $increment )
    {
        // Throw DomainException on invalid increment
        if ( 0 === $increment ) {
            throw new \DomainException( 'Index increment cannot be zero.' );
        }
        
        // Set properties
        $this->start     = $start;
        $this->end       = $end;
        $this->increment = $increment;
        $this->isForward = 0 < $increment;

        // Set current to an invalid position: rewind() must _always_ be called before attempting to access anything.
        $this->current = $end + $increment;
    }


    public function rewind(): void
    {
        $this->current = $this->start;
    }


    public function hasCurrent(): bool
    {
        return $this->isForward ? $this->current <= $this->end : $this->end <= $this->current;
    }


    public function getKey()
    {
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException( 'Iterator at an invalid position. There is no key.' );
        }
        return $this->current;
    }


    public function goToNext(): void
    {
        $this->current += $this->increment;
    }
}