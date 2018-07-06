<?php

require_once( __DIR__ . '/DictionaryData.php' );

/**
 * Dictionary Tests
 *
 * This primarily tests the editable portion of an editable ictionary. The
 * read-only dictionary tests verify both the read-only dictionary and the
 * editable dictionary, and would be redundant to test here.
 */
class DictionaryTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                              Dictionary->set()
    ***************************************************************************/
    
    
    /**
     * Setting an new entry should work
     */
    public function testSetNewKey()
    {
        foreach ( DictionaryData::GetNonEmpty() as $dictionary ) {
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
    public function testSetExistingKey()
    {
        foreach ( DictionaryData::GetNonEmpty() as $dictionary ) {
            
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
    
    
    /**
     * Ensure set() fails when trying to set a key with an empty value
     *
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testSetErrorsOnEmptyKey()
    {
        $emptyKeys = [
            '',
            []
        ];
        foreach ( DictionaryData::GetMixed() as $dictionary ) {
            foreach ( $emptyKeys as $emptyKey ) {
                $dictionary->set( $emptyKey, 1 );
            }
        }
    }
}
