<?php
namespace PHP\Tests;

require_once( __DIR__ . '/CollectionsTestCase.php' );
require_once( __DIR__ . '/IteratorData.php' );

/**
 * Test all Iterator methods to ensure consistent functionality
 */
class IteratorTest extends CollectionsTestCase
{
    
    /***************************************************************************
    *                        Iterator->current()
    ***************************************************************************/
    
    /**
     * Ensure current() returns false on invalid key
     */
    public function testCurrentReturnsFalseOnInvalidKey()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            
            // Get last key
            $key = null;
            $iterator->loop(function( $k, $v ) use ( &$key ) {
                $key = $k;
            });
            
            // Seek to an invalid entry
            if ( $key !== null ) {
                $iterator->seek( $key );
                $iterator->next();
            }
            
            // Test if current() is false
            $class = self::getClassName( $iterator );
            $this->assertFalse(
                $iterator->current(),
                "Expected {$class}->current() to return false on invalid key"
            );
        }
    }
    
    
    /**
     * Ensure current() always matches the current value in a loop
     */
    public function testCurrentMatchesValue()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            $name = self::getClassName( $iterator );
            foreach ( $iterator as $value ) {
                $this->assertEquals(
                    $value,
                    $iterator->current(),
                    "Expected {$name}->current() to return the current value in the iteration"
                );
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                        ReadOnlyCollection->key()
    ***************************************************************************/
    
    /**
     * Does key() return the key inside a loop?
     */
    public function testKeyReturnsCurrentLoopKey()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            $name = self::getClassName( $iterator );
            $iterator->loop(function( $key, $value ) use ( $iterator, $name ) {
                $this->assertEquals(
                    $key,
                    $iterator->key(),
                    "Expected {$name}->key() to return the current loop key"
                );
            });
        }
    }
    
    
    /**
     * key() should always be unique in the iterator
     */
    public function testKeyReturnsUniqueKeys()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            $key  = null;
            $name = self::getClassName( $iterator );
            $iterator->loop(function( $k, $value ) use ( $iterator, &$key, $name ) {
                $this->assertFalse(
                    ( $key === $iterator->key() ),
                    "Expected {$name}->key() to return unique keys while in loop"
                );
            });
        }
    }
    
    
    /**
     * key() should always return NULL on invalid key
     */
    public function testKeyReturnsNullOnInvalidKey()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            
            // Find the last key
            $lastKey = null;
            $iterator->loop(function( $key, $value ) use ( &$lastKey ) {
                $lastKey = $key;
            });
            
            // Set to a bad key
            if ( $lastKey !== null ) {
                $iterator->seek( $lastKey );
                $iterator->next();
            }
            
            // Test if key() returns NULL
            $name = self::getClassName( $iterator );
            $this->assertNull(
                $iterator->key(),
                "Expected {$name}->key() to return NULL on invalid key"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                        ReadOnlyCollection->loop()
    ***************************************************************************/
    
    /**
     * Test Iterator->loop() iterates over data with unique keys
     */
    public function testLoopHasUniqueKeys()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            $previousKey = null;
            $iterator->loop(function( $key, $value ) use ( &$previousKey ) {
                $this->assertFalse(
                    ( $previousKey === $key ),
                    "Expected each key in Iterator->loop() to be unique"
                );
                $previousKey = $key;
            });
        }
    }
    
    
    /**
     * Test Iterator->loop() never iterates over empty data
     */
    public function testLoopNeverIteratesOnEmptyData()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            if ( 0 !== self::countElements( $iterator )) {
                continue;
            }
            $count = 0;
            $iterator->loop(function( $key, $value ) use ( &$count ) {
                $count++;
            });
            $this->assertEquals(
                0,
                $count,
                "Expected Iterator->loop() to never iterate over empty data"
            );
        }
    }
    
    
    /**
     * Test that a returned value from Iterator->loop() returns to the caller
     */
    public function testLoopReturnsValue()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            if ( self::countElements( $iterator ) === 0 ) {
                continue;
            }
            $value = $iterator->loop( function( $key, $value ) {
                return 1;
            });
            $this->assertEquals(
                1,
                $value,
                "Expected Iterator->loop() to return the inner value to the caller"
            );
        }
    }
    
    
    /**
     * Ensure that returning any non-NULL value from the loop stops it
     */
    public function testLoopBreaksOnReturn()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            if ( self::countElements( $iterator ) === 0 ) {
                continue;
            }
            $count = 0;
            $iterator->loop(function( $key, $value ) use ( &$count ) {
                $count++;
                return 'foobar';
            });
            $this->assertEquals(
                1,
                $count,
                "Expected Iterator->loop() to break on first return statement"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                       ReadOnlyCollection->rewind()
    ***************************************************************************/
    
    /**
     * Ensure rewind() returns to the first key
     */
    public function testRewindResetsToFirstKey()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            
            // Continue on. This iterator is empty.
            if ( self::countElements( $iterator ) === 0 ) {
                continue;
            }
            
            // Find the last key and seek to it
            $firstKey = null;
            $lastKey  = null;
            $iterator->loop(function( $key, $value ) use ( &$firstKey, &$lastKey ) {
                if ( null === $firstKey ) {
                    $firstKey = $key;
                }
                $lastKey = $key;
            });
            $iterator->seek( $lastKey );
            
            // Test if rewind returns to the first key
            $name = self::getClassName( $iterator );
            $iterator->rewind();
            $this->assertEquals(
                $firstKey,
                $iterator->key(),
                "Expected {$name}->rewind() to reset internal pointer to the first key"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                        ReadOnlyCollection->seek()
    ***************************************************************************/
    
    /**
     * Seeking to a non-existing key should produce an error
     */
    public function testSeekReturnsErrorForMissingKey()
    {
        foreach ( IteratorData::GetTyped() as $iterator ) {
            foreach ( $iterator as $value ) {
                
                // Set flag if error gets thrown
                $isError = false;
                try {
                    $iterator->seek( $value );
                } catch ( \Exception $e ) {
                    $isError = true;
                }
                
                // Write test
                $this->assertTrue(
                    $isError,
                    "Expected an error from Iterator->seek() when seeking to a bad key"
                );
                break;
            }
        }
    }
    
    
    
    
    /***************************************************************************
    *                        Iterator->valid()
    ***************************************************************************/
    
    /**
    * Does valid() return false for invalid keys?
    */
    public function testValidReturnsFalseForInvalidKeys()
    {
        foreach ( IteratorData::GetTyped() as $iterator ) {
            
            // Find the last key and seek to it
            $lastKey = null;
            $iterator->loop(function( $key, $value ) use ( &$lastKey ) {
                $lastKey = $key;
            });
            
            // Seek to a bad position
            if ( $lastKey !== null ) {
                $iterator->seek( $lastKey );
                $iterator->next();
            }
            
            
            // Should be invalid after progressing to the next key
            $name = self::getClassName( $iterator );
            $this->assertFalse(
                $iterator->valid(),
                "Expected {$name}->valid() to return false for a invalid key (when the loop finishes)"
            );
        }
    }
    
    
    /**
     * Does valid() return true for valid keys?
     */
    public function testValidReturnsTrueForValidKeys()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            $name = self::getClassName( $iterator );
            $iterator->loop(function( $key, $value ) use ( $iterator, $name) {
                $iterator->seek( $key );
                $this->assertTrue(
                    $iterator->valid(),
                    "Expected {$name}->valid() to return true for a valid key"
                );
            });
        }
    }
}
