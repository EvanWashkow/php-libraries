<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

// Deprecated (04-2020)
trigger_error(
    Equatable::class . ' is deprecated. Use IEquatable instead.',
    E_USER_DEPRECATED
);

/**
 * @deprecated Use IEquatable instead.
 */
interface Equatable extends IEquatable {}