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
            $name = self::getClassName( $collection );
            $this->assertGreaterThan(
                0,
                $collection->count(),
                "Expected {$name}->set() to set a new key"
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
            $name = self::getClassName( $collection );
            $this->assertEquals(
                $value,
                $collection->get( $key ),
                "Expected {$name}->set() to set an existing entry"
            );
        }
    }
    
    
    /**
     * Setting with the wrong key type should error
     */
    public function testSetErrorsOnWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            
            $isError = false;
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->set() to error on keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Setting with the wrong key type should fail
     */
    public function testSetRejectsWrongKeyType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            try {
                $collection->set( $value, $value );
            } catch (\Exception $e) {}
            
            $name = self::getClassName( $collection );
            $this->assertFalse(
                $collection->hasKey( $value ),
                "Expected {$name}->set() to reject keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong value type should produce errors
     */
    public function testSetErrorsOnWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            foreach ($collection as $key => $value) {
                break;
            }
            
            $isError = false;
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {
                $isError = true;
            }
            
            $name = self::getClassName( $collection );
            $this->assertTrue(
                $isError,
                "Expected {$name}->set() to error on keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Setting an with the wrong value type should fail
     */
    public function testSetRejectsWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            $key;
            $value;
            foreach ($collection as $key => $value) {
                break;
            }
            try {
                $collection->set( $key, $key );
            } catch (\Exception $e) {}
            
            $name = self::getClassName( $collection );
            $this->assertFalse(
                ( $key === $collection->get( $key ) ),
                "Expected {$name}->set() to reject keys with the wrong type"
            );
        }
    }
    
    
    /**
     * Ensure set() fails when trying to set a key with an empty value
     */
    public function testSetErrorsOnEmptyKey()
    {
        $emptyKeys = [
            '',
            []
        ];
        foreach ( CollectionData::GetMixed() as $collection ) {
            foreach ( $emptyKeys as $emptyKey ) {
                $isError = false;
                try {
                    $collection->set( $emptyKey, 1 );
                } catch (\Exception $e) {
                    $isError = true;
                }
                $name = self::getClassName( $collection );
                $this->assertTrue(
                    $isError,
                    "Expected {$name}->set() to error on an empty key"
                );
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
