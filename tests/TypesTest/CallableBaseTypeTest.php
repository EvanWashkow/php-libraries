<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\TypeNames;

/**
 * Tests the \PHP\Types\CallableBaseType functionality
 */
class CallableBaseTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         CallableBaseType->getNames()
    ***************************************************************************/


    /**
     * Ensure CallableBaseType->getNames() returns expected names
     **/
    public function testGetNamesReturnsNames()
    {
        $type = Types::GetByName( TypeNames::CALLABLE );
        $this->assertEquals(
            [ 'callable' ],
            $type->getNames()->toArray(),
            'CallableBaseType->getNames() didn\'t return the expected names'
        );
    }
}