<?php

use PHP\Collections\Dictionary;

/**
 * Dictionary test data
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
    * Retrieve non-empty test dictionaries
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
     * Return sample Dictionary with 0, 1 => false, true
     *
     * @return Dictionary
     */
    private static function getIntBool(): Dictionary
    {
        $dictionary = new Dictionary( 'integer', 'boolean' );
        $dictionary->set( 0, false );
        $dictionary->set( 1, true );
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with "0"-"1" => 0-1
     *
     * @return Dictionary
     */
    private static function getStringInt(): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'integer' );
        for ( $i = 0; $i <= 1; $i++ ) {
            $dictionary->set( (string) $i, $i );
        }
        return $dictionary;
    }
    
    
    /**
     * Return sample Dictionary with "0" => new stdClass()
     *
     * @return Dictionary
     */
    private static function getStringObject(): Dictionary
    {
        $dictionary = new Dictionary( 'string', 'stdClass' );
        $dictionary->set( "0", new stdClass() );
        return $dictionary;
    }
}
