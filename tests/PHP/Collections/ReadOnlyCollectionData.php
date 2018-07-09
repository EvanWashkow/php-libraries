<?php

require_once( __DIR__ . '/CollectionData.php' );
require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * ReadOnlyCollection test data
 */
final class ReadOnlyCollectionData
{
    
    /**
     * Retrieves all test data
     *
     * @return array
     */
    public static function Get(): array
    {
        return array_merge(
            self::GetEmpty(),
            self::GetNonEmpty()
        );
    }
    
    
    /**
     * Retrieves empty read-only collections
     * 
     * @return array
     */
    public static function GetEmpty(): array
    {
        return array_merge(
            ReadOnlyDictionaryData::GetEmpty(),
            ReadOnlySequenceData::GetEmpty()
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
            ReadOnlyDictionaryData::GetNonEmpty(),
            ReadOnlySequenceData::GetNonEmpty()
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
            ReadOnlyDictionaryData::GetTyped(),
            ReadOnlySequenceData::GetTyped()
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
        return array_merge(
            ReadOnlyDictionaryData::GetMixed()
        );
    }
}
