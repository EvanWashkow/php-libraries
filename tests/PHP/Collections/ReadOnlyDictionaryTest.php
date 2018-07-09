<?php

require_once( __DIR__ . '/../TestCase.php' );
require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * Test all ReadOnlyDictionary methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable dictionary (the read-only
 * simply invokes the editable)
 */
class ReadOnlyDictionaryTest extends \PHP\Tests\TestCase
{
    
    /***************************************************************************
    *                          ReadOnlyDictionaryData
    ***************************************************************************/
    
    /**
     * Are all the collections valid?
     */
    public function testNonEmptyData()
    {
        foreach ( ReadOnlyDictionaryData::GetNonEmpty() as $dictionary ) {
            $this->assertNotEquals(
                0,
                $dictionary->count(),
                "ReadOnlyDictionary data is corrupt. It cannot be empty."
            );
        }
    }
    
    
    /**
     * Ensure all empty dictionaries are empty
     */
    public function testEmptyData()
    {
        foreach ( ReadOnlyDictionaryData::GetEmpty() as $dictionary ) {
            $this->assertEquals(
                0,
                $dictionary->count(),
                "Expected ReadOnlyDictionaryData::GetEmpty() to retrieve empty dictionaries"
            );
        }
    }
}
