<?php
namespace PHP\Collections;

/**
 * Defines a set of mutable, key-value
 */
abstract class Collection extends Iterator implements CollectionSpec
{
    
    public function hasKey( $key ): bool
    {
        $hasKey = false;
        $this->loop( function( $i, $value, $key, &$hasKey ) {
            if ( $i === $key ) {
                $hasKey = true;
                return $hasKey;
            }
        }, $key, $hasKey );
        return $hasKey;
    }
}
