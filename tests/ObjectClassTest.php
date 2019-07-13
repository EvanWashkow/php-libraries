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
}