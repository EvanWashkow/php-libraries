<?php

require_once( __DIR__ . '/IteratorData.php' );

/**
 * Test all Iterator methods to ensure consistent functionality
 */
class IteratorTest extends \PHPUnit\Framework\TestCase
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
            foreach ( $iterator as $value ) {
                continue;
            }
            $this->assertFalse(
                $iterator->current(),
                "Iterator->current() should return false on invalid key"
            );
        }
    }
    
    
    /**
     * Ensure current() always matches the current value in a loop
     */
    public function testCurrentMatchesValue()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            foreach ( $iterator as $value ) {
                $this->assertEquals(
                    $value,
                    $iterator->current(),
                    "Expected Iterator->current() to return the current value in the iteration"
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
            $iterator->loop(function( $key, $value ) use ( $iterator ) {
                $this->assertEquals(
                    $key,
                    $iterator->key(),
                    "Expected Iterator->key() to return the current loop key"
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
            $key = null;
            $iterator->loop(function( $k, $value ) use ( $iterator, &$key ) {
                $this->assertFalse(
                    ( $key === $iterator->key() ),
                    "Expected Iterator->key() to return unique keys while in loop"
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
            
            // Find the last key and seek to it
            $lastKey = null;
            $iterator->loop(function( $key, $value ) use ( &$lastKey ) {
                $lastKey = $key;
            });
            $iterator->seek( $lastKey );
            
            // Test if the next key returns NULL
            $iterator->next();
            $this->assertNull(
                $iterator->key(),
                "Expected Iterator->key() to return NULL on invalid key"
            );
        }
    }
    
    
    
    
    /***************************************************************************
    *                        ReadOnlyCollection->seek()
    ***************************************************************************/
    
    /**
     * Seeking to the wrong key type should produce an error
     */
    public function testSeekReturnsErrorForBadKey()
    {
        foreach ( IteratorData::GetTyped() as $iterator ) {
            foreach ( $iterator as $key => $value ) {
                
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
                    "Expected an error when seeking to a key with the wrong type"
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
            foreach ( $iterator as $key => $value ) {
                continue;
            }
            
            // Should be invalid after the loop finishes
            $this->assertFalse(
                $iterator->valid(),
                "Expected Iterator->valid() to return false for a invalid key (when the loop finishes)"
            );
        }
    }


    /**
     * Does valid() return true for valid keys?
     */
    public function testValidReturnsTrueForValidKeys()
    {
        foreach ( IteratorData::Get() as $iterator ) {
            foreach ( $iterator as $key => $value ) {
                $iterator->seek( $key );
                $this->assertTrue(
                    $iterator->valid(),
                    "Expected Iterator->valid() to return true for a valid key"
                );
            }
        }
    }
}
