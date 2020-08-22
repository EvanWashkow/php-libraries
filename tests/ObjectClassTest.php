<?php
declare( strict_types = 1 );

namespace PHP\Tests;

use PHP\ObjectClass;
use PHPUnit\Framework\TestCase;
use PHP\Tests\ObjectClass\Value;
use PHPUnit\Framework\MockObject\MockBuilder;

/**
 * Tests ObjectClass methods
 */
class ObjectClassTest extends TestCase
{


    /**
     * Test ObjectClass->equals() returns the expected result
     * 
     * @dataProvider getEqualsTestData()
     */
    public function testEquals( ObjectClass $o1, ObjectClass $o2, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $o1->equals( $o2 ),
            'ObjectClass->equals() did not return the expected results'
        );
    }


    public function getEqualsTestData(): array
    {
        // Values
        $string_1 = new Value( '1' );
        $int_1    = new Value( 1 );
        $array    = new Value( [ 1, 2, 3 ] );

        return [
            'string_1->equals( string_1 )' => [
                $string_1, $string_1, true
            ],
            'string_1->equals( clone string_1 )' => [
                $string_1, clone $string_1, true
            ],
            'string_1->equals( int_1 )' => [
                $string_1, $int_1, false
            ],
            'array->equals( array )' => [
                $array, $array, true
            ],

            // Keep in mind that cloning the container of an array does not
            // clone the array itself. Arrays, like objects, are referenced,
            // and are not values themselves.
            'array->equals( clone array )' => [
                $array, clone $array, true
            ]
        ];
    }


    /**
     * Test hash() by comparing its results
     * 
     * @dataProvider getHashTestData
     */
    public function testHash( ObjectClass $o1, ObjectClass $o2 )
    {
        $isSameInstance = $o1 === $o2;
        $message = $isSameInstance
                 ? 'ObjectClass->hash() should be equal to itself.'
                 : 'ObjectClass->hash() should not match a different ObjectClass.';
        $this->assertEquals(
            $isSameInstance,
            $o1->hash()->__toString() === $o2->hash()->__toString(),
            $message
        );
    }

    public function getHashTestData(): array
    {
        // Objects
        $o1 = $this->createObjectClass();
        $o2 = $this->createObjectClass();

        // Seed the hash of o1, and clone o1 as o3. Cloning an object should clear its hash.
        $o1->hash();
        $o3 = clone $o1;

        // Test data
        return
        [
            'o1, o1'       => [ $o1, $o1 ],
            'o1, o2'       => [ $o1, $o2 ],

            // Cloning an Object Class should clear its hash
            'o1, clone o1' => [ $o1, $o3 ]
        ];
    }


    /**
     * Create a new Object Class
     * 
     * @return ObjectClass
     */
    public function createObjectClass(): ObjectClass
    {
        return new class extends ObjectClass {};
    }
}