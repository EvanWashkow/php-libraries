<?php

declare(strict_types=1);

namespace PHP\Interfaces;

// Deprecated (04-2020)
trigger_error(
    Stringable::class.' is deprecated. Use IStringable instead.',
    E_USER_DEPRECATED
);

/**
 * @deprecated use IStringable instead
 */
interface Stringable extends IStringable
{
}
