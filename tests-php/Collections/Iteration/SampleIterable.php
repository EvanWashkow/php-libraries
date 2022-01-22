<?php

declare(strict_types=1);

namespace PHP\Tests\Collections\Iteration;

use PHP\Collections\Iteration\IIterable;
use PHP\Collections\Iteration\Iterator;

class SampleIterable implements IIterable
{
    public const VALUES = [1, 2, 3];

    public function getIterator(): Iterator
    {
        return new SampleIterator(self::VALUES);
    }
}
