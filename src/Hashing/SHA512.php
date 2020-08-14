<?php
declare( strict_types = 1 );

namespace PHP\Hashing;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA512 Hash Algorithm
 */
class SHA512 implements IHashAlgorithm
{

    public function hash( ByteArray $byteArray ): ByteArray
    {
        return new ByteArray( hash( 'sha512', $byteArray->__toString(), true ) );
    }
}