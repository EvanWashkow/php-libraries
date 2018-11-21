<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

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
     * Ensure FunctionBaseType->equals() returns true for a CallableFunctionBaseType
     */
    public function testEqualsReturnsTrueForCallableFunctionType()
    {
        $this->assertTrue(
            Types::GetByName( 'function' )->equals( Types::GetByName( 'substr' )),
            "Expected FunctionBaseType->equals() to return true for a CallableFunctionBaseType"
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
     **/
    public function testGetNamesContainsFunction()
    {
        $type = Types::GetByName( 'function' );
        $this->assertTrue(
            $type->getNames()->hasValue( 'function' ),
            'Expected CallableFunctionBaseType->getNames() to contain "function"'
        );
    }
}
