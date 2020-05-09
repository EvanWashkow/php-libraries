<?php
declare( strict_types = 1 );

namespace PHP\Collections\Iteration;

use PHP\Collections\IArrayable;

/**
 * Iterates over an IArrayable using Integer indexes.
 * 
 * Changes to the object will be reflected in the loop. Clone IArrayable entries before looping as necessary.
 */
class ArrayableIterator extends IndexedIterator
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
        return array_key_exists( $this->getKey(), $this->toArray() );
    }


    public function getValue()
    {
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException( 'Value could not be retrieved. Not at a valid position.' );
        }
        return $this->toArray()[ $this->getKey() ];
    }


    /**
     * Retrieves the IArrayable object instance
     * 
     * @internal Final: this must always reflect the constructed value.
     * 
     * @return IArrayable
     */
    final protected function getArrayable(): IArrayable
    {
        return $this->arrayable;
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
        return array_values( $this->getArrayable()->toArray() );
    }
}