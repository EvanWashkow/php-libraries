<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Iteration\IIterable;

/**
 * Describes an (immutible) object with internal values
 */
interface IReadOnlyCollection extends ICountable, IIterable {}