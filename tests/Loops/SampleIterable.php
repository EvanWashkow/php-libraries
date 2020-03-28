<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\IIterable;
use PHP\Loops\Iterator;

class SampleIterable implements IIterable
{


    const VALUES = [ 1, 2, 3 ];


    public function getIterator(): Iterator
    {
        return new SampleIterator( self::VALUES );
    }
}