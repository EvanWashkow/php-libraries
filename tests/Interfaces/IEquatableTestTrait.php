<?php
declare( strict_types = 1 );

namespace PHP\Tests\Interfaces;

use PHP\Collections\ByteArray;
use PHP\Interfaces\IEquatable;

/**
 * Tests for IEquatable implementors
 */
trait IEquatableTestTrait
{


    /**
     * Test IEquatable->equals() returns the expected result
     * 
     * @dataProvider getEqualsTestData()
     * 
     * @param IEquatable $equatable The IEquatable to do the comparison
     * @param mixed      $value      The value to compare to
     * @param bool       $expected   The expected result of equatable->equals()
     * @return void
     */
    final public function testEquals( IEquatable $equatable, $value, bool $expected ): void
    {
        $this->assertEquals(
            $expected,
            $equatable->equals( $value ),
            'equatable->equals( value ) did not return the expected results.'
        );
    }


    /**
     * Test hash() by comparing its results
     * 
     * @dataProvider getHashTestData
     * 
     * @param IEquatable $equatable The IEquatable to test
     * @param ByteArray  $byteArray The ByteArray (hash) to test against
     * @param bool       $expected  The expected result of equatable->hash() === byte_array
     * @return void
     */
    final public function testHash( IEquatable $equatable, ByteArray $byteArray, bool $expected ): void
    {
        if ( $expected ) {
            $this->assertEquals(
                $equatable->hash()->__toString(),
                $byteArray->__toString(),
                'equatable->hash() is not equal to byte_array, but should not be.'
            );
        }
        else {
            $this->assertNotEquals(
                $equatable->hash()->__toString(),
                $byteArray->__toString(),
                'equatable->hash() is equal to byte_array, but should not be.'
            );
        }
    }


    /**
     * Tests the consistency of equals() and hash() as described on IEquatable
     * 
     * @dataProvider getEqualsAndHashConsistencyTestData
     * 
     * @param IEquatable $equatable1 The IEquatable to do the comparison
     * @param IEquatable $equatable2 The IEquatable to compare to
     * @return void
     */
    final public function testEqualsAndHashConsistency( IEquatable $equatable1, IEquatable $equatable2 ): void
    {
        $this->assertTrue(
            $equatable1->equals( $equatable2 ),
            'equatable_1 must be equal to equatable_2 to test Hash consistency.'
        );
        $this->assertEquals(
            $equatable1->hash()->__toString(),
            $equatable2->hash()->__toString(),
            'equatable_1\'s hash must be equal to equatable_2\'s hash.'
        );
    }
}