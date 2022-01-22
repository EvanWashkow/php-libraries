<?php

declare(strict_types=1);

namespace PHP\Iteration;

use PHP\Collections\Iteration\IndexedIterator as IterationIndexedIterator;

// 04-2020
trigger_error(
    IndexedIterator::class . ' moved to the Collections namespace',
    E_USER_ERROR
);

/**
 * @deprecated Moved to the Collections namespace
 */
abstract class IndexedIterator extends IterationIndexedIterator
{
}
