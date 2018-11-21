<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;
use PHP\Types\Models\ICallableType;


/**
 * Ensure all ICallableTypes have same basic functionality
 */
class ICallableTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         ICallableType->getNames()
    ***************************************************************************/


    /**
     * Ensure all getNames() contain 'callable'
     * 
     * @dataProvider typesProvider
     * 
     * @param ICallableType $type The type instance to check
     **/
    public function testGetNamesContainsCallable( ICallableType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->getNames()->hasValue( 'callable' ),
            "{$class} extends ICallableType, therefore {$class}->getNames() should contain 'callable'"
        );
    }




    /***************************************************************************
    *                            ICallableType->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'callable'
     * 
     * @dataProvider typesProvider
     * 
     * @param ICallableType $type The type instance to check
     **/
    public function testIsReturnsTrueForCallable( ICallableType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->is( 'callable' ),
            "{$class} extends ICallableType, therefore {$class}->is( 'callable' ) should return true"
        );
    }




    /***************************************************************************
    *                                    DATA
    ***************************************************************************/


    /**
     * Provides types for testing
     *
     * @return ICallableType[]
     **/
    public function typesProvider(): array
    {
        return [
            [ Types::GetByName( 'callable' ) ], // CallableBaseType
            [ Types::GetByName( 'function' ) ], // FunctionBaseType
            [ Types::GetByName( 'substr' ) ]    // FunctionType
        ];
    }
}
