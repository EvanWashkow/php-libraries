<?php

use PHP\Collections\Dictionary;

/**
 * Dictionary Tests
 *
 * This only tests the editable portion of a Dictionary. See ReadOnlyDictionary
 * for the read accessors
 */
class DictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                           Dictionary->clear()
    ***************************************************************************/
    
    /**
     * Test if clearing the dictionary has a count of zero
     */
    public function testDictionaryClearHasCountOfZero()
    {
        $dictionary = $this->getStringStringDictionary();
        $dictionary->clear();
        $this->assertTrue(
            ( 0 === $dictionary->count() ),
            "Dictionary->clear() returned a non-zero count"
        );
    }
    
    
    
    
    /***************************************************************************
    *                           Dictionary->remove()
    ***************************************************************************/
    
    /**
     * Does removing a key from the dictionary remove the key?
     */
    public function testDictionaryRemoveHasSmallerCount()
    {
        $dictionary = $this->getStringStringDictionary();
        $previous   = $dictionary->count();
        $dictionary->remove( 'a' );
        $after      = $dictionary->count();
        $this->assertLessThan(
            $previous,
            $after,
            "Dictionary->remove( 'a' ) has the same number of keys as before"
        );
    }
    
    
    /**
     * Does removing a key with the wrong key type fail?
     */
    public function testRemoveWithWrongKeyType()
    {
        $dictionary = $this->getStringStringDictionary();
        $previous   = $dictionary->count();
        $isError    = false;
        try {
            $dictionary->remove( 1 );
        } catch (\Exception $e) {
            $isError = true;
        }
        $after = $dictionary->count();
        
        $this->assertEquals(
            $previous,
            $after,
            "Dictionary->remove() should not be able to remove a key with the wrong type"
        );
        $this->assertTrue(
            $isError,
            "Dictionary->remove() did not produce an error when invoked with the wrong key type"
        );
    }
    
    
    /**
     * Does removing a key with a non-existing key fail?
     */
    public function testRemoveWithNonExistingKey()
    {
        $dictionary = $this->getStringStringDictionary();
        $previous   = $dictionary->count();
        $isError    = false;
        try {
            $dictionary->remove( 'foobar' );
        } catch (\Exception $e) {
            $isError = true;
        }
        $after = $dictionary->count();
        
        $this->assertEquals(
            $previous,
            $after,
            "Dictionary->remove() should not be able to remove a key that doesn't exist"
        );
        $this->assertTrue(
            $isError,
            "Dictionary->remove() did not produce an error when invoked with a non-existing key"
        );
    }
    
    
    
    
    /***************************************************************************
    *                               UTILITIES
    ***************************************************************************/
    
    /**
     * Return sample Dictionary with string keys and string values
     *
     * @return Dictionary
     */
    public function getStringStringDictionary(): Dictionary
    {
        // For each entry, a-z, map it to the character at the other end
        $start = 97;
        $end   = 122;
        $dictionary = new Dictionary( 'string', 'string' );
        for ( $ascii = $start; $ascii <= $end; $ascii++ ) {
            $key   = chr( $ascii );
            $value = chr( ( $start + $end ) - $ascii );
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
}
