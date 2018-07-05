<?php

require_once( __DIR__ . '/ReadOnlyCollectionData.php' );

/**
 * ReadOnlyCollection test data
 */
final class IteratorData
{
    
    /**
     * Get empty test data for read-only collections
     * 
     * @return array
     */
    public function GetEmpty(): array
    {
        return ReadOnlyCollectionData::GetEmpty();
    }
    
    
    /**
     * Get non-empty test data for read-only collections
     * 
     * @return array
     */
    public function GetNonEmpty(): array
    {
        return ReadOnlyCollectionData::GetNonEmpty();
    }
    
    
    /**
     * Get all typed test data for read-only collections
     * 
     * @return array
     */
    public function GetTyped(): array
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
    public function GetMixed(): array
    {
        return ReadOnlyCollectionData::GetMixed();
    }
}
