<?php
declare( strict_types = 1 );

namespace PHP\Serialization;

use PHP\Collections\ByteArray;

/**
 * Serializer implementation that uses PHP's serialize() function
 */
class PHPSerializer implements ISerializer
{


    public function serialize( $value ): ByteArray
    {
        return new ByteArray( serialize( $value ) );
    }


    public function deserialize( ByteArray $byteArray )
    {
        return null;
    }
}