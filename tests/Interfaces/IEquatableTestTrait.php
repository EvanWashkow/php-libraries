<?php
declare( strict_types = 1 );

namespace PHP\Tests\Interfaces;

use PHP\Interfaces\IEquatable;

/**
 * Tests for IEquatable implementors
 */
trait IEquatableTestTrait
{


    /**
     * Tests the consistency of equals() and hash() as described on IEquatable
     * 
     * @dataProvider getEqualsAndHashConsistencyTestData
     * 
     * @param IEquatable $equatable1 The IEquatable to do the comparison
     * @param IEquatable $equatable2 The IEquatable to compare to
     * @return void
     */
    public function testEqualsAndHashConsistency( IEquatable $equatable1, IEquatable $equatable2 ): void
    {
        $this->assertTrue(
            $equatable1->equals( $equatable2 ),
            'Equatable 1 must be equal to Equatable 2 to test Hash consistency.'
        );
        $this->assertEquals(
            $equatable1->hash()->__toString(),
            $equatable2->hash()->__toString(),
            'Equatable 1\'s hash must be equal to Equatable 2\'s hash.'
        );
    }
}