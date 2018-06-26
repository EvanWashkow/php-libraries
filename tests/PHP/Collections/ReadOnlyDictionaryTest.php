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
     * Should error when attempting to retrieve a value with the wrong key type
     */
    public function testGetErrorsWithWrongKeyType()
    {
        foreach ( ReadOnlyDictionaryData::GetTyped() as $dictionary ) {
            $isSuccessful = false;
            $dictionary->loop(function( $key, $value ) use ( &$isSuccessful ) {
                try {
                    $dictionary->get( $value );
                } catch (\Exception $e) {}
                if ( $isSuccessful ) {
                    return $isSuccessful;
                }
            });
            $this->assertFalse(
                $isSuccessful,
                "ReadOnlyDictionary->get() should error when attempting to retrieve value the wrong key type"
            );
        }
    }
    
    
    /**
     * Trying to get value from a non-existing key should error
     */
    public function testGetErrorsWithNonExistingKey()
    {
        $dictionary = new \PHP\Collections\Dictionary( 'integer', 'string' );
        $dictionary->set( 1, 'foobar' );
        $dictionary = new \PHP\Collections\ReadOnlyDictionary( $dictionary );
        
        $isError = false;
        try {
            $dictionary->get( 2 );
        } catch (\Exception $e) {
            $isError = true;
        }
        
        $this->assertTrue(
            $isError,
            "Expected ReadOnlyDictionary->get() to error with non-existing key"
        );
    }
    
    
    /**
     * A value should be retrievable by its key
     */
    public function testGetRetrievesValue()
    {
        foreach ( ReadOnlyDictionaryData::Get() as $dictionary ) {
            $dictionary->loop(function( $key, $value ) use ( &$dictionary ) {
                $this->assertEquals(
                    $value,
                    $dictionary->get( $key ),
                    "ReadOnlyDictionary->get() did not return the value corresponding to its key"
                );
            });
        }
    }
}
