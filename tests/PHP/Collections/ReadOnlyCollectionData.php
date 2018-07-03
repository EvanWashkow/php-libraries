<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

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
    public function GetNonEmpty()
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
    public function GetTyped()
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
    public function GetMixed()
    {
        return ReadOnlyDictionaryData::GetMixed();
    }
}
