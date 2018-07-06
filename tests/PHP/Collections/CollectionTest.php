<?php

require_once( __DIR__ . '/CollectionData.php' );

/**
 * Test all Collection methods to ensure consistent functionality
 */
class CollectionTest extends \PHPUnit\Framework\TestCase
{
    
    /***************************************************************************
    *                           Collection->clear()
    ***************************************************************************/
    
    /**
     * Test if clearing the collection has a count of zero
     */
    public function testClearHaveNoEntries()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $collection->clear();
            $name = self::getClassName( $collection );
            $this->assertEquals(
                0,
                $collection->count(),
                "Expected {$name}->clear() to remove all elements"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                           Collection->remove()
    ***************************************************************************/
    
    /**
     * Ensure remove() has smaller count
     */
    public function testRemoveHasSmallerCount()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            $collection->loop( function( $key, $value ) use ( $collection ) {
                $collection->remove( $key );
                return 1;
            });
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertLessThan(
                $previous,
                $after,
                "Expected {$name}->remove() to have a smaller count"
            );
        }
    }
    
    
    /**
     * Ensure remove() triggers an error on missing key
     */
    public function testRemoveTriggersErrorForBadKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( 'foobar' );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->remove() to produce an error when invoked with a missing key"
            );
        }
    }
    
    
    /**
     * Ensure remove() has same count when given a missing key
     */
    public function testRemoveHasSameCountForBadKey()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( 'foobar' );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $previous,
                $after,
                "Expected {$name}->remove() with a missing key to have same count as before"
            );
        }
    }
    
    
    /**
     * Ensure remove() triggers an error on wrong key type
     */
    public function testRemoveTriggersErrorForWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $value = $collection->loop(function( $key, $value ) {
                return $value;
            });
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( $value );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->remove() to trigger an error when given the wrong key type"
            );
        }
    }
    
    
    /**
     * Ensure remove() has the same count as before when given the wrong key type
     */
    public function testRemoveHasSameCountForWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $value = $collection->loop(function( $key, $value ) {
                return $value;
            });
            $previous = $collection->count();
            $isError  = false;
            try {
                $collection->remove( $value );
            } catch ( \Exception $e ) {
                $isError = true;
            }
            $after = $collection->count();
            
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $previous,
                $after,
                "Expected {$name}->remove() with the wrong key type to have the same count as before"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                              Collection->set()
    ***************************************************************************/
    
    
    /**
     * Setting an new entry should work
     */
    public function testSetNewKey()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            $this->assertGreaterThan(
                0,
                $collection->count(),
                "Collection->set() did not correctly set a new collection entry"
            );
        }
    }
    
    
    /**
     * Setting an existing key to a different value should work
     */
    public function testSetExistingKey()
    {
        foreach ( CollectionData::GetNonEmpty() as $collection ) {
            
            // Set first key to last value
            $key   = null;
            $value = null;
            $collection->loop( function( $k, $v ) use ( &$key, &$value ) {
                if ( null === $key ) {
                    $key = $k;
                }
                $value = $v;
            });
            $collection->set( $key, $value );
            
            // Assert test
            $this->assertEquals(
                $value,
                $collection->get( $key ),
                "Collection->set() did not correctly set an existing collection entry"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong key type should fail
     */
    public function testTypedDictionariesSetWithWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $isSet = false;
            $key;
            $value;
            foreach ($collection as $key => $value) {
                break;
            }
            try {
                $isSet = $collection->set( $value, $value );
            } catch (\Exception $e) {}
            
            $this->assertFalse(
                $isSet,
                "Collection->set() should not allow a key with the wrong type to be set"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong value type should fail
     */
    public function testTypedDictionariesSetWithWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $isSet = false;
            $key;
            $value;
            foreach ($collection as $key => $value) {
                break;
            }
            try {
                $isSet = $collection->set( $key, $key );
            } catch (\Exception $e) {}
            
            $this->assertFalse(
                $isSet,
                "Collection->set() should not allow a value with the wrong type to be set"
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
        foreach ( CollectionData::GetMixed() as $collection ) {
            foreach ( $emptyKeys as $emptyKey ) {
                $collection->set( $emptyKey, 1 );
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                                UTILITIES
    ***************************************************************************/
    
    /**
     * Get the class name of the object
     *
     * @param Iterator $object The Iterator object instance
     * @return string
     */
    protected static function getClassName( Iterator $object ): string
    {
        $name = get_class( $object );
        $name = explode( '\\', $name );
        return array_pop( $name );
    }
}
