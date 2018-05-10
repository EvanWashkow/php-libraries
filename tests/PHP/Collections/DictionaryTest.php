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
    public function testDictionaryClearHaveNoEntries()
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
     * Does removing a key with a non-existing key fail?
     */
    public function testDictionaryRemoveWithNonExistingKey()
    {
        foreach ( $this->getDictionaries() as $dictionary ) {
            $previous = $dictionary->count();
            $isError  = false;
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
    }
    
    
    /**
     * Does removing a key with the wrong key type fail?
     */
    public function testTypedDictionaryRemoveWithWrongKeyType()
    {
        $dictionary = $this->getTypedDictionary();
        $previous   = $dictionary->count();
        $isError    = false;
        try {
            $dictionary->remove( 1 );
        } catch ( \Exception $e ) {
            $isError = true;
        }
        $after = $dictionary->count();
    
        $this->assertEquals(
            $previous,
            $after,
            "Dictionary->remove() should not be able to re
    
    
    /**
     * Retrieve collection tests, indexed by their type
     */
    public function getTests()
    {
        // code...
    }move a key with the wrong type"
        );
        $this->assertTrue(
            $isError,
            "Dictionary->remove() did not produce an error when invoked with the wrong key type"
        );
    }
    
    
    
    
    /***************************************************************************
    *                              Dictionary->set()
    ***************************************************************************/
    
    /**
     * Do the dummy Dictionaries have entries?
     */
    public function testDictionariesSetHaveEntries()
    {
        foreach ( $this->getDictionaries() as $dictionary ) {
            $this->assertGreaterThan(
                0,
                $dictionary->count(),
                "Dictionary->set() doesn't have any entries"
            );
        }
    }
    
    
    /**
     * Setting an new entry should work
     */
    public function testDictionariesSetNewKey()
    {
        foreach ( $this->getDictionaries() as $dictionary ) {
            $this->assertGreaterThan(
                0,
                $dictionary->count(),
                "Dictionary->set() did not correctly set a new dictionary entry"
            );
        }
    }
    
    
    /**
     * Setting an existing key to a different value should work
     */
    public function testDictionariesSetExistingKey()
    {
        foreach ( $this->getDictionaries() as $dictionary ) {
            
            // Set first key to last value
            $key   = null;
            $value = null;
            $dictionary->loop( function( $k, $v ) use ( &$key, &$value ) {
                if ( null === $key ) {
                    $key = $k;
                }
                $value = $v;
            });
            $dictionary->set( $key, $value );
            
            // Assert test
            $this->assertEquals(
                $value,
                $dictionary->get( $key ),
                "Dictionary->set() did not correctly set an existing dictionary entry"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong key type should fail
     */
    public function testTypedDictionarySetWithWrongKeyType()
    {
        $dictionary = $this->getTypedDictionary();
        $isError = false;
        try {
            $dictionary->set( 1, 'foobar' );
        } catch (\Exception $e) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            "Dictionary->set() should not allow a key with the wrong type to be set"
        );
    }
    
    
    /**
     * Setting an with the wrong value type should fail
     */
    public function testTypedDictionarySetWithWrongValueType()
    {
        $dictionary = $this->getTypedDictionary();
        $isError = false;
        try {
            $dictionary->set( 'foo', 'bar' );
        } catch (\Exception $e) {
            $isError = true;
        }
        $this->assertTrue(
            $isError,
            "Dictionary->set() should not allow a value with the wrong type to be set"
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
            $this->getTypedDictionary(),
            $this->getMixedDictionary()
        ];
    }
    
    
    /**
     * Return sample Dictionary with string keys and integer values
     *
     * @return Dictionary
     */
    public function getTypedDictionary(): Dictionary
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
        foreach ( $this->getTypedDictionary() as $key => $value) {
            $dictionary->set( $key, $value );
            $dictionary->set( $value, $key );
        }
        return $dictionary;
    }
}
