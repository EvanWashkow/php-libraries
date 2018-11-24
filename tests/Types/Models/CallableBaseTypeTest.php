<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\CallableBaseType;


/**
 * Test CallableBaseType
 */
class CallableBaseTypeTest extends \PHPUnit\Framework\TestCase
{


    /**
     * Ensure Types::GetByName() returns CallableBaseType instance
     **/
    public function testTypesLookupReturn()
    {
        $this->assertInstanceOf(
            CallableBaseType::class,
            Types::GetByName( 'callable' ),
            'Types::GetByName( \'callable\' ) should return a CallableBaseType instance'
        );
    }
}