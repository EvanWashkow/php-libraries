<?php

declare(strict_types=1);

namespace PHP\Collections;

/**
 * Describes an object with internal values that can be counted.
 */
interface ICountable extends \Countable
{
    /**
     * Retrieve the count.
     */
    public function count(): int;
}
