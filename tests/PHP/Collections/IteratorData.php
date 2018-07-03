<?php

require_once( __DIR__ . '/CollectionData.php' );

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
        return CollectionData::Get();
    }
    
    
    /**
     * Get all typed test data for read-only collections
     * 
     * @return array
     */
    public function GetTyped()
    {
        return CollectionData::GetTyped();
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
        return CollectionData::GetMixed();
    }
}
