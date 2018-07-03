<?php

require_once( __DIR__ . '/CollectionData.php' );

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
        return CollectionData::GetEmpty();
    }
    
    
    /**
     * Get non-empty test data for read-only collections
     * 
     * @return array
     */
    public function GetNonEmpty(): array
    {
        return CollectionData::GetNonEmpty();
    }
    
    
    /**
     * Get all typed test data for read-only collections
     * 
     * @return array
     */
    public function GetTyped(): array
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
    public function GetMixed(): array
    {
        return CollectionData::GetMixed();
    }
}
