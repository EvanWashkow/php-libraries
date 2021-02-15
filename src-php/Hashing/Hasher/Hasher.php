<?php
declare(strict_types=1);

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;
use PHP\Hashing\HashAlgorithm\SHA256;
use PHP\Interfaces\IEquatable;
use PHP\Serialization\PHPSerialization;

/**
 * Computes the hash sum of a value, regardless of type
 */
class Hasher implements IHasher
{


    public function hash($value): ByteArray
    {
        $hash = null;
        if (true === $value)
        {
            $hash = new ByteArray(1, 1);
        }
        elseif (false === $value)
        {
            $hash = new ByteArray(0, 1);
        }
        elseif (is_float($value) || is_int($value) || is_string($value))
        {
            $hash = new ByteArray($value);
        }
        elseif ($value instanceof IEquatable)
        {
            $hash = $value->hash();
        }
        elseif (is_object($value))
        {
            $hash = new ByteArray(spl_object_hash($value));
        }
        else
        {
            $hash = (new SHA256())->hash(
                (new PHPSerialization())->serialize($value)
            );
        }
        return $hash;
    }
}