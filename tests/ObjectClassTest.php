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
        $isEqual = $o1 === $o2;
        $message = $isEqual
                 ? 'ObjectClass->hash() should be equal to itself.'
                 : 'ObjectClass->hash() should be different than another ObjectClass->hash().';
        $this->assertEquals(
            $isEqual,
            $o1->hash()->__toString() === $o2->hash()->__toString(),
            $message
        );
    }

    public function getHashTestData(): array
    {
        // Objects
        $builder = $this->createObjectClassMockBuilder()->setMethodsExcept([ 'hash' ]);
        $o1 = $builder->getMock();
        $o2 = $builder->getMock();

        // Test data
        return [
            'o1, o1' => [ $o1, $o1 ],
            'o1, o2' => [ $o1, $o2 ]
        ];
    }


    /**
     * Create a new Object Class
     * 
     * @return MockBuilder
     */
    public function createObjectClassMockBuilder(): MockBuilder
    {
        return $this->getMockBuilder( ObjectClass::class );
    }
}