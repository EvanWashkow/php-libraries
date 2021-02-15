<?php
declare( strict_types = 1 );

namespace PHP\Hashing\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA1 Hash Algorithm
 */
final class SHA1 implements IHashAlgorithm
{
    public function hash(ByteArray $byteArray): ByteArray
    {
        return new ByteArray(
            sha1($byteArray->__toString(), true)
        );
    }
}