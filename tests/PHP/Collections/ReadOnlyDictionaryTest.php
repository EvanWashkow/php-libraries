<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * Dictionary Tests
 *
 * This tests both the read-only and the editable dictionary (the read-only
 * simply invokes the editable)
 */
class ReadOnlyDictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                          ReadOnlyDictionaryData
    ***************************************************************************/
    
    /**
     * Are all the collections valid?
     */
    public function testData()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $this->assertNotEquals(
                0,
                $dictionary->count(),
                "ReadOnlyDictionary data is corrupt. It cannot be empty."
            );
        }
    }
    
    
    
    
    
    /***************************************************************************
    *                         ReadOnlyDictionary->clone()
    ***************************************************************************/
    
    /**
     * Cloning a dictionary should clone all the entries
     */
    public function testCloneCopiesAllEntries()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $clone = $dictionary->clone();
            $clone->loop( function( $key, $value ) use ( $dictionary ) {
                $this->assertTrue(
                    $dictionary->hasKey( $key ),
                    "Dictionary->clone() entry does not have the same key"
                );
                $this->assertEquals(
                    $value,
                    $dictionary->get( $key ),
                    "ReadOnlyDictionary->clone() entry does not have the same value"
                );
            });
        }
    }
    
    /**
     * Cloning a Dictionary should return a Dictionary
     */
    public function testCloneReturnsReadOnlyDictionary()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $this->assertInstanceOf(
                'PHP\\Collections\\ReadOnlyDictionary',
                $dictionary->clone(),
                "ReadOnlyDictionary->clone() should return a ReadOnlyDictionary"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                         ReadOnlyDictionary->count()
    ***************************************************************************/
    
    /**
     * Count returns the number of items
     */
    public function testCountIsAccurateForNonEmpty()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $count = 0;
            $dictionary->loop( function( $key, $value ) use ( &$count ) {
                $count++;
            });
            $this->assertEquals(
                $count,
                $dictionary->count(),
                'ReadOnlyDictionary->count() returned the wrong number of items on a non-empty Dictionary'
            );
        }
    }
    
    /**
     * Count returns the number of items
     */
    public function testCountIsZeroForEmpty()
    {
        $dictionary = new \PHP\Collections\Dictionary();
        $dictionary = new \PHP\Collections\ReadOnlyDictionary( $dictionary );
        $this->assertEquals(
            0,
            $dictionary->count(),
            "ReadOnlyDictionary->count() returned {$dictionary->count()} on an empty Dictionary"
        );
    }
    
    
    
    
    /***************************************************************************
    *                         ReadOnlyDictionary->get()
    ***************************************************************************/
    
    /**
     * A value should be retrievable by its key
     */
    public function testGetRetrievesValue()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $key;
            $value;
            $dictionary->loop(function($k, $v) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return -1;
            });
            $this->assertEquals(
                $value,
                $dictionary->get( $key ),
                "ReadOnlyDictionary->get() did not return the value corresponding to its key"
            );
        }
    }
    
    
    /**
     * Should not be able to retrieve a value from the dictionary with the wrong
     * key type
     */
    public function testTypedDictionaryGetWithWrongKeyType()
    {
        foreach ( ReadOnlyDictionaryData::GetTyped() as $dictionary ) {
            $isSuccessful = false;
            $dictionary->loop(function( $key, $value ) use ( &$isSuccessful ) {
                try {
                    $isSuccessful = $dictionary->get( $value );
                } catch (\Exception $e) {}
                if ( $isSuccessful ) {
                    return $isSuccessful;
                }
            });
            $this->assertFalse(
                $isSuccessful,
                "ReadOnlyDictionary->get() should not be able to retrieve with the wrong type"
            );
        }
    }
}
