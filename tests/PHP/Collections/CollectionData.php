<?php

require_once( __DIR__ . '/DictionaryData.php' );

/**
 * Collection test data
 */
final class CollectionData
{
    
    /**
     * Get empty test data for collections
     * 
     * @return array
     */
    public function GetEmpty(): array
    {
        return array_merge(
            DictionaryData::GetEmpty()
        );
    }
    
    
    /**
     * Get non-empty test data for collections
     * 
     * @return array
     */
    public function GetNonEmpty(): array
    {
        return array_merge(
            DictionaryData::GetNonEmpty()
        );
    }
    
    
    /**
     * Get all typed test data for collections
     * 
     * @return array
     */
    public function GetTyped(): array
    {
        return array_merge(
            DictionaryData::GetTyped()
        );
    }
    
    
    /**
     * Get all mixed test data for collections
     *
     * NOTE: Do not return sequences, since their keys are not mixed
     * 
     * @return array
     */
    public function GetMixed(): array
    {
        return DictionaryData::GetMixed();
    }
}
