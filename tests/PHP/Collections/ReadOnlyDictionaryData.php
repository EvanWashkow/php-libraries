<?php

require_once( __DIR__ . '/DictionaryData.php' );

use PHP\Collections\ReadOnlyDictionary;

/**
 * ReadOnlyDictionary test data
 */
final class ReadOnlyDictionaryData
{
    
    /**
     * Retrieve sample dictionaries with no entries
     * 
     * @return array
     */
    public static function GetEmpty(): array
    {
        $dictionaries = [];
        foreach ( DictionaryData::GetEmpty() as $dictionary ) {
            $dictionaries[] = new ReadOnlyDictionary( $dictionary );
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
     * Retrieve sample Dictionary with mixed types
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
