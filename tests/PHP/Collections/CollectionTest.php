<?php

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/CollectionData.php' );

/**
 * Test all Collection methods to ensure consistent functionality
 */
class CollectionTest extends \PHP\Tests\Collections\CollectionsTestCase
{
    
    /***************************************************************************
    *                           Collection->clear()
    ***************************************************************************/
    
    /**
     * Ensure clear() has no entries
     */
    public function testClearHasNoEntries()
    {
        foreach ( CollectionData::Get() as $collection ) {
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
        foreach ( CollectionData::Get() as $collection ) {
            $previous = $collection->count();
            if ( 0 === $previous ) {
                continue;
            }
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
     * Ensure set() with a new key works
     */
    public function testSetNewKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            if ( 0 === $collection->count() ) {
                continue;
            }
            
            // Get first key and value
            $key   = null;
            $value = null;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
            $collection->clear();
            
            // Test if set works
            $collection->set( $key, $value );
            $name = self::getClassName( $collection );
            $this->assertGreaterThan(
                0,
                $collection->count(),
                "Expected {$name}->set() to set a new key"
            );
        }
    }
    
    
    /**
     * Ensure set() with an existing key works
     */
    public function testSetExistingKey()
    {
        foreach ( CollectionData::Get() as $collection ) {
            
            // Continue on. This collection has no data.
            if ( $collection->count() === 0 ) {
                continue;
            }
            
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
     * Ensure set() errors when given wrong key type
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
     * Ensure set() rejects keys of the wrong type
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
     * Ensure set() errors when given wrong value type
     */
    public function testSetErrorsOnWrongValueType()
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
     * Ensure set() rejects values of the wrong type
     */
    public function testSetRejectsWrongValueType()
    {
        foreach ( CollectionData::GetTyped() as $collection ) {
            if ( $collection->count() === 0 ) {
                continue;
            }
            
            $key;
            $value;
            $collection->loop(function( $k, $v ) use ( &$key, &$value ) {
                $key   = $k;
                $value = $v;
                return 1;
            });
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
}
