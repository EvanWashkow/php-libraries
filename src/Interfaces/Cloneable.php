<?php
declare( strict_types = 1 );

namespace PHP\Interfaces;

// Deprecated (04-2020)
trigger_error(
    'Cloneable is deprecated. Use ICloneable instead.',
    E_USER_DEPRECATED
);

/**
 * @deprecated Use ICloneable instead.
 */
interface Cloneable extends ICloneable {}