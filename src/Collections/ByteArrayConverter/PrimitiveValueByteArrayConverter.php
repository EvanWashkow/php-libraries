<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;

/**
 * If the value is primitive (doubles, ints, strings), type-cast it to a Byte Array, and return the result
 */
class PrimitiveValueByteArrayConverter extends ByteArrayConverterDecorator
{


    public function convert($value): ByteArray
    {
        return is_float($value) || is_int($value) || is_string($value)
            ? new ByteArray($value)
            : $this->getNextConverter()->convert($value);
    }
}