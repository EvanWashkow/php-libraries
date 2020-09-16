<?php
declare(strict_types=1);

namespace PHP\Hashing\Hashers;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;

/**
 * Hashes primitive value types (doubles, ints, strings) by simply returning their value as an array of bytes
 */
class ReturnEquatableHash extends HasherDecorator
{

    /**
     * Returns the primitive value as their natural array of bytes. If not a primitive value, will call the next hasher.
     */
    public function hash($value): ByteArray
    {
        return ($value instanceof IEquatable) ? $value->hash() : $this->getNextHasher()->hash($value);
    }
}