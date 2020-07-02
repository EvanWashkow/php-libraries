<?php
declare( strict_types = 1 );

namespace PHP\Iteration;

use PHP\Collections\Iteration\IIterable as IterationIIterable;

// 04-2020
trigger_error(
    IIterable::class . ' moved to the Collections namespace',
    E_USER_ERROR
);

/**
 * @deprecated Moved to the Collections namespace
 */
interface IIterable extends IterationIIterable {}