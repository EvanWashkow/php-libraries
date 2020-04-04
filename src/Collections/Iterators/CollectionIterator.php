<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iterators;

use PHP\Iteration\Iterator;

/**
 * Defines a basic iterator for Collections that uses integer indexes
 * 
 * To stop the iteration, hasCurrent() should return false.
 */
abstract class CollectionIterator extends Iterator
{

    /** @var int $currentIndex The current index */
    private $currentIndex;

    /** @var int $startingIndex The starting index */
    private $startingIndex;


    /**
     * Create a new Collection Iterator instance
     * 
     * @param int $startingIndex The starting index
     */
    public function __construct( int $startingIndex )
    {
        $this->currentIndex  = $startingIndex;
        $this->startingIndex = $startingIndex;
    }


    public function getKey()
    {
        return $this->currentIndex;
    }


    public function goToNext(): void
    {
        $this->currentIndex++;
    }
}