<?php

require_once( __DIR__ . '/DictionaryData.php' );

use PHP\Collections\ReadOnlyDictionary;

/**
 * Dictionary Data for testing
 */
class ReadOnlyDictionaryData
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
    
    
    /**
     * Retrieve sample Dictionary with mixed string and value types
     *
     * @return ReadOnlyDictionary
     */
    public static function GetMixed(): ReadOnlyDictionary
    {
        $dictionary = DictionaryData::GetMixed();
        return new ReadOnlyDictionary( $dictionary );
    }
}
