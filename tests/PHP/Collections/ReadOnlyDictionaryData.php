<?php

require_once( __DIR__ . '/DictionaryData.php' );

use PHP\Collections\ReadOnlyDictionary;

/**
 * Dictionary Data for testing
 */
final class ReadOnlyDictionaryData
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
        $roDictionaries = [];
        foreach ( DictionaryData::GetMixed() as $dictionary ) {
            $roDictionaries[] = new ReadOnlyDictionary( $dictionary );
        }
        return $roDictionaries;
    }
    
    
    /**
     * Retrieve all test typed dictionaries
     *
     * @return array
     */
    public static function GetTyped(): array
    {
        $dictionaries = [];
        foreach ( DictionaryData::GetTyped() as $dictionary ) {
            $dictionaries[] = new ReadOnlyDictionary( $dictionary );
        }
        return $dictionaries;
    }
}
