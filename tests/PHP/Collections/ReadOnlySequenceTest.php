<?php

require_once( __DIR__ . '/../TestCase.php' );
require_once( __DIR__ . '/ReadOnlySequenceData.php' );

/**
 * Test all ReadOnlySequence methods to ensure consistent functionality
 *
 * This tests both the read-only and the editable sequnce (the read-only
 * simply invokes the editable)
 */
class ReadOnlySequenceTest extends \PHP\Tests\TestCase
{
    
    /***************************************************************************
    *                       ReadOnlySequence->toArray()
    ***************************************************************************/
    
    /**
     * Ensure toArray() returns an array
     */
    public function testToArrayReturnsArray()
    {
        foreach ( ReadOnlySequenceData::Get() as $sequence ) {
            $class = self::getClassName( $sequence );
            $this->assertTrue(
                is( $sequence->toArray(), 'array' ),
                "Expected {$class}->toArray() to return an array"
            );
        }
    }
}
