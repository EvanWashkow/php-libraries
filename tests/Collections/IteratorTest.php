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
