<?php

declare(strict_types=1);

namespace PHP\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Defines the MD5 Hash Algorithm.
 */
final class MD5 implements IHashAlgorithm
{
    public function hash(ByteArray $byteArray): ByteArray
    {
        return new ByteArray(
            md5($byteArray->__toString(), true)
        );
    }
}
