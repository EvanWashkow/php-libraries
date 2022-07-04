<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries;

/**
 * Describes Object equality comparison.
 *
 * - Equality must compare two objects of the same type for equivalence and should not be used for other behavior.
 * - An object must be equivalent to itself.
 * - Equality must be bidirectional. Calling `equals()` on the opposing object should result in the same value.
 * - Equality must be idempotent. Internal changes should not affect an object's equality; return a new value instead.
 */
interface Equatable
{
    /**
     * Compare values for equality.
     *
     * @param self $value the value to compare
     */
    public function equals(self $value): bool;
}
