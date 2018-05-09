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
        foreach ( $this->getDictionaries() as $dictionary ) {
            $dictionary->clear();
            $this->assertEquals(
                0,
                $dictionary->count(),
                "Dictionary->clear() returned a non-zero count"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                           Dictionary->remove()
    ***************************************************************************/
    
    /**
     * Does removing a key from the dictionary remove the key?
     */
    public function testDictionaryRemoveHasSmallerCount()
    {
        foreach ( $this->getDictionaries() as $dictionary ) {
            $previous = $dictionary->count();
            foreach ( $dictionary as $key => $value ) {
                $dictionary->remove( $key );
                break;
            }
            $after = $dictionary->count();
            $this->assertLessThan(
                $previous,
                $after,
                "Dictionary->remove( 'a' ) has the same number of keys as before"
            );
        }
    }
    
    
    /**
     * Does removing a key with the wrong key type fail?
     */
    public function testStringStringRemoveWithWrongKeyType()
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
    public function testStringStringRemoveWithNonExistingKey()
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
     * Retrieve all test dictionaries
     *
     * @return array
     */
    public function getDictionaries(): array
    {
        return [
            $this->getIntStringDictionary(),
            $this->getStringStringDictionary(),
            $this->getStringIntDictionary(),
            $this->getMixedDictionary()
        ];
    }
    
    
    /**
     * Return sample Dictionary with integer keys and string values
     *
     * @return Dictionary
     */
    public function getIntStringDictionary(): Dictionary
    {
        // Map 1-26 to a-z
        $start = 97;
        $end   = 122;
        $dictionary = new Dictionary( 'integer', 'string' );
        for ( $ascii = $start; $ascii <= $end; $ascii++ ) {
            $key   = ( $ascii - $start ) + 1;
            $value = chr( $ascii );
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
    
    
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
    
    
    /**
     * Return sample Dictionary with string keys and integer values
     *
     * @return Dictionary
     */
    public function getStringIntDictionary(): Dictionary
    {
        // Map 1-26 to a-z
        $start = 97;
        $end   = 122;
        $dictionary = new Dictionary( 'string', 'integer' );
        for ( $ascii = $start; $ascii <= $end; $ascii++ ) {
            $key   = chr( $ascii );
            $value = ( $ascii - $start ) + 1;
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
    
    
    /**
     * Retrieve sample Dictionary with mixed string and value types
     *
     * @return Dictionary
     */
    public function getMixedDictionary(): Dictionary
    {
        $dictionary = new Dictionary();
        foreach ( $this->getIntStringDictionary() as $key => $value) {
            $dictionary->set( $key, $value );
        }
        foreach ( $this->getStringStringDictionary() as $key => $value) {
            $dictionary->set( $key, $value );
        }
        foreach ( $this->getStringIntDictionary() as $key => $value) {
            $dictionary->set( $key, $value );
        }
        return $dictionary;
    }
}
