<?php

require_once( __DIR__ . '/IteratorData.php' );

/**
 * Test all Iterator methods for consistent functionality
 */
class IteratorTest extends \PHPUnit\Framework\TestCase
{
    
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
