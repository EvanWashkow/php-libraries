<?php

declare(strict_types=1);

namespace PHP\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA384 Hash Algorithm.
 */
final class SHA384 implements IHashAlgorithm
{
    public function hash(ByteArray $byteArray): ByteArray
    {
        return new ByteArray(
            hash('sha384', $byteArray->__toString(), true)
        );
    }
}
