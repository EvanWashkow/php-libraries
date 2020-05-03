<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iteration;

use PHP\Collections\IArrayable;
use PHP\Exceptions\NotImplementedException;

/**
 * Iterates over an IArrayable using Integer indexes.
 * 
 * Changes to the object will be reflected in the loop. Clone IArrayable entries before looping as necessary.
 */
class ArrayableIndexedIterator extends IndexedIterator
{

    /** @var IArrayable $arrayable The IArrayable object instance */
    private $arrayable;


    /**
     * Create a new Arrayable Iterator
     * 
     * @param IArrayable $arrayable     The IArrayable object instance
     * @param int        $startingIndex The starting index
     * @param int        $incrementBy   The amount to increment the current index by on every goToNext()
     * @throws \DomainException If incrementBy is zero
     */
    public function __construct( IArrayable $arrayable, int $startingIndex = 0, int $incrementBy = 1 )
    {
        // Call parent constructor
        try {
            parent::__construct( $startingIndex, $incrementBy );
        } catch ( \DomainException $de ) {
            throw new \DomainException( $de->getMessage(), $de->getCode(), $de );
        }

        // Set own properties
        $this->arrayable = $arrayable;
    }


    public function hasCurrent(): bool
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }


    public function getValue()
    {
        throw new NotImplementedException( 'Not implemented, yet.' );
    }


    /**
     * Retrieve the IArrayable array with integer indexes
     * 
     * This will fetch the current values from IArrayable, which will reflect any changes (additions / removals) there.
     * 
     * @return array
     */
    protected function toArray(): array
    {
        return array_values( $this->arrayable->toArray() );
    }
}