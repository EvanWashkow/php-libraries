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
        $string1 = new Value( '1' );
        $int1    = new Value( 1 );

        return [
            'string1->equals( string1 )' => [
                $string1, $string1, true
            ],
            'string1->equals( string1->clone() )' => [
                $string1, $string1->clone(), true
            ],
            'string1->equals( int1 )' => [
                $string1, $int1, false
            ]
        ];
    }
}