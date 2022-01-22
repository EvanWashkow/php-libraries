<?php

declare(strict_types=1);

namespace PHP\Collections;

/**
 * Describes an object that can be converted to an array.
 */
interface IArrayable
{
    /**
     * Convert this object to an array.
     */
    public function toArray(): array;
}
