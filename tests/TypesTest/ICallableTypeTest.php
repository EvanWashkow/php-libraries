<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;


/**
 * Ensure all ICallableTypes have same basic functionality
 */
class ICallableTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                         ICallableType->getNames()
    ***************************************************************************/


    /**
     * Ensure all getNames() returns contains 'callable'
     **/
    public function testGetNamesContainsCallable()
    {
        foreach ( self::getTypes() as $type ) {
            $class = self::getClassName( $type );
            $this->assertTrue(
                $type->getNames()->hasValue( 'callable' ),
                "{$class} extends ICallableType, therefore {$class}->getNames() should contain 'callable'"
            );
        }
    }




    /***************************************************************************
    *                            ICallableType->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'callable'
     **/
    public function testIsReturnsTrueForCallable()
    {
        foreach ( self::getTypes() as $type ) {
            $class = self::getClassName( $type );
            $this->assertTrue(
                $type->is( 'callable' ),
                "{$class} extends ICallableType, therefore {$class}->is( 'callable' ) should return true"
            );
        }
    }




    /***************************************************************************
    *                            LIST OF ICallableTypes
    ***************************************************************************/


    /**
     * Retrieve list of ICallableTypes
     * 
     * @return Types\Model\Type[]
     **/
    private static function getTypes(): array
    {
        return [
            Types::GetByName( 'callable' ), // CallableBaseType
            Types::GetByName( 'function' ), // FunctionBaseType
            Types::GetByName( 'substr' )    // FunctionType
        ];
    }
}
