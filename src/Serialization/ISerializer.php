<?php
declare( strict_types = 1 );

namespace PHP\Serialization;

use PHP\Collections\ByteArray;

/**
 * Describes an Object that can Serialize another Object to a Byte Array
 */
interface ISerializer
{

    /**
     * Serialize the given value to a Byte Array
     * 
     * @param mixed $value The value to serialize
     * @return ByteArray
     */
    public function serialize( $value ): ByteArray;
}