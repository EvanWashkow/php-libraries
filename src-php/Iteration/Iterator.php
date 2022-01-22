<?php

declare(strict_types=1);

namespace PHP\Iteration;

use PHP\Collections\Iteration\Iterator as IterationIterator;

// 04-2020
trigger_error(
    Iterator::class . ' moved to the Collections namespace',
    E_USER_ERROR
);

/**
 * @deprecated Moved to the Collections namespace
 */
abstract class Iterator extends IterationIterator
{
}
