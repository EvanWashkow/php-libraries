<?php

declare(strict_types=1);

namespace PHP;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;

/**
 * Defines a basic object
 *
 * @internal This does not implement ICloneable since not all Objects can be cloned. For  example, any type of File I/O
 * object should never be cloned since you cannot have two writers at the same time. ICloneable-ity must be determined
 * on a case-by-case basis.
 */
abstract class ObjectClass implements IEquatable
{
    public function hash(): ByteArray
    {
        return new ByteArray(spl_object_hash($this));
    }


    public function equals($value): bool
    {
        return $this === $value;
    }
}
