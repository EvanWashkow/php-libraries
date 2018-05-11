<?php

require_once( __DIR__ . '/DictionaryData.php' );

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
        foreach ( DictionaryData::Get() as $dictionary ) {
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
        foreach ( DictionaryData::Get() as $dictionary ) {
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
        foreach ( DictionaryData::Get() as $dictionary ) {
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
    public function testTypedDictionariesRemoveWithWrongKeyType()
    {
        foreach ( DictionaryData::GetTyped() as $dictionary ) {
            $key;
            foreach ( $dictionary as $key ) {
                break;
            }
            
            $previous = $dictionary->count();
            $isError  = false;
            try {
                $dictionary->remove( $key );
            } catch ( \Exception $e ) {
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
    }
    
    
    
    
    /***************************************************************************
    *                              Dictionary->set()
    ***************************************************************************/
    
    
    /**
     * Setting an new entry should work
     */
    public function testDictionariesSetNewKey()
    {
        foreach ( DictionaryData::Get() as $dictionary ) {
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
        foreach ( DictionaryData::Get() as $dictionary ) {
            
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
    public function testTypedDictionariesSetWithWrongKeyType()
    {
        foreach ( DictionaryData::GetTyped() as $dictionary ) {
            $isSet = false;
            $key;
            $value;
            foreach ($dictionary as $key => $value) {
                break;
            }
            try {
                $isSet = $dictionary->set( $value, $value );
            } catch (\Exception $e) {}
            
            $this->assertFalse(
                $isSet,
                "Dictionary->set() should not allow a key with the wrong type to be set"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong value type should fail
     */
    public function testTypedDictionariesSetWithWrongValueType()
    {
        foreach ( DictionaryData::GetTyped() as $dictionary ) {
            $isSet = false;
            $key;
            $value;
            foreach ($dictionary as $key => $value) {
                break;
            }
            try {
                $isSet = $dictionary->set( $key, $key );
            } catch (\Exception $e) {}
            
            $this->assertFalse(
                $isSet,
                "Dictionary->set() should not allow a value with the wrong type to be set"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                             Dictionary->clone()
    ***************************************************************************/
    
    /**
     * Cloning a Dictionary should return a Dictionary
     */
    public function testCloneReturnsDictionary()
    {
        foreach ( DictionaryData::Get() as $dictionary ) {
            $this->assertInstanceOf(
                'PHP\\Collections\\Dictionary',
                $dictionary->clone(),
                "Dictionary->clone() should return a Dictionary"
            );
        }
    }
}
