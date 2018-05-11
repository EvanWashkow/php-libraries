<?php

use PHP\Collections\Dictionary;

/**
 * Dictionary Data for testing
 */
class DictionaryData
{
    
    /**
     * Retrieve all test dictionaries
     *
     * @return array
     */
    public static function Get(): array
    {
        return array_merge(
            self::GetTyped(),
            [
                self::GetMixed()
            ]
        );
    }
    
    
    /**
     * Retrieve all test typed dictionaries
     *
     * IMPORTANT!!! It is useful toswap dictionary key / values as parameters to
     * test type constraints. So, the key-value types cannot be the same, and it
     * very useful to define entries that PHP implicitly type converts, such as
     * "1" => 1
     *
     * @return array
     */
    public static function GetTyped(): array
    {
        return [
            self::getStringInt()
        ];
    }
    
    
    /**
     * Retrieve sample Dictionary with mixed string and value types
     *
     * @return Dictionary
     */
    public static function GetMixed(): Dictionary
    {
        $dictionary = new Dictionary();
        foreach ( self::GetTyped() as $d ) {
            foreach ( $d as $key => $value) {
                $dictionary->set( $key, $value );
                $dictionary->set( $value, $key );
            }
        }
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with string keys and integer values
     *
     * @return Dictionary
     */
    private static function getStringInt(): Dictionary
    {
        // Map 1-26 to a-z
        $start = 97;
        $end   = 122;
        $dictionary = new Dictionary( 'string', 'integer' );
        for ( $ascii = $start; $ascii <= $end; $ascii++ ) {
            $key   = chr( $ascii );
            $value = ( $ascii - $start ) + 1;
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
}
