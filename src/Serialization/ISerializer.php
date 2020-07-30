<?php
declare( strict_types = 1 );

namespace PHP\Serialization;

use PHP\Collections\ByteArray;

/**
 * Describes an Object that can Serialize a value to a Byte Array and Deserialize it back again
 * 
 * Serialization is a subset of Encoding. As with all Encoding methods, it should be bi-directional.
 */
interface ISerializer
{


    /**
     * Serializes a value to a Byte Array
     * 
     * @param mixed $value The value to serialize
     * @return ByteArray The serialized value
     */
    public function serialize( $value ): ByteArray;


    /**
     * Deserializes the serialized Byte Array to its value
     * 
     * @param ByteArray $byteArray The serialized value to deserialize
     * @return mixed The deserialized value
     */
    public function deserialize( ByteArray $byteArray );
}
