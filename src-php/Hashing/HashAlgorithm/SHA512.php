<?php

declare(strict_types=1);

namespace PHP\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA512 Hash Algorithm.
 */
final class SHA512 implements IHashAlgorithm
{
    public function hash(ByteArray $byteArray): ByteArray
    {
        return new ByteArray(
            hash('sha512', $byteArray->__toString(), true)
        );
    }
}
