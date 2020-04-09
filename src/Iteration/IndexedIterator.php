<?php
declare( strict_types = 1 );

namespace PHP\Iteration;

/**
 * Defines a basic Iterator that uses integer indices for keys
 * 
 * To stop the iteration, hasCurrent() should return false.
 */
abstract class IndexedIterator extends Iterator
{

    /** @var int $currentIndex The current index */
    private $currentIndex;

    /** @var int $incrementBy The amount to increment the current index by on every goToNext() */
    private $incrementBy;

    /** @var int $startingIndex The starting index */
    private $startingIndex;


    /**
     * Create a new Indexed Iterator instance
     * 
     * @param int $startingIndex The starting index
     * @param int $incrementBy   The amount to increment the current index by on every goToNext()
     */
    public function __construct( int $startingIndex, int $incrementBy = 1 )
    {
        if ( 0 === $incrementBy ) {
            throw new \DomainException( 'Cannot increment by zero.' );
        }
        $this->incrementBy   = $incrementBy;
        $this->startingIndex = $startingIndex;
        $this->rewind();
    }


    public function rewind(): void
    {
        $this->currentIndex = $this->startingIndex;
    }


    public function getKey(): int
    {
        return $this->currentIndex;
    }


    public function goToNext(): void
    {
        $this->currentIndex += $this->incrementBy;
    }
}