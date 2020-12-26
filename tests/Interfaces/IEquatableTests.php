<?php
declare( strict_types = 1 );

namespace PHP\Tests\Interfaces;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;
use PHPUnit\Framework\TestCase;

/**
 * Defines tests for IEquatable implementations
 *
 * To use this class, define a new test case, and create testX() methods (backed by dataProviders, if you so desire)
 * that call this class's methods.
 */
final class IEquatableTests extends TestCase
{


    /**
     * Test IEquatable->equals() returns the expected result
     * 
     * @param IEquatable $equatable The IEquatable to do the comparison
     * @param mixed      $value     The value to compare to
     * @param bool       $expected  The expected result of equatable->equals()
     * @return void
     */
    public function testEquals( IEquatable $equatable, $value, bool $expected ): void
    {
        $this->assertEquals(
            $expected,
            $equatable->equals( $value ),
            'equals( value ) did not return the expected results.'
        );
    }


    /**
     * Test hash() by comparing its results
     * 
     * @param IEquatable $equatable The IEquatable to test
     * @param ByteArray  $byteArray The ByteArray (hash) to test against
     * @param bool       $expected  The expected result of equatable->hash() === byte_array
     * @return void
     */
    public function testHash( IEquatable $equatable, ByteArray $byteArray, bool $expected ): void
    {
        if ( $expected ) {
            $this->assertEquals(
                $equatable->hash()->__toString(),
                $byteArray->__toString(),
                'hash() should equal the ByteArray, but does not.'
            );
        }
        else {
            $this->assertNotEquals(
                $equatable->hash()->__toString(),
                $byteArray->__toString(),
                'hash() should not equal the ByteArray, but does.'
            );
        }
    }


    /**
     * Tests the consistency of equals() and hash() as described on IEquatable
     * 
     * @param IEquatable $equatable1 The IEquatable to do the comparison
     * @param IEquatable $equatable2 The IEquatable to compare to
     * @return void
     */
    public function testEqualsAndHashConsistency( IEquatable $equatable1, IEquatable $equatable2 ): void
    {
        $this->assertTrue(
            $equatable1->equals( $equatable2 ),
            'equatable_1->equals( equatable_2 ) must return true for this test.'
        );
        $this->assertEquals(
            $equatable1->hash()->__toString(),
            $equatable2->hash()->__toString(),
            'equatable_1->hash() should equal equatable_2->hash(), but does not.'
        );
    }
}