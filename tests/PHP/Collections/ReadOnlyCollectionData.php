<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * ReadOnlyCollection test data
 */
final class ReadOnlyCollectionData
{
    
    /**
     * Retrieves empty read-only collections
     * 
     * @return array
     */
    public static function GetEmpty(): array
    {
        return array_merge(
            ReadOnlyDictionaryData::GetEmpty()
        );
    }
    
    
    /**
     * Get all test data for read-only collections
     * 
     * @return array
     */
    public static function GetNonEmpty()
    {
        return array_merge(
            ReadOnlyDictionaryData::GetNonEmpty()
        );
    }
    
    
    /**
     * Get all typed test data for read-only collections
     * 
     * @return array
     */
    public static function GetTyped()
    {
        return array_merge(
            ReadOnlyDictionaryData::GetTyped()
        );
    }
    
    
    /**
     * Get all mixed test data for read-only collections
     *
     * NOTE: Do not return sequences, since their keys are not mixed
     * 
     * @return array
     */
    public static function GetMixed()
    {
        return ReadOnlyDictionaryData::GetMixed();
    }
}
