<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\CallableFunctionType functionality
 */
class CallableFunctionTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                     CallableFunctionType->equals()
    ***************************************************************************/


    /**
     * Ensure CallableFunctionType equals its own CallableFunctionType
     **/
    public function testEqualsReturnsTrueForSameCallableFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $this->assertTrue(
            $referenceType->equals( $referenceType ),
            'CallableFunctionType->equals() should return true for same CallableFunctionType'
        );
    }


    /**
     * Ensure CallableFunctionType does not equal a different Type
     **/
    public function testEqualsReturnsFalseForDifferentType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'int' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'CallableFunctionType->equals() should return false for a different Type'
        );
    }


    /**
     * Ensure CallableFunctionType does not equal a generic FunctionType
     **/
    public function testEqualsReturnsFalseForFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'function' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'CallableFunctionType->equals() should return false for a generic FunctionType'
        );
    }


    /**
     * Ensure CallableFunctionType does not equal a different CallableFunctionType
     **/
    public function testEqualsReturnsFalseForDifferentCallableFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'strpos' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'CallableFunctionType->equals() should return false for a different CallableFunctionType'
        );
    }


    /**
     * Ensure CallableFunctionType does not equal any values passed in
     **/
    public function testEqualsReturnsFalseForValues()
    {
        $referenceType = Types::GetByName( 'substr' );
        $this->assertFalse(
            $referenceType->equals( 'substr' ),
            'CallableFunctionType->equals() should return false for any values passed in'
        );
    }




    /***************************************************************************
    *                 CallableFunctionType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure CallableFunctionType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            Types::GetByName( 'substr' )->getFunctionName(),
            'Expected CallableFunctionType->getFunctionName() to return the function name'
        );
    }




    /***************************************************************************
    *                    CallableFunctionType->getNames()
    ***************************************************************************/


    /**
     * Ensure getNames() returns 'function' and the function name
     **/
    public function testGetNamesReturnsFunctionAndFunctionName()
    {
        $functionName = 'substr';
        $type         = Types::GetByName( $functionName );
        $this->assertEquals(
            [ 'function', $functionName, 'callable' ],
            $type->getNames()->toArray(),
            'Expected CallableFunctionType->getNames() to return "function" and the function name'
        );
    }




    /***************************************************************************
    *                        CallableFunctionType->is()
    ***************************************************************************/


    /**
     * Ensure is() returns true for "function"
     **/
    public function testIsReturnsTrueForFunction()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'function' ),
            'CallableFunctionType->is() should return true for "function"'
        );
    }


    /**
     * Ensure is() returns true for the function name
     **/
    public function testIsReturnsTrueForTheFunctionName()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'substr' ),
            'CallableFunctionType->is() should return true for the function name'
        );
    }
    
    
    
    
    /***************************************************************************
    *                     CallableFunctionType->isCallable()
    ***************************************************************************/
    
    
    /**
     * Ensure CallableFunctionType->isCallable() returns true for functions
     */
    public function testIsFunctionReturnsTrue()
    {
        $type = \PHP\Types::GetByName( 'substr' );
        $this->assertTrue(
            $type->isCallable(),
            'Expected Type->isCallable() to return true for functions'
        );
    }
}