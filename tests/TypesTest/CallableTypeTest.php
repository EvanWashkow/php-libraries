<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\TypeNames;

/**
 * Tests the \PHP\Types\CallableType functionality
 */
class CallableTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         CallableType->getNames()
    ***************************************************************************/


    /**
     * Ensure CallableType->getNames() returns expected names
     **/
    public function testGetNamesReturnsNames()
    {
        $type = Types::GetByName( TypeNames::CALLABLE_TYPE_NAME );
        $this->assertEquals(
            [ 'callable' ],
            $type->getNames()->toArray(),
            'CallableType->getNames() didn\'t return the expected names'
        );
    }
}