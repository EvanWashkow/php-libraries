<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Collections\Iteration\IIterable;

trigger_error('Deprecated. Use the individual interfaces instead.', E_USER_DEPRECATED);

/**
 * Describes an (immutible) object with internal values
 *
 * @deprecated Use the individual interfaces instead. 01-2021.
 */
interface IReadOnlyCollection extends ICountable, IIterable {}