<?php

require_once( __DIR__ . '/ReadOnlyDictionaryData.php' );

/**
 * Dictionary Tests
 *
 * This only tests the editable portion of a Dictionary. See ReadOnlyDictionary
 * for the read accessors
 */
class ReadOnlyDictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    
    
    
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
}
