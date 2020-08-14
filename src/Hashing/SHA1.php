<?php
declare( strict_types = 1 );

namespace PHP\Hashing;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA1 Hash Algorithm
 */
class SHA1 implements IHashAlgorithm
{

    public function hash( ByteArray $byteArray ): ByteArray
    {
        return new ByteArray( sha1( $byteArray->__toString(), true ) );
    }
}