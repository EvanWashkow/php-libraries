<?php
declare(strict_types=1);

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;

/**
 * If the value is IEquatable, return the result of hash()
 */
class EquatableHashByteArrayConverter extends ByteArrayConverterDecorator
{


    public function convert($value): ByteArray
    {
        return ($value instanceof IEquatable) ? $value->hash() : $this->getNextConverter()->convert($value);
    }
}