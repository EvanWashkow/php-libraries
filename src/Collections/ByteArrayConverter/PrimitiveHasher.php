<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;

/**
 * Hashes primitive value types (doubles, ints, strings) by simply returning their value as an array of bytes
 */
class PrimitiveHasher extends ByteArrayConverterDecorator
{

    /**
     * Returns the primitive value as their natural array of bytes. If not a primitive value, will call the next hasher.
     */
    public function convert($value): ByteArray
    {
        return is_float($value) || is_int($value) || is_string($value)
            ? new ByteArray($value)
            : $this->getNextHasher()->convert($value);
    }
}