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

    /** @var int $startingIndex The starting index */
    private $startingIndex;


    /**
     * Create a new Indexed Iterator instance
     * 
     * @param int $startingIndex The starting index
     */
    public function __construct( int $startingIndex )
    {
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
        $this->currentIndex++;
    }
}