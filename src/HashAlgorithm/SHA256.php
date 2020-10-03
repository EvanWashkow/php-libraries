<?php
declare( strict_types = 1 );

namespace PHP\HashAlgorithm;

use PHP\Collections\ByteArray;

/**
 * Defines the SHA256 Hash Algorithm
 */
class SHA256 implements IHashAlgorithm
{

    public function hash( ByteArray $byteArray ): ByteArray
    {
        return new ByteArray( hash( 'sha256', $byteArray->__toString(), true ) );
    }
}