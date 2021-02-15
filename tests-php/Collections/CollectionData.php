<?php
namespace PHP\Tests;

require_once( __DIR__ . '/DictionaryData.php' );
require_once( __DIR__ . '/SequenceData.php' );

/**
 * Collection test data
 */
final class CollectionData
{
    
    /**
     * Get non-empty test data for collections
     * 
     * @return array
     */
    public static function Get(): array
    {
        return array_merge(
            DictionaryData::Get(),
            SequenceData::GetOld()
        );
    }
    
    
    /**
     * Get all typed test data for collections
     * 
     * @return array
     */
    public static function GetTyped(): array
    {
        return array_merge(
            DictionaryData::GetTyped(),
            SequenceData::GetOldTyped()
        );
    }
    
    
    /**
     * Get all mixed test data for collections
     *
     * NOTE: Do not return sequences, since their keys are not mixed
     * 
     * @return array
     */
    public static function GetMixed(): array
    {
        return DictionaryData::GetMixed();
    }
}
