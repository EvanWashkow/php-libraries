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
        foreach ( self::GetTyped() as $typedDictionary ) {
            $typedDictionary->loop( function( $key, $value ) use ( &$dictionary ) {
                $dictionary->set( $key, $value );
                $dictionary->set( $value, $key );
            });
        }
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with "1"-"9" => 1-9
     *
     * @return Dictionary
     */
    private static function getStringInt(): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        for ( $i = 0; $i < 10; $i++ ) {
            $dictionary->set( (string) $i, $i );
        }
        return $dictionary;
    }
}
