<?php

require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * ReadOnlyCollection test data
 */
final class IteratorData
{
    
    /**
     * Get all test data for read-only collections
     * 
     * @return array
     */
    public function Get()
    {
        return ReadOnlyCollectionData::Get();
    }
    
    
    /**
     * Get all typed test data for read-only collections
     * 
     * @return array
     */
    public function GetTyped()
    {
        return ReadOnlyCollectionData::GetTyped();
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
        return ReadOnlyCollectionData::GetMixed();
    }
}
