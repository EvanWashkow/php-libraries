<?php
declare( strict_types = 1 );

namespace PHP\Tests\Loops;

use PHP\Loops\Enumerable;
use PHP\Loops\Enumerator;

class SampleEnumerable implements Enumerable
{


    const VALUES = [ 1, 2, 3 ];


    public function getIterator(): Enumerator
    {
        return new SampleEnumerator( self::VALUES );
    }
}