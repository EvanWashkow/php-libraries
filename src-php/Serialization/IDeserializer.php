<?php

declare(strict_types=1);

namespace PHP\Serialization;

use PHP\Collections\ByteArray;

/**
 * Describes an Object that can Deserialize a serialized Byte Array back to its original value
 *
 * Serialization is a subset of Encoding. As with all Encoding methods, it must be bi-directional.
 */
interface IDeserializer
{
    /**
     * Deserializes a serialized Byte Array to its original value
     *
     * @param ByteArray $byteArray The serialized value
     * @return mixed The original value
     */
    public function deserialize(ByteArray $byteArray);
}
