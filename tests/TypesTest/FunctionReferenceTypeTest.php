<?php
namespace PHP\Tests\TypesTest;

use PHP\Types;

/**
 * Tests the \PHP\Types\FunctionReferenceType functionality
 */
class FunctionReferenceTypeTest extends \PHP\Tests\TestCase
{


    /***************************************************************************
    *                     FunctionReferenceType->equals()
    ***************************************************************************/


    /**
     * Ensure FunctionReferenceType equals its own FunctionReferenceType
     **/
    public function testEqualsReturnsTrueForSameFunctionReferenceType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $this->assertTrue(
            $referenceType->equals( $referenceType ),
            'FunctionReferenceType->equals() should return true for same FunctionReferenceType'
        );
    }


    /**
     * Ensure FunctionReferenceType does not equal a different Type
     **/
    public function testEqualsReturnsFalseForDifferentType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'int' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionReferenceType->equals() should return false for a different Type'
        );
    }


    /**
     * Ensure FunctionReferenceType does not equal a generic FunctionType
     **/
    public function testEqualsReturnsFalseForFunctionType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'function' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionReferenceType->equals() should return false for a generic FunctionType'
        );
    }


    /**
     * Ensure FunctionReferenceType does not equal a different FunctionReferenceType
     **/
    public function testEqualsReturnsFalseForDifferentFunctionReferenceType()
    {
        $referenceType = Types::GetByName( 'substr' );
        $otherType     = Types::GetByName( 'strpos' );
        $this->assertFalse(
            $referenceType->equals( $otherType ),
            'FunctionReferenceType->equals() should return false for a different FunctionReferenceType'
        );
    }


    /**
     * Ensure FunctionReferenceType does not equal any values passed in
     **/
    public function testEqualsReturnsFalseForValues()
    {
        $referenceType = Types::GetByName( 'substr' );
        $this->assertFalse(
            $referenceType->equals( 'substr' ),
            'FunctionReferenceType->equals() should return false for any values passed in'
        );
    }




    /***************************************************************************
    *                 FunctionReferenceType->getFunctionName()
    ***************************************************************************/


    /**
     * Ensure FunctionReferenceType->getFunctionName() returns the function name
     **/
    public function testGetFunctionNameReturnsName()
    {
        $this->assertEquals(
            'substr',
            Types::GetByName( 'substr' )->getFunctionName(),
            'Expected FunctionReferenceType->getFunctionName() to return the function name'
        );
    }




    /***************************************************************************
    *                    FunctionReferenceType->getNames()
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
            'Expected FunctionReferenceType->getNames() to return "function" and the function name'
        );
    }




    /***************************************************************************
    *                        FunctionReferenceType->is()
    ***************************************************************************/


    /**
     * Ensure is() returns true for "function"
     **/
    public function testIsReturnsTrueForFunction()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'function' ),
            'FunctionReferenceType->is() should return true for "function"'
        );
    }


    /**
     * Ensure is() returns true for the function name
     **/
    public function testIsReturnsTrueForTheFunctionName()
    {
        $this->assertTrue(
            Types::GetByName( 'substr' )->is( 'substr' ),
            'FunctionReferenceType->is() should return true for the function name'
        );
    }
    
    
    
    
    /***************************************************************************
    *                     FunctionReferenceType->isCallable()
    ***************************************************************************/
    
    
    /**
     * Ensure FunctionReferenceType->isCallable() returns true for functions
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