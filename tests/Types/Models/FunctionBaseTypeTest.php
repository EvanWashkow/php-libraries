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
     */
    public function testEqualsReturnsTrueForFunctionBaseType()
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'function' )),
            "Expected FunctionBaseType->equals() to return true for a FunctionBaseType instance"
        );
    }
    
    /**
     * Ensure FunctionBaseType->equals() returns true for a FunctionBaseType
     */
    public function testEqualsReturnsTrueForFunctionType()
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'substr' )),
            "Expected FunctionBaseType->equals() to return true for a FunctionBaseType"
        );
    }
    
    
    /**
     * Ensure FunctionBaseType->equals() returns false for different Type
     */
    public function testEqualsReturnsFalseForDifferentType()
    {
        $this->assertFalse(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'null' )),
            "Expected FunctionBaseType->equals() to return false for the different Type instance"
        );
    }
    
    
    /**
     * Ensure FunctionBaseType->equals() returns false for a value of a different type
     */
    public function testEqualsReturnsFalseForDifferentValueType()
    {
        $this->assertFalse(
            Types::GetByName( 'function' )->equals( 'function' ),
            "Expected FunctionBaseType->equals() to return false for a value of a different type"
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
