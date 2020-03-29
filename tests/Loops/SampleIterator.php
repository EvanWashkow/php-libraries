<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\IndexedIterator;

class SampleIterator extends IndexedIterator
{


    /**
     * Create a new Sample Iterator
     * 
     * @param array $values The values to traverse
     */
    public function __construct( array $values )
    {
        $start = 0;
        $end   = ( $start + count( $values )) - 1;
        parent::__construct( $start, $end, 1 );
        $this->values = $values;
    }


    public function getValue()
    {
        if ( !$this->hasCurrent() ) {
            throw new \OutOfBoundsException( 'There is no value at the current position.' );
        }
        return $this->values[ $this->getKey() ];
    }
}