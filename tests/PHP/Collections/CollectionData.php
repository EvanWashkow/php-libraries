<?php

require_once( __DIR__ . '/DictionaryData.php' );

/**
 * Collection test data
 */
final class CollectionData
{
    
    /**
     * Get all test data for collections
     * 
     * @return array
     */
    public function Get()
    {
        return array_merge(
            DictionaryData::Get()
        );
    }
    
    
    /**
     * Get all typed test data for collections
     * 
     * @return array
     */
    public function GetTyped()
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
    public function GetMixed()
    {
        return DictionaryData::GetMixed();
    }
}
