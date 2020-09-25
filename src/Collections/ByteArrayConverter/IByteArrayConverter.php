<?php
declare( strict_types = 1 );

namespace PHP\Collections\ByteArrayConverter;

use PHP\Collections\ByteArray;

/**
 * Converts any value to a Byte Array
 */
interface IByteArrayConverter
{

    /**
     * Convert the value to a Byte Array
     * 
     * @param mixed $value The value to hash
     * @return ByteArray
     */
    public function convert($value): ByteArray;
}