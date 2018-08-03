<?php

require_once( __DIR__ . '/DictionaryData.php' );

use PHP\Collections\ReadOnlyDictionary;

/**
 * ReadOnlyDictionary test data
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
     * Retrieve sample Dictionary with mixed types
     *
     * @return array
     */
    public static function GetMixed(): array
    {
        $dictionaries = [];
        foreach ( DictionaryData::GetMixed() as $dictionary ) {
            $dictionaries[] = new ReadOnlyDictionary( $dictionary );
            $dictionaries[] = $dictionary;
        }
        return $dictionaries;
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
            $dictionaries[] = $dictionary;
        }
        return $dictionaries;
    }
}
