<?php
declare( strict_types = 1 );

namespace PHP\Tests\Iteration;

use PHP\Iteration\IIterable;
use PHP\Iteration\Iterator;

class SampleIterable implements IIterable
{


    const VALUES = [ 1, 2, 3 ];


    public function getIterator(): Iterator
    {
        return new SampleIterator( self::VALUES );
    }
}