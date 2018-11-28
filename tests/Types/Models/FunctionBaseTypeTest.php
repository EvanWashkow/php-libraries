<?php
namespace PHP\Tests\Types\Models;

use PHP\Types;
use PHP\Types\Models\FunctionBaseType;

/**
 * Tests the \PHP\Types\FunctionBaseType functionality
 */
class FunctionBaseTypeTest extends \PHP\Tests\TestCase
{
    
    
    /***************************************************************************
    *                           FunctionBaseType->equals()
    ***************************************************************************/
    
    
    /**
     * Ensure FunctionBaseType->equals() returns true for a FunctionBaseType
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionBaseType The function base type instance
     */
    public function testEqualsForFunctionBaseType( FunctionBaseType $type )
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( $type ),
            "FunctionBaseType->equals() should return return true for a FunctionBaseType instance"
        );
    }
    
    
    /**
     * Ensure FunctionBaseType->equals() returns false for different Type
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionBaseType The function base type instance
     */
    public function testEqualsForDifferentType( FunctionBaseType $type )
    {
        $this->assertFalse(
            $type->equals( Types::GetByName( 'null' )),
            "FunctionBaseType->equals() should return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure FunctionBaseType->equals() returns false for a value of a different type
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionBaseType The function base type instance
     */
    public function testEqualsForDifferentValueType( FunctionBaseType $type )
    {
        $this->assertFalse(
            $type->equals( 'function' ),
            "FunctionBaseType->equals() should return false for a value of a different type"
        );
    }




    /***************************************************************************
    *                      FunctionBaseType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionBaseType->getFunctionName() returns an empty string
     **/
    public function testGetFunctionNameReturnsEmptyString()
    {
        $this->assertTrue(
            '' === Types::GetByName( 'function' )->getFunctionName(),
            'Expected FunctionBaseType->getFunctionName() to always return an empty string'
        );
    }




    /***************************************************************************
    *                         FunctionBaseType->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() contains 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionBaseType $type The type instance to check
     **/
    public function testGetNames( FunctionBaseType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->getNames()->hasValue( 'function' ),
            "{$class} implements a FunctionBaseType, therefore {$class}->getNames() should contain 'function'"
        );
    }




    /***************************************************************************
    *                            FunctionBaseType->is()
    ***************************************************************************/


    /**
     * Ensure all is() returns true for 'function'
     * 
     * @dataProvider typesProvider
     * 
     * @param FunctionBaseType $type The type instance to check
     **/
    public function testIs( FunctionBaseType $type )
    {
        $class = self::getClassName( $type );
        $this->assertTrue(
            $type->is( 'function' ),
            "{$class} implements a FunctionBaseType, therefore {$class}->is( 'function' ) should return true"
        );
    }




    /***************************************************************************
    *                                    DATA
    ***************************************************************************/


    /**
     * Provides types for testing
     *
     * @return array
     **/
    public function typesProvider(): array
    {
        return [
            'FunctionBaseType' => [ Types::GetByName( 'function' ) ],
            'FunctionType' =>     [ Types::GetByName( 'substr' ) ]
        ];
    }
}
