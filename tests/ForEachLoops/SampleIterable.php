<?php
declare( strict_types = 1 );

namespace PHP\Tests\ForEachLoops;

use PHP\ForEachLoops\IIterable;
use PHP\ForEachLoops\Iterator;

class SampleIterable implements IIterable
{


    const VALUES = [ 1, 2, 3 ];


    public function getIterator(): Iterator
    {
        return new SampleIterator( self::VALUES );
    }
}