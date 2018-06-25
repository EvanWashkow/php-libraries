<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * ReadOnlyCollection test data
 */
final class ReadOnlyCollectionData
{
    
    /**
     * Get all test data for a read-only collection
     * 
     * @return array
     */
    public function Get()
    {
        return array_merge(
            ReadOnlyDictionaryData::Get()
        );
    }
}
