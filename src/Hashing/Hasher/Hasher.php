<?php
declare(strict_types=1);

namespace PHP\Hashing\Hasher;

use PHP\Collections\ByteArray;

/**
 * Computes the hash sum of a value, regardless of type
 */
class Hasher implements IHasher
{


    public function hash($value): ByteArray
    {
        $hash = null;
        return $hash;
    }
}