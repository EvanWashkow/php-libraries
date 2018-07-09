<?php

use PHP\Collections\Dictionary;

/**
 * Dictionary Data for testing
 */
class DictionaryData
{
    
    /***************************************************************************
    *                                 MAIN
    ***************************************************************************/
    
    /**
     * Retrieve sample dictionary data that has no entries
     *
     * @return array
     */
    public static function GetEmpty(): array
    {
        $dictionaries = [];
        foreach ( self::GetNonEmpty() as $dictionary ) {
            $dictionary->clear();
            $dictionaries[] = $dictionary;
        }
        return $dictionaries;
    }
    
    
    /**
    * Retrieve all test dictionaries
    *
    * @return array
    */
    public static function GetNonEmpty(): array
    {
        return array_merge(
            self::GetTyped(),
            self::GetMixed()
        );
    }
    
    
    /**
    * Retrieve sample Dictionary with mixed string and value types
    *
    * @return array
    */
    public static function GetMixed(): array
    {
        $dictionary = new Dictionary();
        foreach ( self::GetTyped() as $typedDictionary ) {
            $typedDictionary->loop( function( $key, $value ) use ( &$dictionary ) {
                $dictionary->set( $key, $value );
            });
        }
        return [
            $dictionary
        ];
    }
    
    
    /**
     * Retrieve all test typed dictionaries
     *
     * IMPORTANT: Key and value types must be different. It is useful to swap
     * key / values as parameters to test type constraints. It is best to define
     * similar entries that PHP usually chokes on, such as "1" => 1
     *
     * @return array
     */
    public static function GetTyped(): array
    {
        return [
            self::getIntBool(),
            self::getStringInt(),
            self::getStringObject()
        ];
    }
    
    
    /***************************************************************************
    *                                   TYPED
    ***************************************************************************/
    
    /**
     * Return sample Dictionary with 1, 0 => true, false
     *
     * @return Dictionary
     */
    private static function getIntBool(): Dictionary
    {
        $dictionary = new Dictionary( 'integer', 'boolean' );
        $dictionary->set( 1, true );
        $dictionary->set( 0, false );
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with "0"-"2" => 0-2
     *
     * @return Dictionary
     */
    private static function getStringInt(): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        for ( $i = 0; $i <= 2; $i++ ) {
            $dictionary->set( (string) $i, $i );
        }
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with "0"-"2" => new stdClass()
     *
     * @return Dictionary
     */
    private static function getStringObject(): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'stdClass' );
        for ( $i = 0; $i <= 2; $i++ ) {
            $dictionary->set( (string) $i, new stdClass() );
        }
        return $dictionary;
    }
}
