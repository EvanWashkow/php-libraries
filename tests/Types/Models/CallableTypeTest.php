<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\CallableType;


/**
 * Ensure all CallableTypes have same basic functionality
 */
class CallableTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         CallableType->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() contains 'callable'
     * 
     * @dataProvider typesProvider
     * 
     * @param CallableType $type The type instance to check
     **/
    public function testGetNames( CallableType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->getNames()->hasValue( 'callable' ),
            "{$class} implements a CallableType, therefore {$class}->getNames() should contain 'callable'"
        );
    }




    /***************************************************************************
    *                            CallableType->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'callable'
     * 
     * @dataProvider typesProvider
     * 
     * @param CallableType $type The type instance to check
     **/
    public function testIsCallable( CallableType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->is( 'callable' ),
            "{$class} implements a CallableType, therefore {$class}->is( 'callable' ) should return true"
        );
    }




    /***************************************************************************
    *                                    DATA
    ***************************************************************************/


    /**
     * Provides types for testing
     *
     * @return CallableType[]
     **/
    public function typesProvider(): array
    {
        return [
            [ Types::GetByName( 'callable' ) ], // CallableBaseType
            [ Types::GetByName( 'function' ) ], // FunctionBaseType
            [ Types::GetByName( 'substr' ) ],   // FunctionType
            [ Types::GetByName( 'Closure' ) ]   // CallableClassType
        ];
    }
}
