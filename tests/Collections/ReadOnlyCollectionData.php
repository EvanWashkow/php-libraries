<?php
namespace PHP\Tests;

require_once( __DIR__ . '/CollectionData.php' );
require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * ReadOnlyCollection test data
 */
final class ReadOnlyCollectionData
{
    
    /**
     * Get all test data for read-only collections
     * 
     * @return array
     */
    public static function Get()
    {
        return array_merge(
            ReadOnlyDictionaryData::Get(),
            ReadOnlySequenceData::GetOld()
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
            ReadOnlySequenceData::GetOldTyped()
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
