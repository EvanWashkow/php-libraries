<?php
namespace PHP\Tests;

use PHPUnit\Framework\TestCase;
use PHP\Tests\ObjectClass\Value;

/**
 * Tests ObjectClass methods
 */
class ObjectClassTest extends TestCase
{


    /**
     * Ensure ObjectClass->clone() returns an exact duplicate
     * 
     * @dataProvider getCloneValues()
     */
    public function testClone( Value $value )
    {
        $this->assertEquals(
            $value,
            $value->clone(),
            'ObjectClass->clone() is not the same as the original value'
        );
    }


    /**
     * Get Clone values
     * 
     * @return array
     */
    public function getCloneValues(): array
    {
        return [
            [ new Value( [ 'a', 'b', 'c' ] ) ],
            [ new Value( [ new Value('a'), new Value('b'), new Value('c') ] ) ]
        ];
    }


    /**
     * Test ObjectClass->equals() returns the expected result
     * 
     * @dataProvider getEqualsValues()
     */
    public function testEquals( Value $v1, Value $v2, bool $expected )
    {
        $this->assertEquals(
            $expected,
            $v1->equals( $v2 ),
            'ObjectClass->equals() did not return the expected results'
        );
    }


    /**
     * Get ObjectClass->equals() test data
     * 
     * @return array
     */
    public function getEqualsValues(): array
    {
        // Values
        $string_1 = new Value( '1' );
        $int_1    = new Value( 1 );
        $array    = new Value( [ 1, 2, 3 ] );

        return [
            'string_1->equals( string_1 )' => [
                $string_1, $string_1, true
            ],
            'string_1->equals( string_1->clone() )' => [
                $string_1, $string_1->clone(), true
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
            'array->equals( array->clone() )' => [
                $array, $array->clone(), true
            ]
        ];
    }
}